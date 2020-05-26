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

$getPage = !empty($_POST['getPage']) ? $_POST['getPage'] : false;

$debug['1_before_functions'] = microtime(true) - $timing['start'];

$data = array();

if ($getPage && $getPage === 'overview') {
  $data['overview'] = $scanner->query_overview();
  $debug['2_after_overview'] = microtime(true) - $timing['start'];

  $data['teams'] = $scanner->query_teams();
  $debug['3_after_teams'] = microtime(true) - $timing['start'];

  $data['pokestops'] = $scanner->query_pokestops();
  $debug['4_after_pokestops'] = microtime(true) - $timing['start'];

  $data['spawnpoints'] = $scanner->query_spawnpoints();
  $debug['5_after_spawnpoints'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'pokemon') {
  $data['pokemon'] = $scanner->query_pokemon();
  $debug['2_after_pokemon'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'raids') {
  $data['raids'] = $scanner->query_raids();
  $debug['2_after_raids'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'rewards') {
  $data['rewards'] = $scanner->query_rewards();
  $debug['2_after_rewards'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'shiny') {
  $data['shiny'] = $scanner->query_shiny();
  $debug['2_after_shiny'] = microtime(true) - $timing['start'];
}

if ($getPage && $getPage === 'invasion') {
  $data['invasion'] = $scanner->query_invasions();
  $debug['2_after_invasion'] = microtime(true) - $timing['start'];
}


refreshCsrfToken();
$debug['end'] = microtime(true) - $timing['start'];

if ($enableDebug == true) {
  foreach ($debug as $k => $v) {
    header("X-Debug-Time-" . $k . ": " . $v);
  }
}

echo json_encode($data);
