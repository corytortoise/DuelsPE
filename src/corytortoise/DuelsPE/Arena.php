<?php

  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */
    
  namespace corytortoise\DuelsPE;
  
  use pocketmine\level\Location;

  use corytortoise\DuelsPE\GameManager;

  class Arena {

    private $manager;

    private $spawn1;
    private $spawn2;

    private $players = array();

    private $active = false;

    private $timer = 190;
    private $beforeMatch = 10;
    private $matchTime = 180;

    /**
     * 
     * @param GameManager $manager
     * @param Location $spawn1
     * @param Location $spawn2
     */
    public function __construct(GameManager $manager, Location $spawn1, Location $spawn2) {
      $this->manager = $manager;
      $this->spawn1 = $spawn1;
      $this->spawn2 = $spawn2;
      $this->beforeMatch = $manager->plugin->config->get("match-countdown");
      $this->matchTime = $manager->plugin->config->get("time-limit");
      $this->timer = $this->beforeMatch + $this->matchTime;
    }

    public function start() {
      $this->active = true;
    }
    
    /**
     * Adds players to arena arrays for later.
     * @param array $players
     */
    public function addPlayers(array $players) {
      foreach($players as $p) {
        $this->players[] = $p;
      }
    }

    public function isActive() {
      if($this->active == true) {
        return true;
      } else {
        return false;
      }
    }

    public function tick() {
      $this->timer--;
      if($this->timer - $this->beforeMatch === $this->matchTime) {
        // Prematch countdown is over, so the round should start.
        $this->endPreCountdown();
      }
      if ($this->timer <= 0) {
        // Timer has run out, so game should end.
        $this->stop("you ran out of time!");
      } 
      if($this->timer - $this->beforeMatch > $this->matchTime) {
        $seconds = $this->timer - $this->beforeMatch;
        foreach($this->getPlayers() as $p) {
          $p->sendPopup(str_replace("%s", $seconds, Main::getMessage("duel-countdown")));
        }
      }
       elseif($this->timer - $this->beforeMatch < $this->matchTime) {
          foreach($this->getPlayers() as $p) {
            $this->sendGameTime($p);
          }
        }
      }

    // This is used to start a game AFTER the prematch countdown
    public function startGame() {
      $player1 = $this->players[0];
      $player2 = $this->players[1];
      $player1->teleport($this->spawn1);
      $player2->teleport($this->spawn2);
      $this->kitHandler($this->players);
    }

    public function getPlayers() {
      return $this->players;
    }
    
    public function getOpponent($player) {
      foreach($this->getPlayers() as $p) {
        if($player != $p) {
          return $p;
        }
      }
    }

    public function endPreCountdown() {
      foreach($this->getPlayers() as $p) {
        $opposite = $this->getOpponent($p);
        $p->sendPopup(str_replace("%p", $opposite, Main::getMessage("duel-start")));
      }
    }
    
    public function sendGameTime($p) {
      $m = $this->timer / 60;
      $s = $this->timer % 60;
      if($s < 10) {
        $s = "0" . $s;
      }
      $p->sendPopup(str_replace("%t", $m . ":" . $s, Main::getMessage("duel-timer")));
    }
    
    public function kitHandler($players) {
      if(!$this->manager->plugin->getConfig()->get("force-kits")) {
        return;
      } else {
        foreach($players as $p) {
          
        }
      }
    }
    
    /**
     * Used when a player or team wins. 
     * @param Array|Player $winner
     */
    public function endMatch($winner) {
      if(is_array($winner)) {
        
      }
    }
    
    /**
     * This can be used by other plugins to force stop a duel.
     * @param type $cause
     */
    public function stop($cause = "") {
      foreach($this->players as $player) {
        if($player->isOnline()) {
          $player->sendMessage($this->manager->plugin->getPrefix() . "Duel was stopped because " . $cause);
          $player->teleport($player->getSpawn());
          
        }
      }
    }

  }
