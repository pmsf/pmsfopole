<?php

namespace Scanner;

class MAD extends Scanner
{
    public function query_overview($selectedGeofence)
    {
      global $db, $geofences;

      $whereGeofenceSQL = '';
      $andGeofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $whereGeofenceSQL = " WHERE (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
          $andGeofenceSQL = " AND (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $pokemon = $db->query("SELECT count(*) AS pokemon_count FROM pokemon WHERE disappear_time > UTC_TIMESTAMP() $andGeofenceSQL")->fetch();
      $gym = $db->query("SELECT COUNT(*) AS gym_count FROM gym $whereGeofenceSQL")->fetch();
      $pokestop = $db->query("SELECT COUNT(*) AS pokestop_count FROM pokestop $whereGeofenceSQL")->fetch();

      $raid = $db->query("
        SELECT
          COUNT(*) AS raid_count
        FROM raid
        LEFT JOIN gym ON raid.gym_id = gym.gym_id
        WHERE raid.end > UTC_TIMESTAMP() $andGeofenceSQL
      ")->fetch();

      $data = array();
    
      $overview['pokemon_count'] = $pokemon['pokemon_count'];
      $overview['gym_count'] = $gym['gym_count'];
      $overview['raid_count'] = $raid['raid_count'];
      $overview['pokestop_count'] = $pokestop['pokestop_count'];

      $data[] = $overview;
      return $data;
    }

    public function query_teams($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " WHERE (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $teams = $db->query("
        SELECT 
          SUM(team_id = 0) AS neutral_count,
          SUM(team_id = 1) AS mystic_count,
          SUM(team_id = 2) AS valor_count,
          SUM(team_id = 3) AS instinct_count
        FROM gym
        $geofenceSQL"
      )->fetch();

      $data = array();

      $team['neutral_count'] = $teams['neutral_count'];
      $team['mystic_count'] = $teams['mystic_count'];
      $team['valor_count'] = $teams['valor_count'];
      $team['instinct_count'] = $teams['instinct_count'];

      $data[] = $team;
      return $data;
    }

    public function query_pokestops($selectedGeofence)
    {
      global $db, $geofences;

      $whereGeofenceSQL = '';
      $andGeofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $whereGeofenceSQL = " WHERE (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
          $andGeofenceSQL = " AND (ST_WITHIN(point(p.latitude, p.longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $pokestops = $db->query("
        SELECT
          SUM(incident_expiration > UTC_TIMESTAMP()) AS rocket,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 501) AS normal_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 502) AS glacial_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 503) AS mossy_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 504) AS magnetic_lure
        FROM pokestop
        $whereGeofenceSQL"
      )->fetch();

      $quests = $db->query("
        SELECT
          COUNT(*) AS count
        FROM trs_quest tq
        LEFT JOIN pokestop p ON p.pokestop_id = tq.GUID
        WHERE tq.quest_timestamp >= UNIX_TIMESTAMP(CURDATE()) $andGeofenceSQL"
      )->fetch();

      $data = array();

      $pokestop['quest'] = $quests['count'];
      $pokestop['rocket'] = $pokestops['rocket'];
      $pokestop['normal_lure'] = $pokestops['normal_lure'];
      $pokestop['glacial_lure'] = $pokestops['glacial_lure'];
      $pokestop['mossy_lure'] = $pokestops['mossy_lure'];
      $pokestop['magnetic_lure'] = $pokestops['magnetic_lure'];

      $data[] = $pokestop;
      return $data;
    }

    public function query_spawnpoints($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " WHERE (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $spawnpoints = $db->query("
        SELECT
          COUNT(*) AS total,
          SUM(last_scanned IS NOT NULL) AS found,
          SUM(last_scanned IS NULL) AS missing
        FROM trs_spawn
        $geofenceSQL"
      )->fetch();

      $data = array();

      $spawnpoint['total'] = $spawnpoints['total'];
      $spawnpoint['found'] = $spawnpoints['found'];
      $spawnpoint['missing'] = $spawnpoints['missing'];

      $data[] = $spawnpoint;
      return $data;
    }

    public function query_raids($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $raids = $db->query("
        SELECT
          COUNT(*) AS count,
          raid.level AS lvl,
          raid.pokemon_id AS id,
          raid.form AS form,
          raid.costume AS costume
        FROM raid
        LEFT JOIN gym ON raid.gym_id = gym.gym_id
        WHERE end >= UTC_TIMESTAMP() and raid.level >= 1 $geofenceSQL
        GROUP BY raid.level, raid.pokemon_id, raid.form, raid.costume"
      );
      $total = $db->query("
        SELECT
          COUNT(*) AS total
        FROM raid
        LEFT JOIN gym ON raid.gym_id = gym.gym_id
        WHERE end >= UTC_TIMESTAMP() $geofenceSQL
      ")->fetch();

      $data = array();
      foreach ($raids as $raid) {
        $raidboss["lvl"] = $raid["lvl"];
        $raidboss["id"] = $raid["id"];
        $raidboss["form"] = $raid["form"];
        $raidboss["costume"] = $raid["costume"];
        $raidboss["count"] = $raid["count"];
        if ($raid["id"] > 0) {
          $raidboss["name"] = i8ln($this->pokedex[$raid['id']]["name"]);
        } else {
          $raidboss["name"] = i8ln('lvl') . ' ' . $raid['lvl'] . ' ' . i8ln('egg');
        }
        $raidboss["percentage"] = round(100 / $total["total"] * $raid["count"], 3) . '%';
        $data[] = $raidboss;
      }
      return $data;
    }

    public function query_raid_dashboard($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(gym.latitude, gym.longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $raids = $db->query("
        SELECT
          gym.latitude AS lat,
          gym.longitude AS lon,
          gym.team_id,
          gym.is_ex_raid_eligible AS ex_raid_eligible,
          gymdetails.name,
          gymdetails.url,
          Unix_timestamp(Convert_tz(start, '+00:00', @@global.time_zone)) AS raid_battle_timestamp,
          Unix_timestamp(Convert_tz(end, '+00:00', @@global.time_zone)) AS raid_end_timestamp,
          raid.pokemon_id AS raid_pokemon_id,
          raid.form AS raid_pokemon_form,
          raid.costume AS raid_pokemon_costume,
          raid.level AS raid_level,
          raid.move_1 AS raid_pokemon_move_1,
          raid.move_2 AS raid_pokemon_move_2,
        FROM gym
        LEFT JOIN gymdetails
        ON gym.gym_id = gymdetails.gym_id
        LEFT JOIN raid
        ON gym.gym_id = raid.gym_id
        WHERE raid.end >= UTC_TIMESTAMP() AND gymdetails.name is not null $geofenceSQL"
      );

      $data = array();
      foreach ($raids as $raid) {
        $raidboss["raid_pokemon_level"] = $raid["raid_level"];
        $raidboss["raid_pokemon_id"] = $raid["raid_pokemon_id"];
        $raidboss["raid_pokemon_form"] = $raid["raid_pokemon_form"];
        $raidboss["raid_pokemon_costume"] = $raid["raid_pokemon_costume"];
        $raidboss["gym_name"] = $raid["name"];
        $raidboss["lat"] = $raid["lat"];
        $raidboss["lon"] = $raid["lon"];
        $raidboss["url"] = !empty($raid["url"]) ? preg_replace("/^http:/i", "https:", $raid["url"]) : 'static/images/missing.png';
        $raidboss["raid_end"] = $raid["raid_end_timestamp"];
        $raidboss["raid_start"] = $raid["raid_battle_timestamp"];
        $raidboss["ex_gym"] = $raid["ex_raid_eligible"];
        $raidboss["team"] = $raid["team_id"];

        if ($raid["raid_pokemon_id"] > 0) {
          $raidboss["raid_pokemon_name"] = i8ln($this->pokedex[$raid['raid_pokemon_id']]["name"]);
          $raidboss["raid_pokemon_move_1"] = i8ln($this->move[$raid["raid_pokemon_move_1"]]["name"]);
          $raidboss["raid_pokemon_move_2"] = i8ln($this->move[$raid["raid_pokemon_move_2"]]["name"]);
          $raidboss["raid_pokemon_move_1_type"] = $this->move[$raid["raid_pokemon_move_1"]]["type"];
          $raidboss["raid_pokemon_move_2_type"] = $this->move[$raid["raid_pokemon_move_2"]]["type"];
        } else {
          $raidboss["raid_pokemon_name"] = i8ln('lvl') . '-' . $raid['raid_level'] . ' ' . i8ln('egg');
        }

        $data[] = $raidboss;
      }
      return $data;
    }

    public function query_rewards($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(p.latitude, p.longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $rewards = $db->query("
        SELECT 
          COUNT(GUID) as count,
          tq.quest_item_id, 
          tq.quest_pokemon_id, 
          tq.quest_pokemon_form_id AS quest_pokemon_form,
          tq.quest_item_amount AS quest_item_amount,
          tq.quest_stardust AS quest_dust_amount
        FROM trs_quest tq
        LEFT JOIN pokestop p ON p.pokestop_id = tq.GUID
        WHERE tq.quest_timestamp >= UNIX_TIMESTAMP(CURDATE()) $geofenceSQL
        GROUP BY tq.quest_reward_type, tq.quest_item_id, tq.quest_stardust, tq.quest_item_amount, tq.quest_pokemon_id, tq.quest_pokemon_form_id"
      );

      $total = $db->query("
        SELECT
          COUNT(*) AS total
        FROM trs_quest tq
        LEFT JOIN pokestop p ON p.pokestop_id = tq.GUID
        WHERE tq.quest_timestamp >= UNIX_TIMESTAMP(CURDATE()) $geofenceSQL"
      )->fetch();

      $data = array();
      foreach ($rewards as $reward) {
        $questReward["quest_pokemon_id"] = $reward["quest_pokemon_id"];
        $questReward["quest_pokemon_form"] = $reward["quest_pokemon_form"];
        $questReward["quest_item_id"] = $reward["quest_item_id"];
        $questReward["count"] = $reward["count"];
        $questReward["percentage"] = round(100 / $total["total"] * $reward["count"], 3) . '%';

        if ($reward["quest_pokemon_id"] > 0) {
          $questReward["name"] = i8ln($this->pokedex[$reward['quest_pokemon_id']]["name"]);
          $questReward["quest_reward_amount"] = null;
        } elseif ($reward["quest_item_id"] > 0) {
          $questReward["name"] = i8ln($this->itemdex[$reward['quest_item_id']]["name"]);
          $questReward["quest_reward_amount"] = $reward["quest_item_amount"];
        } else {
          $questReward["name"] = i8ln('Stardust');
          $questReward["quest_reward_amount"] = $reward["quest_dust_amount"];
        }
        $data[] = $questReward;
      }
      return $data;
    }

    public function query_shiny($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $shinys = $db->query("
        SELECT
          SUM(shiny) AS shiny_count,
          pokemon_id,
          form,
          costume,
          COUNT(*) AS sample_size
        FROM pokemon
        WHERE expire_timestamp > UNIX_TIMESTAMP() - 86400 AND iv IS NOT NULL $geofenceSQL
        GROUP BY pokemon_id, form, costume
        HAVING shiny_count >= 1"
      );

      $data = array();
      foreach ($shinys as $shiny) {
        $pokemon["name"] = i8ln($this->pokedex[$shiny['pokemon_id']]["name"]);
        $pokemon["shiny_count"] = $shiny["shiny_count"];
        $pokemon["pokemon_id"] = $shiny["pokemon_id"];
        $pokemon["form"] = $shiny["form"];
        $pokemon["costume"] = $shiny["costume"];
        $pokemon["rate"] = '1/' . round($shiny["sample_size"] / $shiny['shiny_count']);
        $pokemon["percentage"] = round(100 / $shiny["sample_size"] * $shiny["shiny_count"], 3) . '%';
        $pokemon["sample_size"] = $shiny['sample_size'];
        $data[] = $pokemon;
      }
      return $data;
    }

    public function query_invasions($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $invasions = $db->query("
        SELECT
          COUNT(*) AS count,
          incident_grunt_type AS grunt_type
        FROM pokestop
        WHERE incident_expiration > UTC_TIMESTAMP() $geofenceSQL
        GROUP BY incident_grunt_type"
      );
      $total = $db->query("
        SELECT 
          COUNT(*) AS total
        FROM pokestop
        WHERE incident_expiration > UTC_TIMESTAMP() AND incident_grunt_type IS NOT NULL $geofenceSQL"
      )->fetch();

      $data = array();
      foreach ($invasions as $invasion) {
        $rocket["name"] = i8ln($this->gruntdex[$invasion['grunt_type']]["type"]);
        $rocket["grunt_type"] = $invasion["grunt_type"];
        $rocket["count"] = $invasion["count"];
        $rocket["percentage"] = round(100 / $total["total"] * $invasion["count"], 3) . '%';
        $data[] = $rocket;
      }
      return $data;
    }

    public function query_pokemon($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(latitude, longitude), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $mons = $db->query("
        SELECT
          pokemon_id,
          form,
          costume,
          count(*) AS count
        FROM pokemon
        WHERE disappear_time > UTC_TIMESTAMP() $geofenceSQL
        GROUP BY pokemon_id, form, costume"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM pokemon WHERE disappear_time > UTC_TIMESTAMP() $geofenceSQL")->fetch();

      $data = array();
      foreach ($mons as $mon) {
        $pokemon["name"] = i8ln($this->pokedex[$mon['pokemon_id']]["name"]);
        $pokemon["pokemon_id"] = $mon["pokemon_id"];
        $pokemon["form"] = $mon["form"];
        $pokemon["costume"] = $mon["costume"];
        $pokemon["count"] = $mon["count"];
        $pokemon["percentage"] = round(100 / $total["total"] * $mon["count"], 3) . '%';
        if (isset($mon["form"]) && $mon["form"] > 0) {
            $forms = $this->pokedex[$mon["pokemon_id"]]["forms"];
              foreach ($forms as $f => $v) {
                if ($mon["form"] === $v['protoform']) {
                    $types = $v['formtypes'];
                    foreach ($v['formtypes'] as $ft => $v) {
                        $types[$ft]['type'] = $v['type'];
                    }
                    $pokemon["pokemon_types"] = $types;
                }
            }
        } else {
            $types = $this->pokedex[$pokemon["pokemon_id"]]["types"];
            foreach ($types as $k => $v) {
                $types[$k]['type'] = $v['type'];
            }
            $pokemon["pokemon_types"] = $types;
        }
        $data[] = $pokemon;
      }
      return $data;
    }
}
