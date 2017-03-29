<?php

  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */
    
  namespace corytortoise\DuelsPE;

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
     * @param type $spawn1
     * @param type $spawn2
     */
    public function __construct(GameManager $manager, $spawn1, $spawn2) {
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
        $this->addNoticeSubscriber($p);
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
    }

    // This is used to start a game AFTER the prematch countdown
    public function startGame() {

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
