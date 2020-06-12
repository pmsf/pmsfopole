<?php if ($nestPage) { ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <div id="timer" class="text-center">
          <div id="days"></div>
          <div id="hours"></div>
          <div id="minutes"></div>
          <div id="seconds"></div>
          <h6><?php echo i8ln('Until the next Pokémon GO nest migration.'); ?></h6>
        </div>
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <table id="nestTable" class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th><?php echo i8ln('Pokémon'); ?></th>
              <th><?php echo i8ln('Nest Name'); ?></th>
              <th><?php echo i8ln('Avarage/h'); ?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
<?php } else { ?>
  <br><center><h1><?php echo i8ln('Access denied.'); ?></h1>
  <div><img src="static/images/accessdenied.png" style="max-width:45vh"></div><br><br>
  <br><h4><?php echo i8ln('Redirecting...'); ?> <i class="fas fa-spinner fa-spin"></i></h4></center>
  <meta http-equiv="refresh" content="2; URL=?overview.php">
<?php } ?>
