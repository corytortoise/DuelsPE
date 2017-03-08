<?php

  namespace corytortoise\DuelsPE;

  use corytortoise\DuelsPE\Main;
  use corytortoise\DuelsPE\GameManager;

  class Arena {

    private $manager;

    private $spawn1;
    private $spawn2;

    private $active = false;

    private $beforeMatch;
    private $matchTime;

    public function __construct(GameManager $manager, $spawn1, $spawn2) {
      $this->manager = $manager;
      $this->spawn1 = $spawn1;
      $this->spawn2 = $spawn2;
      $this->beforeMatch = $manager->plugin->config->get("match-countdown");
      $this->matchTime = $manager->plugin->config->get("time-limit");
    }

    public function isActive() {
      if($this->active == true) {
        return true;
      } else {
        return false;
      }
    } 

    public function tick() {

    }



  }