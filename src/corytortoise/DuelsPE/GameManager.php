<?php

  namespace corytortoise\DuelsPE;

  use corytortoise\DuelsPE\Main;
  use corytortoise\DuelsPE\Arena;

  class GameManager {

    public $arenas = array();
    private $plugin;

    public function __construct(Main $plugin) {
      $this->plugin = $plugin;
    }

    public function loadArena($data) {
      if($this->plugin->getServer()->isLevelLoaded($data["level]) == false) {
        $this->plugin->getServer()->loadLevel($this->plugin->getServer()->getLevelByName($data["level"]));
      }
      $spawn1 =
      $arena = new Arena($this, $spawn1, $spawn2);
      array_push($this->arenas, $arena);
    }


  }
