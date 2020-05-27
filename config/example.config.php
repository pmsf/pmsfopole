<?php
require 'default.php';
require __DIR__ . '/../Medoo.php';
use Medoo\Medoo;
/*---------------------------------------------*/
/*         Do NOT edit the code above.         */
/*---------------------------------------------*/
/* There is a custom.css.example in custom/css */
/*---------------------------------------------*/

/* General Settings */
$enableCsrf = true; // Don't disable this unless you know why you need to :)
$sessionLifetime = 43200;

$locale = 'en';

$title = 'pmsfopole';
$favIcon = 'custom/headerimage.png';

$headerName = 'pmsfopole';
$headerImage = 'custom/headerimage.png';

$footer = true;
$footerIcons = true;


/* Urls */
$homeUrl = '#';
$mapUrl = '#';

$patreonUrl = '#';
$paypalUrl = '#';

$discordUrl = '#';
$telegramUrl = '#';


/* Icons */
$pokemonIconPath = 'custom/sprites/PkmnShuffleMap/PMSF_icons_large/';
$itemIconPath = 'custom/sprites/pogoassets/no_border/rewards/';
$eggIconPath = 'custom/sprites/PkmnShuffleMap/PMSF_icons_large/';


/* Discord Settings */
$discord_login = false;
$forced_discord_auth = false;
$discord_bot_client_id = 000000000000000000000;
$discord_bot_client_secret = "secret";
$discord_bot_redirect_uri = "https://website.com/discord-callback.php";
$discord_guild_ids = [000000000000000];
$discord_bot_token = "token";


/* Pages */
$pokemonPage = true;
$raidPage = true;
$rewardPage = true;
$invasionPage = true;
$shinyPage = false;   // Does not work for mad yet.


/* Database Settings */
$backend = 'rdm';     // rdm or mad
$queryDelay = 5;      // get data every x seconds.
$enableDebug = false; // for debugging raw data.

$db = new Medoo([
    'database_type' => 'mysql',                                    
    'database_name' => 'scandb',
    'server' => 'localhost',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8mb4'
]);

$manualdb = new Medoo([ // Comment out if not using discord auth
    'database_type' => 'mysql',                                    
    'database_name' => 'manualdb',
    'server' => 'localhost',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8mb4'
]);



/*----------------------------------------------------*/
/*             Do NOT edit the code below.            */
/*----------------------------------------------------*/
if ($discord_login && !empty($_SESSION['user']->user)) {
    if (file_exists('config/access-config.php')) {
        include 'config/access-config.php';
    }
}
