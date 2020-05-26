<?php
include 'vendor/autoload.php';
require_once 'config/config.php';
require_once 'DiscordAuth.php';

use RestCord\DiscordClient;

try {
  if (isset($_GET['code'])) {
    $auth = new DiscordAuth();
    $auth->handleAuthorizationResponse($_GET);
    $user = json_decode($auth->get("/api/v6/users/@me"));
    $guilds = json_decode($auth->get("/api/v6/users/@me/guilds"));

    $in_trusted = in_trusted_guild($discord_guild_ids, $guilds);
    if (!$in_trusted) {
      die("You must join Discord server $discordUrl");
    }

    $valid = false;
    if (!empty($discord_bot_token)) {
      $discord = new DiscordClient(['token' => $discord_bot_token]);
      $count = count($discord_guild_ids);
      for ($i = 0; $i < $count; $i++) {
        $member = $discord->guild->getGuildMember(['guild.id' => $discord_guild_ids[$i], 'user.id' => (int)$user->id]);
        if ($member === null) {
          continue;
        }

        $count = $manualdb->count("users", ["id" => $user->{'id'}]);
        if ($count === 0) {
            $manualdb->insert("users", [
                "id" => $user->{'id'},
                "user" => $user->{'username'} . "#" . $user->{'discriminator'},
                "login_system" => 'discord'
            ]);
        }

        $manualdb->update("users", [
            "session_id" => session_id(),
            "user" => $user->{'username'} . "#" . $user->{'discriminator'}
        ], [
            "id" => $user->{'id'}
        ]);

        setcookie("LoginCookie", session_id(), time() + 60 * 60 * 24 * 7);
        $valid = true;
        break;
      }
    }
  }
  if ($valid) {
    header("Location: .");
  }
} catch (Exception $e) {
  file_put_contents('error.log', $e->getMessage(), FILE_APPEND);
  header("Location: ./discord-login.php");
}

function in_trusted_guild($trusted_guild_ids, $guilds) {
  if (count($trusted_guild_ids) == 0) {
    return true;
  }
  foreach ($guilds as $key => $value) {
    if (in_array($value->id, $trusted_guild_ids)) {
        return true;
    }
  }
  return false;
}
