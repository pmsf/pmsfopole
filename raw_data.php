<?php
$timing['start'] = microtime(true);
include('config/config.php');
header('Content-Type: application/json');

$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
if (preg_match("/curl|libcurl/", $useragent)) {
  http_response_code(400);
  die();
}
if (!validateToken($_POST['token'])) {
  http_response_code(400);
  die();
}

if (strtolower($backend) === "rdm") {
  $scanner = new \Scanner\RDM();
} elseif (strtolower($backend) === "mad") {
  $scanner = new \Scanner\MAD();
}

$manual = new \Scanner\Manual();

$getPage = !empty($_POST['getPage']) ? $_POST['getPage'] : false;
$geofence = !empty($_POST['geofence']) ? $_POST['geofence'] : false;

$debug['1_before_functions'] = microtime(true) - $timing['start'];

$data = array();

if ($getPage && $getPage === 'overview') {
  $data['overview'] = $scanner->query_overview($geofence);
  $debug['2_after_overview'] = microtime(true) - $timing['start'];

  $data['teams'] = $scanner->query_teams($geofence);
  $debug['3_after_teams'] = microtime(true) - $timing['start'];

  $data['pokestops'] = $scanner->query_pokestops($geofence);
  $debug['4_after_pokestops'] = microtime(true) - $timing['start'];

  $data['spawnpoints'] = $scanner->query_spawnpoints($geofence);
  $debug['5_after_spawnpoints'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'pokemon') {
  $data['pokemon'] = $scanner->query_pokemon($geofence);
  $debug['2_after_pokemon'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'raids') {
  $data['raids'] = $scanner->query_raids($geofence);
  $debug['2_after_raids'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'rewards') {
  $data['rewards'] = $scanner->query_rewards($geofence);
  $debug['2_after_rewards'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'shiny') {
  $data['shiny'] = $scanner->query_shiny($geofence);
  $debug['2_after_shiny'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'invasion') {
  $data['invasion'] = $scanner->query_invasions($geofence);
  $debug['2_after_invasion'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'nest') {
  $data['nest'] = $manual->query_nests($geofence);
  $debug['2_after_nests'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'raid_dashboard') {
  $data['raid_dashboard'] = $scanner->query_raid_dashboard($geofence);
  $debug['2_after_raid_dashboard'] = microtime(true) - $timing['start'];
}

refreshCsrfToken();
$debug['end'] = microtime(true) - $timing['start'];

if ($enableDebug == true) {
  foreach ($debug as $k => $v) {
    header("X-Debug-Time-" . $k . ": " . $v);
  }
}

echo json_encode($data);
