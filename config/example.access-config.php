<?php

// Define access levels from manualdb
$userLevel = 0;
$donorLevel = 1;
$adminLevel = 99;


// Enable / disable something based on access level.
if ($_SESSION['user']->access_level == $userLevel) {
  $pokemonPage = false;
  $raidPage = false;
  $rewardPage = false;
  $invasionPage = false;
  $shinyPage = false;
  $queryDelay = 20;
} elseif ($_SESSION['user']->access_level == $donorLevel) {
  $pokemonPage = true;
  $raidPage = true;
  $rewardPage = true;
  $invasionPage = true;
  $shinyPage = false;
  $queryDelay = 10;
} elseif ($_SESSION['user']->access_level == $adminLevel) {
  $pokemonPage = true;
  $raidPage = true;
  $rewardPage = true;
  $invasionPage = true;
  $shinyPage = true;
  $queryDelay = 5;
}