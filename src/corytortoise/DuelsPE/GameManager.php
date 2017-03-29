<?php

  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */

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
      $spawn1 = new Location($data[0][0], $data[0][1], $data[0][2], $data[0][3], $data[0][4], $data["level"]);
      $spawn2 = new Location($data[1][0], $data[1][1], $data[1][2], $data[1][3], $data[1][4], $data["level"]);
      $arena = new Arena($this, $spawn1, $spawn2);
      array_push($this->arenas, $arena);
    }

    /**
     * Starts an Arena, beginning with pre-match countdown.
     * @param Player $player1
     * @param Player $player2
     */
    public function startArena(array $players) {
      $arena = $this->chooseRandomArena();
      if($arena !== null) {
        $arena->addPlayers($players);
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
      } else {
        return array_rand($freeArenas);
      }
    }

    public function shutDown() {

    }
    /**
    * Gets the arena of a Player.
    * TODO: Use Player ID instead of Username for player management
    * @param Player $player
    * @return Arena $arena
    */
    public function getPlayerArena($player) {
      foreach($this->arenas as $arena) {
        foreach($arena->getPlayers() as $p) {
          if($p == $player->getName()) {
            return $arena;
          }
        }
      }
    }
    
    /**
     * 
     * @param Player $loser
     */
    public function playerDeath(Player $loser) {
      $this->getPlayerArena($loser)->removePlayer($loser);
    }

  }
