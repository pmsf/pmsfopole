<?php

namespace Scanner;

class Manual extends Scanner
{
    public function query_nests($selectedGeofence)
    {
      global $manualdb, $geofences, $minNestAvg, $unknownParkName;

      $geofenceSQL = '';
      if ($selectedGeofence) {
        $geofence = array_search($selectedGeofence, $geofences);
        if ($geofence !== 'All') {
          $geofenceSQL = " AND (ST_WITHIN(point(lat, lon), ST_GEOMFROMTEXT('POLYGON(( " . $geofence . " ))')))";
        }
      }

      $avgSQL = '';
      if ($minNestAvg > 0) {
        $avgSQL = " AND pokemon_avg >= $minNestAvg";
      }

      $parkNameSQL = '';
      if (!$unknownParkName) {
        $parkNameSQL = " AND name != 'Unknown Parkname'";
      }

      $nests = $manualdb->query("
        SELECT 
          pokemon_id,
          name AS nest_name,
          lat,
          lon,
          pokemon_avg AS avg
        FROM nests
        WHERE pokemon_id > 0
        $avgSQL
        $parkNameSQL
        $geofenceSQL"
      );

      $data = array();
      foreach ($nests as $nest) {
        $nest['pokemon_id'] = $nest['pokemon_id'];
        $nest['name'] = i8ln($this->pokedex[$nest['pokemon_id']]['name']);
        $nest['nest_name'] = $nest['nest_name'];
        $nest['avg'] = $nest['avg'];
        $nest['lat'] = $nest['lat'];
        $nest['lon'] = $nest['lon'];
        $data[] = $nest;
      }
      return $data;
    }
}
