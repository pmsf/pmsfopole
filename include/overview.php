  <!-- Overview -->
  <div class="card text-center p-0 m-4">
    <div class="card-header card-header-overview bg-dark text-light"><?php echo i8ln('Overview'); ?></div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a class="list-group-item" href="?page=pokemon" style="color:black;">
                <h3 class="pull-right"><img src="static/images/pokeball.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading pokemon-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Pokémon'); ?></p>
              </a>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/neutral.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading gym-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Gyms'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <a class="list-group-item" href="?page=raids" style="color:black;">
                <h3 class="pull-right"><img src="static/images/raid.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading raid-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Raids'); ?></p>
              </a>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/pokestop.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading pokestop-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Pokéstops'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Teams -->
  <div class="card text-center p-0 m-4">
    <div class="card-header card-header-overview bg-dark text-light"><?php echo i8ln('Teams'); ?></div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item neutral">
                <h3 class="pull-right"><img src="static/images/neutral.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading neutral-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Neutral Gyms'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item mystic">
                <h3 class="pull-right"><img src="static/images/mystic.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading mystic-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Mystic Gyms'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item valor">
                <h3 class="pull-right"><img src="static/images/valor.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading valor-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Valor Gyms'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="list-group">
              <div class="list-group-item instinct">
                <h3 class="pull-right"><img src="static/images/instinct.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading instinct-count"><?php echo i8ln('loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Instinct Gyms'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pokéstops -->
  <div class="card text-center p-0 m-4">
    <div class="card-header card-header-overview bg-dark text-light"><?php echo i8ln('Pokéstops'); ?></div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-md-4 p-1">
            <div class="list-group">
              <a class="list-group-item" href="?page=rewards" style="color:black;">
                <h3 class="pull-right"><img src="static/images/quest.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading quest-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Field Research'); ?></p>
              </a>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <a class="list-group-item" href="?page=invasion" style="color:black;">
                <h3 class="pull-right"><img src="static/images/rocket.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading rocket-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Invasions'); ?></p>
              </a>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/lure.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading normal-lure-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Normal Lure'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/glacial-lure.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading glacial-lure-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Glacial Lure'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/mossy-lure.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading mossy-lure-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Mossy Lure'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/magnetic-lure.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading magnetic-lure-count"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Magnetic Lure'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Spawnpoints -->
  <div class="card text-center p-0 m-4">
    <div class="card-header card-header-overview bg-dark text-light"><?php echo i8ln('Spawnpoints'); ?></div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/spawnpoint.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading spawnpoint-total"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Total'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/found.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading spawnpoint-found"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Timer Found'); ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 p-1">
            <div class="list-group">
              <div class="list-group-item">
                <h3 class="pull-right"><img src="static/images/missing.png" width="64" height="64" /></h3>
                <h4 class="list-group-item-heading spawnpoint-missing"><?php echo i8ln('Loading...'); ?> <i class="fas fa-spinner fa-spin"></i></h4>
                <p class="list-group-item-text"><?php echo i8ln('Timer Missing'); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
