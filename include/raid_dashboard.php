<div class="container">
  <table id="raidDashboardTable" class="table table-striped table-bordered">

    <div class="form-row">
      <div class="col">
        <select class="custom-select form-control" id="geofence">
          <?php
            foreach($geofences as $key => $value) {
              echo '<option value="' . $value . '">' . $value . '</a>';
            }
          ?>
        </select>
      </div>
      <div class="col">
        <input id="min-level" class="form-control" placeholder="Min Level" name="min-level" type="number">
      </div>
      <div class="col">
        <input id="max-level" class="form-control" placeholder="Max Level" name="max-level" type="number">
      </div>
    </div>

    <div class="text-center">
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="0" style="cursor: pointer;"><?php echo i8ln('Gym'); ?></a>
      </button>
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="1" style="cursor: pointer;"><?php echo i8ln('Boss'); ?></a>
      </button>
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="2" style="cursor: pointer;"><?php echo i8ln('Despawn'); ?></a>
      </button>
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="3" style="cursor: pointer;"><?php echo i8ln('Hatch'); ?></a>
      </button>
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="4" style="cursor: pointer;"><?php echo i8ln('lvl'); ?></a>
      </button>
      <button class="btn btn-primary mb-2">
        <a class="toggle-column" data-column="5" style="cursor: pointer;"><?php echo i8ln('Moves'); ?></a>
      </button>
    </div>

    <thead class="thead-dark">
      <tr>
        <th><?php echo i8ln('Gym'); ?></th>
        <th><?php echo i8ln('Boss'); ?></th>
        <th><?php echo i8ln('Despawn'); ?></th>
        <th><?php echo i8ln('Hatch'); ?></th>
        <th><?php echo i8ln('lvl'); ?></th>
        <th><?php echo i8ln('Moves'); ?></th>
      </tr>
    </thead>
  </table>
</div>
