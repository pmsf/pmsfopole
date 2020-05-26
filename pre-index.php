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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- DataTables CSS -->
  <?php
  if ($enablePage !== 'overview') {
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">';
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css">';
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
  <?php
    /* Include Nav */
    include('include/nav.php');

    /* Welcome */
    if (isset($_SESSION['user']->user)) {
      $user = explode("#", $_SESSION['user']->user);
      echo '<h3 class="page-header text-center">' . i8ln('Welcome') . ' ' . $user[0] . '</h3>';
    }

    /* Include Page */
    include($include);

    /* Include Footer */
    if ($footer) {
      include('include/footer.php');
    }
  ?>
  <!-- scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script type='text/javascript' charset='utf8' src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
  <?php
  if ($enablePage !== 'overview') {
    echo '<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>';
    echo '<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>';
    echo '<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>';
  } ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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
  </script>
  <script type="text/javascript" src="static/dist/js/stats.min.js"></script>
</body>
</html>