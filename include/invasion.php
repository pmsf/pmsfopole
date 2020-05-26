<?php if ($invasionPage) { ?>
  <br>
  <h4 class="text-center"><?php echo i8ln('Current Grunts'); ?></h4>
  <!-- Invasion table -->
  <table id="invasionTable" class="table table-striped table-bordered" style="width:100%;">
    <thead class="thead-dark">
      <tr>
        <th><?php echo i8ln('Grunt'); ?></th>
        <th><?php echo i8ln('Count'); ?></th>
        <th>%</th>
      </tr>
    </thead>
  </table>
<?php } else { ?>
  <br><center><h1><?php echo i8ln('Access denied.'); ?></h1>
  <div><img src="static/images/accessdenied.png" style="max-width:45vh"></div><br><br>
  <br><h4><?php echo i8ln('Redirecting...'); ?> <i class="fas fa-spinner fa-spin"></i></h4></center>
  <meta http-equiv="refresh" content="2; URL=?overview.php">
<?php } ?>
