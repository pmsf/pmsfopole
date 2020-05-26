<?php if ($raidPage) { ?>
  <!-- Raid table -->
  <table id="raidTable" class="table table-striped table-bordered" style="width:100%;">
    <thead class="thead-dark">
      <tr>
        <th><?php echo i8ln('lvl'); ?></th>
        <th><?php echo i8ln('Boss'); ?></th>
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
