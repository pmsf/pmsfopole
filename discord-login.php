<?php
require_once 'vendor/autoload.php';
require_once 'config/config.php';
require_once 'DiscordAuth.php';

if ($discord_login) {
    $auth = new DiscordAuth();
    $auth->gotoDiscord();
} else {
    header("Location: .");
}