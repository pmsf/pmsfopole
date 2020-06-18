<nav class="navbar navbar-expand navbar-dark bg-dark" id="header">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a data-trigger="#navbar_main">
          <i class="fas fa-bars nav-icon"></i>
        </a>
      </li>
    </ul>
  </div>
  <a class="navbar-brand" href=".">
    <img src="<?php echo $headerImage; ?>" style="height:35px;"> <?php echo $headerName; ?>
  </a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto" style="position:absolute;right:1%">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="static/images/flag-<?php echo $locale; ?>.png" style="height:15px;width:23px">
        </a>
        <div class="dropdown-menu language-dropdown" aria-labelledby="languageDropdown">
          <a class="dropdown-item" href="?lang=en">
            <img src="static/images/flag-en.png" style="height:20px;width:30px"> <?php echo i8ln('English'); ?>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="?lang=de">
            <img src="static/images/flag-de.png" style="height:20px;width:30px"> <?php echo i8ln('German'); ?>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="?lang=pl">
            <img src="static/images/flag-pl.png" style="height:20px;width:30px"> <?php echo i8ln('Polish'); ?>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="?lang=sv">
            <img src="static/images/flag-sv.png" style="height:20px;width:30px"> <?php echo i8ln('Swedish'); ?>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="?lang=pt_br">
            <img src="static/images/flag-pt_br.png" style="height:20px;width:30px"> <?php echo i8ln('Português BR'); ?>
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<nav id="navbar_main" class="offcanvas navbar navbar-light bg-light border">
  <ul class="navbar-nav mr-auto" style="margin-top: -9px;">
    <div class="accordion" id="accordion-test">

      <div class="card z-depth-0 bordered">
        <div class="card-header card-header-navbar" id="heading-pages" class="heading-title" data-toggle="collapse" data-target="#collapse-pages" aria-expanded="true" aria-controls="collapse-pages">
          <h6 class="heading-title">
            <i class="fas fa-chart-bar"></i>&nbsp;&nbsp;<?php echo i8ln('Stats Pages'); ?>
          </h6>
        </div>
        <div id="collapse-pages" class="collapse show" aria-labelledby="heading-pages" data-parent="#accordion-test">
          <div class="card-body">
    
            <a class="dropdown-item" href=".">
              <i class="fas fa-tachometer-alt"></i> <?php echo i8ln('Overview'); ?>
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=pokedex">
              <img src="static/images/svg/pokedex.svg" style="width:22px;height:22px;"> <?php echo i8ln('Pokédex'); ?>
            </a>

            <?php if ($pokemonPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=pokemon">
               <img src="<?php echo $pokemonIconPath; ?>pokemon_icon_001_00.png" style="width:22px;height:22px;"> <?php echo i8ln('Pokémon'); ?>
              </a>
            <?php } ?>

            <?php if ($raidPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=raids">
                <img src="static/images/svg/raidicon.svg" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Raids'); ?>
              </a>
            <?php } ?>

            <?php if ($rewardPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=rewards">
                <img src="static/images/quest.png" style="width:22px;height:22px;"> <?php echo i8ln('Rewards'); ?>
              </a>
            <?php } ?>

            <?php if ($invasionPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=invasion">
                <img src="static/images/grunttype/4.png" style="width:22px;height:22px;"> <?php echo i8ln('Invasions'); ?>
              </a>
            <?php } ?>

            <?php if ($shinyPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=shiny">
                <img src="static/images/svg/shinysparkles.svg" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Shiny Rate'); ?>
              </a>
            <?php } ?>

            <?php if ($nestPage) { ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=nest">
                <img src="static/images/nest.png" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Nests'); ?>
              </a>
            <?php } ?>
    
          </div>
        </div>
      </div>


      <?php if ($homeUrl !== '' || $mapUrl !== '') { ?>
          <div class="card z-depth-0 bordered">
            <div class="card-header card-header-navbar" id="heading-donate" data-toggle="collapse" data-target="#collapse-other-pages" aria-expanded="false" aria-controls="collapse-other-pages">
              <h6 class="heading-title">
                <i class="far fa-file"></i>&nbsp;&nbsp;<?php echo i8ln('Other Pages'); ?>
              </h6>
            </div>
            <div id="collapse-other-pages" class="collapse" aria-labelledby="heading-other-pages" data-parent="#accordion-test">
              <div class="card-body">

                <?php if ($homeUrl !== '') { ?>
                  <a class="dropdown-item" href="<?php echo $homeUrl; ?>">
                    <i class="fas fa-home"></i> <?php echo i8ln('Home'); ?>
                  </a>
                  <?php
                  if ($mapUrl !== '') { ?>
                    <div class="dropdown-divider"></div>
                    <?php
                  }
                } ?>
                <?php if ($mapUrl !== '') { ?>
                  <a class="dropdown-item" href="<?php echo $mapUrl; ?>">
                    <i class="fas fa-map"></i> <?php echo i8ln('Map'); ?>
                  </a>
                <?php } ?>

              </div>
            </div>
          </div>
      <?php } ?>





      <div class="card z-depth-0 bordered">
        <div class="card-header card-header-navbar" id="heading-settings" data-toggle="collapse" data-target="#collapse-settings" aria-expanded="false" aria-controls="collapse-settings">
          <h6 class="heading-title">
            <i class="fas fa-cog"></i>&nbsp;&nbsp;<?php echo i8ln('Settings'); ?>
          </h6>
        </div>
        <div id="collapse-settings" class="collapse" aria-labelledby="heading-settings" data-parent="#accordion-test">
          <div class="card-body">

            <div class="form-group">
              <label for="geofence"><?php echo i8ln('Select Area'); ?></label>
              <select class="custom-select" id="geofence">
                <?php
                  foreach($geofences as $key => $value) {
                    echo '<option value="' . $value . '">' . $value . '</a>';
                  }
                ?>
              </select>
            </div>

            <div>
              <?php echo i8ln('Menu Color'); ?>
              <div class="form-control text-center">
                <button id="color-button-light" class="bg-light color-button">&nbsp;</button>
                <button id="color-button-secondary" class="bg-secondary color-button">&nbsp;</button>
                <button id="color-button-dark" class="bg-dark color-button">&nbsp;</button>
              </div>
            </div>

          </div>
        </div>
      </div>

      <?php if ($patreonUrl !== '' || $paypalUrl !== '') { ?>
          <div class="card z-depth-0 bordered">
            <div class="card-header card-header-navbar" id="heading-donate" data-toggle="collapse" data-target="#collapse-donate" aria-expanded="false" aria-controls="collapse-donate">
              <h6 class="heading-title">
                <i class="fas fa-donate"></i>&nbsp;&nbsp;Donate
              </h6>
            </div>
            <div id="collapse-donate" class="collapse" aria-labelledby="heading-donate" data-parent="#accordion-test">
              <div class="card-body">
      
                <?php if ($patreonUrl !== '') { ?>
                  <a class="dropdown-item" href="<?php echo $patreonUrl; ?>">
                    <i class="fab fa-patreon"></i> <?php echo i8ln('Patreon'); ?>
                  </a>
                  <?php
                  if ($paypalUrl !== '') { ?>
                    <div class="dropdown-divider"></div>
                    <?php
                  }
                } ?>
                <?php if ($paypalUrl !== '') { ?>
                  <a class="dropdown-item" href="<?php echo $paypalUrl; ?>">
                    <i class="fab fa-paypal"></i> <?php echo i8ln('PayPal'); ?>
                  </a>
                <?php } ?>
      
              </div>
            </div>
          </div>
      <?php } ?>
      
      <?php if ($discord_login) { ?>
          <div class="card z-depth-0 bordered">
            <div class="card-header card-header-navbar" id="heading-user" data-toggle="collapse" data-target="#collapse-user" aria-expanded="false" aria-controls="collapse-user">
              <h6 class="heading-title">
                <i class="fas fa-user-cog"></i>&nbsp;&nbsp;<?php echo i8ln('User'); ?>
              </h6>
            </div>
            <div id="collapse-user" class="collapse" aria-labelledby="heading-user" data-parent="#accordion-test">
              <div class="card-body">
      
                <div class="dropdown-item">
                  <?php
                    if (isset($_SESSION['user']->user)) {
                      echo '<i class="fas fa-user-check" style="color:green;"> ' . $_SESSION['user']->user . '</i>';
                    } else {
                      echo '<a href="./discord-login.php" style="color:black;"><i class="fas fa-user" style="color:black;"></i> ' . i8ln('Login') . '</a>';
                    }
                  ?>
                </div>

                <?php if (isset($_SESSION['user']->user)) { ?>
                  <div class="dropdown-divider"></div>
                  <div class="dropdown-item">
                    <?php echo '<a href="./logout.php" title="' . i8ln('Click to logout') . '"><i class="fas fa-sign-out-alt" style="color:red;"> ' . i8ln('Logout') . '</i></a>'; ?>
                  </div>
                <?php } ?>

              </div>
            </div>
          </div>
      <?php } ?>
    </div>


  </ul>
</nav>

<div class="screen-overlay"></div>
