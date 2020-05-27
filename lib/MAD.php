<?php

namespace Scanner;

class MAD extends Scanner
{
    public function query_overview()
    {
      global $db;
      $pokemon = $db->query("SELECT count(*) AS pokemon_count FROM pokemon WHERE disappear_time > UTC_TIMESTAMP()")->fetch();
      $gym = $db->query("SELECT COUNT(*) AS gym_count FROM gym")->fetch();
      $raid = $db->query("SELECT COUNT(*) AS raid_count FROM raid WHERE end > UTC_TIMESTAMP()")->fetch();
      $pokestop = $db->query("SELECT COUNT(*) AS pokestop_count FROM pokestop")->fetch();

      $data = array();
    
      $overview['pokemon_count'] = $pokemon['pokemon_count'];
      $overview['gym_count'] = $gym['gym_count'];
      $overview['raid_count'] = $raid['raid_count'];
      $overview['pokestop_count'] = $pokestop['pokestop_count'];

      $data[] = $overview;
      return $data;
    }

    public function query_teams()
    {
      global $db;
      $teams = $db->query("
        SELECT 
          SUM(team_id = 0) AS neutral_count,
          SUM(team_id = 1) AS mystic_count,
          SUM(team_id = 2) AS valor_count,
          SUM(team_id = 3) AS instinct_count
        FROM gym"
      )->fetch();

      $data = array();

      $team['neutral_count'] = $teams['neutral_count'];
      $team['mystic_count'] = $teams['mystic_count'];
      $team['valor_count'] = $teams['valor_count'];
      $team['instinct_count'] = $teams['instinct_count'];

      $data[] = $team;
      return $data;
    }

    public function query_pokestops()
    {
      global $db;
      $pokestops = $db->query("
        SELECT
          SUM(incident_expiration > UTC_TIMESTAMP()) AS rocket,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 501) AS normal_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 502) AS glacial_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 503) AS mossy_lure,
          SUM(lure_expiration > UTC_TIMESTAMP() AND active_fort_modifier = 504) AS magnetic_lure
        FROM pokestop"
      )->fetch();
      $quests = $db->query("SELECT COUNT(*) AS count FROM trs_quest WHERE quest_timestamp >= UNIX_TIMESTAMP(CURDATE())")->fetch();

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

    public function query_spawnpoints()
    {
      global $db;
      $spawnpoints = $db->query("
        SELECT
          COUNT(*) AS total,
          SUM(last_scanned IS NOT NULL) AS found,
          SUM(last_scanned IS NULL) AS missing
        FROM trs_spawn"
      )->fetch();

      $data = array();

      $spawnpoint['total'] = $spawnpoints['total'];
      $spawnpoint['found'] = $spawnpoints['found'];
      $spawnpoint['missing'] = $spawnpoints['missing'];

      $data[] = $spawnpoint;
      return $data;
    }

    public function query_raids()
    {
      global $db;
      $raids = $db->query("
        SELECT
          COUNT(*) AS count,
          raid.level AS lvl,
          raid.pokemon_id AS id,
          raid.form AS form,
          raid.costume AS costume
        FROM raid
        LEFT JOIN gym ON raid.gym_id = gym.gym_id
        WHERE end >= UTC_TIMESTAMP() and raid.level >= 1
        GROUP BY raid.level, raid.pokemon_id, raid.form, raid.costume"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM raid WHERE end >= UTC_TIMESTAMP()")->fetch();

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

    public function query_rewards()
    {
      global $db;
      $rewards = $db->query("
        SELECT 
          COUNT(GUID) as count,
          quest_item_id, 
          quest_pokemon_id, 
          quest_pokemon_form_id AS quest_pokemon_form,
          quest_item_amount AS quest_item_amount,
          quest_stardust AS quest_dust_amount
        FROM trs_quest
        WHERE quest_timestamp >= UNIX_TIMESTAMP(CURDATE())
        GROUP BY quest_reward_type, quest_item_id, quest_stardust, quest_item_amount, quest_pokemon_id, quest_pokemon_form_id"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM trs_quest WHERE quest_timestamp >= UNIX_TIMESTAMP(CURDATE())")->fetch();

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

    public function query_shiny()
    {
      global $db;
      $shinys = $db->query("
        SELECT
          SUM(shiny) AS shiny_count,
          pokemon_id,
          form,
          costume,
          COUNT(*) AS sample_size
        FROM pokemon
        WHERE expire_timestamp > UNIX_TIMESTAMP() - 86400 AND iv IS NOT NULL
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

    public function query_invasions()
    {
      global $db;
      $invasions = $db->query("
        SELECT
          COUNT(*) AS count,
          incident_grunt_type AS grunt_type
        FROM pokestop
        WHERE incident_expiration > UTC_TIMESTAMP()
        GROUP BY incident_grunt_type"
      );
      $total = $db->query("
        SELECT 
          COUNT(*) AS total
        FROM pokestop
        WHERE incident_expiration > UTC_TIMESTAMP() AND incident_grunt_type IS NOT NULL"
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

    public function query_pokemon()
    {
      global $db;
      $mons = $db->query("
        SELECT
          pokemon_id,
          form,
          costume,
          count(*) AS count
        FROM pokemon
        WHERE disappear_time > UTC_TIMESTAMP()
        GROUP BY pokemon_id, form, costume"
      );
      $total = $db->query("SELECT COUNT(*) AS total FROM pokemon WHERE disappear_time > UTC_TIMESTAMP()")->fetch();

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
