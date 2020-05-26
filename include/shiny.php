<?php if ($shinyPage) { ?>
  <br>
  <h4 class="text-center"><?php echo i8ln('Live Shiny Rates'); ?></h4>
  <h6 class="text-center"><?php echo i8ln('Data from the last 24 hours.'); ?></h6>
  <!-- Shiny table -->
  <table id="shinyTable" class="table table-striped table-bordered" style="width:100%;">
    <thead class="thead-dark">
      <tr>
        <th><?php echo i8ln('Pokémon'); ?></th>
        <th><?php echo i8ln('Shiny Count'); ?></th>
        <th><?php echo i8ln('Shiny Rate'); ?></th>
        <th><?php echo i8ln('Sample Size'); ?></th>
      </tr>
    </thead>
  </table>
<?php } else { ?>
  <br><center><h1><?php echo i8ln('Access denied.'); ?></h1>
  <div><img src="static/images/accessdenied.png" style="max-width:45vh"></div><br><br>
  <br><h4><?php echo i8ln('Redirecting...'); ?> <i class="fas fa-spinner fa-spin"></i></h4></center>
  <meta http-equiv="refresh" content="2; URL=?overview.php">
<?php } ?>
