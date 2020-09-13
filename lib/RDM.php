<?php

namespace Scanner;

class RDM extends Scanner
{
    public function query_overview($selectedGeofence)
    {
      global $db, $geofences;

      $geofenceSQL = '';
      $pokemonGeofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " WHERE (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
          $pokemonGeofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $pokemon = $db->query("
        SELECT COUNT(*) AS pokemon_count
        FROM pokemon
        WHERE expire_timestamp > UNIX_TIMESTAMP()
        $pokemonGeofenceSQL"
      )->fetch();
      
      $gym = $db->query("
        SELECT
          COUNT(*) AS gym_count,
          SUM(raid_end_timestamp > UNIX_TIMESTAMP()) AS raid_count
        FROM gym
        $geofenceSQL"
      )->fetch();
      
      $pokestop = $db->query("
        SELECT COUNT(*) AS pokestop_count
        FROM pokestop
        $geofenceSQL"
      )->fetch();

      $data = array();
    
      $overview['pokemon_count'] = $pokemon['pokemon_count'];
      $overview['gym_count'] = $gym['gym_count'];
      $overview['raid_count'] = $gym['raid_count'];
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
          $geofenceSQL = " WHERE (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
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

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " WHERE (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $pokestops = $db->query("
        SELECT
          SUM(quest_type IS NOT NULL) AS quest,
          SUM(incident_expire_timestamp > UNIX_TIMESTAMP()) AS rocket,
          SUM(lure_expire_timestamp > UNIX_TIMESTAMP() AND lure_id = 501) AS normal_lure,
          SUM(lure_expire_timestamp > UNIX_TIMESTAMP() AND lure_id = 502) AS glacial_lure,
          SUM(lure_expire_timestamp > UNIX_TIMESTAMP() AND lure_id = 503) AS mossy_lure,
          SUM(lure_expire_timestamp > UNIX_TIMESTAMP() AND lure_id = 504) AS magnetic_lure
        FROM pokestop
        $geofenceSQL"
      )->fetch();

      $data = array();

      $pokestop['quest'] = $pokestops['quest'];
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
          $geofenceSQL = " WHERE (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $spawnpoints = $db->query("
        SELECT
          COUNT(*) AS total,
          SUM(despawn_sec IS NOT NULL) AS found,
          SUM(despawn_sec IS NULL) AS missing
        FROM spawnpoint
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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $raids = $db->query("
        SELECT
          COUNT(*) AS count,
          raid_level AS lvl,
          raid_pokemon_id AS id,
          raid_pokemon_form AS form,
          raid_pokemon_costume AS costume
        FROM gym
        WHERE raid_end_timestamp > UNIX_TIMESTAMP() and raid_level >= 1 $geofenceSQL
        GROUP BY raid_level, raid_pokemon_id, raid_pokemon_form, raid_pokemon_costume"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM gym WHERE raid_end_timestamp > UNIX_TIMESTAMP() $geofenceSQL")->fetch();

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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $raids = $db->query("
        SELECT
          name,
          url,
          lat,
          lon,
          raid_pokemon_id,
          raid_pokemon_form,
          raid_pokemon_costume,
          raid_level,
          raid_battle_timestamp,
          raid_end_timestamp,
          team_id,
          ex_raid_eligible,
          raid_pokemon_move_1,
          raid_pokemon_move_2
        FROM gym
        WHERE raid_end_timestamp > UNIX_TIMESTAMP() AND name is not null $geofenceSQL"
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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $rewards = $db->query("
        SELECT 
          COUNT(*) as count,
          quest_item_id, 
          quest_pokemon_id, 
          json_extract(json_extract(`quest_rewards`,'$[*].info.pokemon_id'),'$[0]') AS quest_energy_pokemon_id,
          json_extract(json_extract(`quest_rewards`,'$[*].info.form_id'),'$[0]') AS quest_pokemon_form,
          json_extract(json_extract(`quest_rewards`,'$[*].info.amount'),'$[0]') AS quest_reward_amount,
          quest_reward_type
        FROM pokestop
        WHERE quest_reward_type IS NOT NULL $geofenceSQL
        GROUP BY quest_reward_type, quest_item_id, quest_reward_amount, quest_pokemon_id, quest_pokemon_form, quest_energy_pokemon_id"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM pokestop WHERE quest_reward_type IS NOT NULL $geofenceSQL")->fetch();

      $data = array();
      foreach ($rewards as $reward) {
        $questReward["quest_pokemon_id"] = $reward["quest_pokemon_id"];
        $questReward["quest_pokemon_form"] = $reward["quest_pokemon_form"];
        $questReward["quest_energy_pokemon_id"] = $reward["quest_energy_pokemon_id"];
        $questReward["quest_item_id"] = $reward["quest_item_id"];
        $questReward["quest_reward_amount"] = $reward["quest_reward_amount"];
        $questReward["quest_reward_type"] = intval($reward["quest_reward_type"]);
        $questReward["count"] = $reward["count"];
        $questReward["percentage"] = round(100 / $total["total"] * $reward["count"], 3) . '%';

        if ($reward["quest_pokemon_id"] > 0) {
          $questReward["name"] = i8ln($this->pokedex[$reward['quest_pokemon_id']]["name"]);
        } elseif ($reward["quest_item_id"] > 0) {
          $questReward["name"] = i8ln($this->itemdex[$reward['quest_item_id']]["name"]);
        } elseif ($reward["quest_reward_type"] == 12) {
            $questReward["name"] = $reward["quest_reward_amount"] . ' ' . i8ln($this->pokedex[$reward['quest_energy_pokemon_id']]["name"]) . ' ' . i8ln('Energy');
        } else {
          $questReward["name"] = i8ln('Stardust');
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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $invasions = $db->query("
        SELECT
          COUNT(*) AS count,
          grunt_type
        FROM pokestop
        WHERE incident_expire_timestamp > UNIX_TIMESTAMP() $geofenceSQL
        GROUP BY grunt_type"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM pokestop WHERE incident_expire_timestamp > UNIX_TIMESTAMP() AND grunt_type IS NOT NULL $geofenceSQL")->fetch();

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
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $mons = $db->query("
        SELECT
          pokemon_id,
          form,
          costume,
          count(*) AS count
        FROM pokemon
        WHERE expire_timestamp > UNIX_TIMESTAMP() $geofenceSQL
        GROUP BY pokemon_id, form, costume"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM pokemon WHERE expire_timestamp > UNIX_TIMESTAMP() $geofenceSQL")->fetch();

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
