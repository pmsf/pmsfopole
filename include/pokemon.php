<?php if ($pokemonPage) { ?>
  <br>
  <h4 class="text-center"><?php echo i8ln('Current Pokémon'); ?></h4>
  <div class="container">
    <div class="row">
      <div class="col">
        <table id="pokemonTable" class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th><?php echo i8ln('ID'); ?></th>
              <th><?php echo i8ln('Type'); ?></th>
              <th><?php echo i8ln('Pokémon'); ?></th>
              <th><?php echo i8ln('Count'); ?></th>
              <th>%</th>
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
