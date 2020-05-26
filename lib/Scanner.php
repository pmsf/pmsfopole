<?php

namespace Scanner;

class Scanner
{
  public function __construct()
  {
    $pokemon_json_contents = file_get_contents("static/dist/data/pokemon.min.json");
    $this->pokedex = json_decode($pokemon_json_contents, true);

    $item_json_contents = file_get_contents("static/dist/data/items.min.json");
    $this->itemdex = json_decode($item_json_contents, true);

    $invasion_json_contents = file_get_contents("static/dist/data/grunttype.min.json");
    $this->gruntdex = json_decode($invasion_json_contents, true);
  }
}
