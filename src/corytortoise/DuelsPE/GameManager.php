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
      if($this->plugin->getServer()->isLevelLoaded($data["level"]) == false) {
        $this->plugin->getServer()->loadLevel($this->plugin->getServer()->getLevelByName($data["level"]));
      }
      //TODO: Fix this.
      $spawn1 = new Location($data[0][0], $data[0][1], $data[0][2], $data[0][3], $data[0][4], $data[0][5], $data["level"]);
      $spawn2 = new Location($data[1][0], $data[1][1], $data[1][2], $data[1][3], $data[1][4], $data[1][5], $data["level"]);
      $arena = new Arena($this, $spawn1, $spawn2);
      array_push($this->arenas, $arena);
    }

    public function startArena($player1, $player2) {
      $arena = $this->chooseRandomArena();
      if($arena !== null) {
        $arena->addPlayers($player1, $player2)
        $arena->start();
      }
    }

    public function chooseRandomArena() {
      $freeArenas = array();
      foreach($this->arenas as $arena) {
        if($arena->isActive() == false) {
          array_push($freeArenas, $arena);
        }
      }
      if(empty($freeArenas)) {
        return;
      }
    }


  }
