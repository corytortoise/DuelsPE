<?php

  /*
  * This class holds info for an arena.
  * TODO: Allow for more info per arena.
  * TODO:
  */
  namespace corytortoise\DuelsPE;

  use corytortoise\DuelsPE\GameManager;

  class Arena {

    private $manager;

    private $spawn1;
    private $spawn2;

    private $players = array();
    
    private $team1 = array();
    private $team2 = array();
    private $teamCount = 2;

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
    public function __construct(GameManager $manager, $spawn1, $spawn2, $teamCount = 1) {
      $this->manager = $manager;
      $this->spawn1 = $spawn1;
      $this->spawn2 = $spawn2;
      $this->beforeMatch = $manager->plugin->config->get("match-countdown");
      $this->matchTime = $manager->plugin->config->get("time-limit");
      $this->timer = $this->beforeMatch + $this->matchTime;
      $this->teamCount = $teamCount;
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
        if($this->team1 <= $this->teamCount) {
          $this->team1[] = $p;
        } else {
          $this->team2[] = $p;
        }
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
    }

    // This is used to start a game AFTER the prematch countdown
    public function startGame() {

    }

    public function getPlayers() {
      return $this->players;
    }
    

    public function endPreCountdown() {
      $p = $this->players;
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
