<?php

  /*
  * This class holds info for an arena.
  * TODO: Allow for more info per arena.
  * TODO: 
  */
  namespace corytortoise\DuelsPE;

  use corytortoise\DuelsPE\Main;
  use corytortoise\DuelsPE\GameManager;

  class Arena {

    private $manager;

    private $spawn1;
    private $spawn2;

    private $players = array();

    private $active = false;

    private $beforeMatch = 10;
    private $matchTime = 180;

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

    public function isActive() {
      if($this->active == true) {
        return true;
      } else {
        return false;
      }
    }

    public function tick() {
     $this->timer--;
     if($this->timer - $this->beforeMatch == $this->matchTime) {
       // Prematch countdown is over, so the round should start.
       $this->endPreCountdown();
     }
     if ($this->timer <= 0) {
       // Timer has run out, so game should end.
       $this->endGame(true);
     }
    }

    // This is used to start a game AFTER the prematch countdown
    public function startGame(array $players) {

    }

    public function getPlayers() {
      return $this->players;
    }

    public function endPreCountdown() {
      $p = $this->players;
      $p[0]->teleport($this->)
    }


  }