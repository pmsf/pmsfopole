  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bars"></i>
          </a>
          <div class="dropdown-menu navbar-dropdown scrollable-menu" aria-labelledby="navbarDropdown">
            <h6 class="dropdown-header"><?php echo i8ln('Stats'); ?></h6>
            <a class="dropdown-item" href=".">
              <i class="fas fa-tachometer-alt"></i> <?php echo i8ln('Overview'); ?>
            </a>
            <?php if ($pokemonPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=pokemon">
               <img src="<?php echo $pokemonIconPath; ?>pokemon_icon_001_00.png" style="width:22px;height:22px;"> <?php echo i8ln('Pokémon'); ?>
              </a>
            <?php } ?>
            <?php if ($raidPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=raids">
                <img src="static/images/svg/raidicon.svg" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Raids'); ?>
              </a>
            <?php } ?>
            <?php if ($rewardPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=rewards">
                <img src="static/images/quest.png" style="width:22px;height:22px;"> <?php echo i8ln('Rewards'); ?>
              </a>
            <?php } ?>
            <?php if ($invasionPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=invasion">
                <img src="static/images/grunttype/4.png" style="width:22px;height:22px;"> <?php echo i8ln('Invasions'); ?>
              </a>
            <?php } ?>
            <?php if ($shinyPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=shiny">
                <img src="static/images/svg/shinysparkles.svg" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Shiny Rate'); ?>
              </a>
            <?php } ?>
            <?php if ($nestPage) { ?>
              <a class="dropdown-item" style="position:relative;left:-3px;" href="?page=nest">
                <img src="static/images/nest.png" style="width:22px;height:22px;filter:brightness(0%);"> <?php echo i8ln('Nests'); ?>
              </a>
            <?php } ?>
            <?php if ($homeUrl !== '' || $mapUrl !== '') { ?>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header"><?php echo i8ln('Other Pages'); ?></h6>
              <?php if ($homeUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $homeUrl; ?>">
                  <i class="fas fa-home"></i> <?php echo i8ln('Home'); ?>
                </a>
              <?php } ?>
              <?php if ($mapUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $mapUrl; ?>">
                  <i class="fas fa-map"></i> <?php echo i8ln('Map'); ?>
                </a>
              <?php } ?>
            <?php } ?>
            <?php if ($patreonUrl !== '' || $paypalUrl !== '') { ?>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header"><?php echo i8ln('Donate'); ?></h6>
              <?php if ($patreonUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $patreonUrl; ?>">
                  <i class="fab fa-patreon"></i> <?php echo i8ln('Patreon'); ?>
                </a>
              <?php } ?>
              <?php if ($paypalUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $paypalUrl; ?>">
                  <i class="fab fa-paypal"></i> <?php echo i8ln('PayPal'); ?>
                </a>
              <?php } ?>
            <?php } ?>
            <?php if ($discordUrl !== '' || $telegramUrl !== '') { ?>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header"><?php echo i8ln('Community'); ?></h6>
              <?php if ($discordUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $discordUrl; ?>">
                  <i class="fab fa-discord"></i> <?php echo i8ln('Discord'); ?>
                </a>
              <?php } ?>
              <?php if ($telegramUrl !== '') { ?>
                <a class="dropdown-item" href="<?php echo $telegramUrl; ?>">
                  <i class="fab fa-telegram-plane"></i> <?php echo i8ln('Telegram'); ?>
                </a>
              <?php } ?>
            <?php } ?>

           <?php if ($discord_login) { ?>
             <div class="dropdown-divider"></div>
             <h6 class="dropdown-header"><?php echo i8ln('Account'); ?></h6>
             <div class="dropdown-item">
               <?php
                 if (isset($_SESSION['user']->user)) {
                   echo '<i class="fas fa-user-check" style="color:green;"> ' . i8ln('Logged in') . '</i>';
                 } else {
                   echo '<a href="./discord-login.php" style="color:black;"><i class="fas fa-user" style="color:black;"></i> ' . i8ln('Login') . '</a>';
                 }
               ?>
             </div>
             <?php if (isset($_SESSION['user']->user)) { ?>
               <div class="dropdown-item">
                 <?php echo '<a href="./logout.php" title="' . i8ln('Click to logout') . '"><i class="fas fa-sign-out-alt" style="color:red;"> ' . i8ln('Logout') . '</i></a>'; ?>
               </div>
             <?php } ?>
           <?php } ?>

          </div>
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
            <i class="fas fa-globe-europe"></i>
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
