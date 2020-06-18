<?php
$pokemon_json_contents = file_get_contents("static/dist/data/pokemon.min.json");
$pokedex = json_decode($pokemon_json_contents, true);

$family_json_contents = file_get_contents("static/dist/data/pokedex.min.json");
$family = json_decode($family_json_contents, true);

$numberOfPokemon = 649;
?>


<div class="container">

  <div class="row">
    <div class="col">
      <h2 class="text-center" style="border:1px solid #9a9a9a;">
        <img src="static/images/pokedex-kanto.png" style="width:70px;height:70px;">
        <?php echo i8ln('Pokédex'); ?>
      </h2>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="form-group has-search">
        <span class="fa fa-search form-control-feedback"></span>
        <input class="form-control" id="pokedex-search-input" type="text" placeholder="Search...">
      </div>
    </div>
  </div>
 
  <div class="row pokedex-row text-center m-0" id="pokedex-search-list">
    <?php
      $i = 1;
      foreach ($pokedex as $pokemon) {
        $id = $i;
        if ($id <= 9) {
          $id = '00' . $id;
        } elseif ($id <= 99) {
          $id = '0' . $id;
        }
        if ($i <= $numberOfPokemon) {
          echo '<div class="col pokedex-col" id="' . i8ln($pokemon['name']) . '-col" data-toggle="modal" data-target="#' . i8ln($pokemon['name']) . '">
            <a href="#' . i8ln($pokemon['name']) . '" style="color:#212529;">
              <img src="' . $pokemonIconPath . 'pokemon_icon_' . $id .'_00.png" style="height:60px;">
              <br>' . i8ln($pokemon['name']) . '
            </a>
          </div>';

          $html = '<a href="?page=pokedex#' . i8ln($pokemon['name']) . '"><img src="' . $pokemonIconPath . 'pokemon_icon_' . $id . '_00.png" style="height:60px;"></a>';

          foreach ($family as $fam) {
            $count = count($fam[$i]['evolutions']);
            $loop = 1;
            $loop2 = 1;
            foreach ($fam[$i]['evolutions'] as $evolution) {
              if ($evolution <= 9) {
                $evolutionId = '00' . $evolution;
              } elseif ($evolution <= 99) {
                $evolutionId = '0' . $evolution;
              } else {
                $evolutionId = $evolution;
              }

              $style = '';
              if ($loop > 1 && $loop2 > 1) {
                $html .= '<br>';
                $style = 'style="position:relative;left:-65px;-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"';
              } elseif ($loop > 1) {
                $html .= '<br>';
                $style = 'style="position:relative;left:-30px;top:10px;-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"';
              }
              if ($evolution < $numberOfPokemon) {
                if ($loop > 1) {
                  $html .= ' <i class="fas fa-arrow-right"' . $style . '></i><br> <img src="' . $pokemonIconPath . 'pokemon_icon_' . $evolutionId . '_00.png" style="height:60px;">';
                } else {
                  $html .= ' <i class="fas fa-arrow-right"' . $style . '></i> <img src="' . $pokemonIconPath . 'pokemon_icon_' . $evolutionId . '_00.png" style="height:60px;">';
                }
              }

              foreach ($fam[$evolution]['evolutions'] as $evolution) {
                if ($evolution <= 9) {
                  $evolutionId = '00' . $evolution;
                } elseif ($evolution <= 99) {
                  $evolutionId = '0' . $evolution;
                } else {
                  $evolutionId = $evolution;
                }
              
                if ($evolution < $numberOfPokemon) {
                  if ($loop > 1 && $loop2 > 1) {
                    $html .= '<i class="fas fa-arrow-right"></i>' . ' <img src="' . $pokemonIconPath . 'pokemon_icon_' . $evolutionId . '_00.png" style="height:60px;">';
                  } elseif ($loop2 > 1) {
                    $html .= '<br><i class="fas fa-arrow-down"></i><br>' . ' <img src="' . $pokemonIconPath . 'pokemon_icon_' . $evolutionId . '_00.png" style="height:60px;">';
                    $html .= '<br>';
                  } else {
                    $html .= ' <i class="fas fa-arrow-right"></i> ' . ' <img src="' . $pokemonIconPath . 'pokemon_icon_' . $evolutionId . '_00.png" style="height:60px;">';
                  }
                }
                $loop2++;
              }
              $loop++;
            }
          }

          $html .= '
            <div class="row">
              <div class="col">
                <ul class="list-group mt-4">';
                  if (isset($fam[$i]['thirdmove']['candyToUnlock']) && isset($fam[$i]['thirdmove']['stardustToUnlock'])) {
                    $html .= '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <small><b>' . i8ln('Third Move Cost') . ':</b></small>
                      <small>' . $fam[$i]['thirdmove']['candyToUnlock'] . ' ' . i8ln('Candy') . ' / ' . $fam[$i]['thirdmove']['stardustToUnlock'] . ' ' . i8ln('Stardust') . '</small>
                    </li>';
                  }
                  if (isset($fam[$i]['buddy_distance']) && !empty($fam[$i]['buddy_distance'])) {
                    $html .= '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <small><b>' . i8ln('Buddy Distance') . ':</b></small>
                      <small>' . $fam[$i]['buddy_distance'] . i8ln('km') . '</small>
                    </li>';
                  }
                  if (isset($fam[$i]['attack']) && isset($fam[$i]['defense']) && isset($fam[$i]['stamina'])) {
                    $html .= '
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <small><b>' . i8ln('Attack / Defense / Stamina') . ':</b></small>
                      <small>' . $fam[$i]['attack'] . ' / ' . $fam[$i]['defense'] . ' / ' . $fam[$i]['stamina'] . '</small>
                    </li>';
                  }
                  $html .= '
                </ul>
              </div>
            </div>
            <br>
            <div class="row">';
              if (isset($fam[$i]['quickmove'])) {
                $html .= '
                <div class="col">
                  <ul class="list-group">
                    <li class="list-group-item align-items-center">
                      <small><b>' . i8ln('Quick Moves') . '</b></small>
                    </li>';
                    foreach ($fam[$i]['quickmove'] as $quickmove) {
                      $html .= '<li class="list-group-item align-items-center">
                        <small>' . i8ln($quickmove) . '</small>
                      </li>';
                    }
                    $html .= '
                  </ul>
                </div>';
              }
              if (isset($fam[$i]['chargedmove'])) {
                $html .= '
                <div class="col">
                  <ul class="list-group">
                    <li class="list-group-item align-items-center">
                      <small><b>' . i8ln('Charge Moves') . '</b></small>
                    </li>';
                    foreach ($fam[$i]['chargedmove'] as $chargemove) {
                      $html .= '<li class="list-group-item align-items-center">
                        <small>' . i8ln($chargemove) . '</small>
                      </li>';
                    }
                    $html .= '
                  </ul>
                </div>';
              }
              $html .= '
            </div>';


          $typehtml = '';
          foreach ($pokemon['types'] as $type) {
            $typehtml .= '<img src="static/images/types/' . $type['type'] . '.png" style="height:20px;">';
          }

          echo '<div class="modal fade" id="' . i8ln($pokemon['name']) . '" tabindex="-1" role="dialog" aria-labelledby="pokedexModalTitle' . $i . '" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="pokedexModalTitle' . $i . '">
                    #' . $i . ' ' . i8ln($pokemon['name']) . ' ' . $typehtml . '
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-window-close" style="color:red;font-size:20px;"></i></span>
                  </button>
                </div>
                <div class="modal-body">' . $html . '</div>
                <div class="modal-footer">
                  <small><b>' . i8ln($fam[$i]['dex']) . '</b></small>
                  <a href="?page=pokedex#' . i8ln($pokedex[$i-1]['name']) . '">
                    <button type="button" class="btn btn-default" style="border: 1px solid #dfdfdf">' . i8ln('Previous') . '</button>
                  </a>
                  <a href="?page=pokedex#' . i8ln($pokedex[$i+1]['name']) . '">
                    <button type="button" class="btn btn-default" style="border: 1px solid #dfdfdf">' . i8ln('Next') . '</button>
                  </a>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">' . i8ln('Close') . '</button>
                </div>
              </div>
            </div>
          </div>';
        }
        $i++;
      }
    ?>
  </div>
</div>
