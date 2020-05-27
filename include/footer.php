<!-- Footer -->
<footer class="mainfooter" role="contentinfo">
  <div class="footer-middle">
    <div class="container">
      <?php if (($discordUrl !== '' || $telegramUrl !== '' || $paypalUrl !== '' || $patreonUrl !== '') && $footerIcons) { ?>
        <div class="row">
          <div class="col-md-12 text-center">
            <h4 style="position:relative;top:-5px;"><?php echo i8ln('Follow Us'); ?></h4>
            <ul class="social-network social-circle">
              <?php if ($discordUrl !== '') { ?>
                <li><a href="<?php echo $discordUrl; ?>" class="icoDiscord" title="Discord"><i class="fab fa-discord"></i></a></li>
              <?php } ?>
              <?php if ($telegramUrl !== '') { ?>
                <li><a href="<?php echo $telegramUrl; ?>" class="icoTelegram" title="Telegram"><i class="fab fa-telegram-plane"></i></a></li>
              <?php } ?>
              <?php if ($paypalUrl !== '') { ?>
                <li><a href="<?php echo $paypalUrl; ?>" class="icoPaypal" title="PayPal"><i class="fab fa-paypal"></i></a></li>
              <?php } ?>
              <?php if ($patreonUrl !== '') { ?>
                <li><a href="<?php echo $patreonUrl; ?>" class="icoPatreon" title="Patreon"><i class="fab fa-patreon"></i></a></li>
              <?php } ?>
            </ul>				
          </div>
        </div>
        <br>
      <?php } ?>
      <div class="row">
        <div class="col-md-12 copy">
          <p class="text-center">
            <?php echo i8ln('This website or the authors have no relationship with Niantic, Nintendo or any other Pokémon Go responsible.'); ?><br/><br/>
            <?php echo i8ln('Pokémon Go is &copy;2016 Niantic, Inc. &copy;2016 Pokémon. &copy;1995–2016 Nintendo / Creatures Inc. / GAME FREAK Inc.'); ?><br/><br/>
            <?php echo i8ln('Pokémon and Pokémon character names are trademarks of Nintendo. Other trademarks are the property of their respective owners.'); ?><br/>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>