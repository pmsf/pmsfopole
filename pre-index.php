<?php
include('config/config.php');

if ($discord_login) {
  if (isset($_COOKIE["LoginCookie"])) {
    if (validateCookie($_COOKIE["LoginCookie"]) === false) {
      header("Location: .");
    }
  }
  if (!isset($_SESSION['user']) && $forced_discord_auth) {
    header("Location: ./discord-login.php");
    die();
  }
}

if (!empty($_GET['lang'])) {
  setcookie("LocaleCookie", $_GET['lang'], time() + 60 * 60 * 24 * 31);
  header("Location: .");
}
if (!empty($_COOKIE["LocaleCookie"])) {
  $locale = $_COOKIE["LocaleCookie"];
}

if (!empty($_GET['page'])) {
  $page = $_GET['page'];
  $file = 'include/' . $page . '.php';
  
  if (is_file($file)) {
    $include = $file;
    $enablePage = $page;
  } else {
    $include = 'include/overview.php';
    $enablePage = 'overview';
  }
} else {
  $include = 'include/overview.php';
  $enablePage = 'overview';
}

?>
<!DOCTYPE html>
<html lang="<?php echo $locale; ?>">
<head>
  <title><?php echo $title; ?></title>
  <!-- Meta tags -->
  <meta charset="utf-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0, shrink-to-fit=no'>
  <!-- Favicon -->
  <?php if ($favIcon !== '') {
    echo '<link rel="shortcut icon" href="' . $favIcon . '" type="image/x-icon">';
  } ?>
  <!-- Token -->
  <script>var token = '<?php echo (!empty($_SESSION['token'])) ? $_SESSION['token'] : ""; ?>';</script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <!-- DataTables CSS -->
  <?php
  if ($enablePage !== 'overview') {
    echo '<link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">';
    echo '<link rel="stylesheet" href="node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css">';
  } ?>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <!-- CSS -->
  <link rel="stylesheet" href="static/dist/css/style.min.css">
  <?php if (file_exists('custom/css/custom.css') && $enablePage === 'overview') {
    echo '<link rel="stylesheet" href="custom/css/custom.css?' . time() . '">';
  } ?>
</head>
<body>
  <div class="flex-wrapper">
    <?php
      /* Include Nav */
      include('include/nav.php');
    ?>
    <main id="main">
      <?php
        /* Include Page */
        include($include);
      ?>
    </main>
    <?php
      /* Include Footer */
      if ($footer && $enablePage !== 'pokedex') {
        include('include/footer.php');
      }
    ?>
  </div>
  <!-- scripts -->
  <script src='node_modules/jquery/dist/jquery.min.js'></script>
  <?php
  if ($enablePage !== 'overview' && $enablePage !== 'pokedex') {
    echo '<script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>';
    echo '<script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>';
    echo '<script src="node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>';
    echo '<script src="node_modules/datatables.net-plugins/sorting/natural.js"></script>';
  } ?>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script>
    var getPage = '<?php echo $enablePage ?>';
    var queryDelay = '<?php echo $queryDelay ?>';
    var pokemonIconPath = '<?php echo $pokemonIconPath ?>';
    var itemIconPath = '<?php echo $itemIconPath ?>';
    var eggIconPath = '<?php echo $eggIconPath ?>';
    var pokemonPage = '<?php echo $pokemonPage ?>';
    var raidPage = '<?php echo $raidPage ?>';
    var rewardPage = '<?php echo $rewardPage ?>';
    var invasionPage = '<?php echo $invasionPage ?>';
    var shinyPage = '<?php echo $shinyPage ?>';
    var nestPage = '<?php echo $nestPage ?>';
    var geofenceDefault = '<?php echo $geofenceDefault ?>';
  </script>
  <script src="static/dist/js/stats.common.min.js"></script>
  <script type="text/javascript" src="static/dist/js/stats.min.js"></script>
</body>
</html>
