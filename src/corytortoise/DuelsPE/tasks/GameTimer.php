<?php
  
  /* This task will take one second from each active match. */

  namespace corytortoise\DuelsPE\tasks;

  use pocketmine\scheduler\PluginTask;
 
  class GameTimer extends PluginTask {

  private $public;

    public function __construct(Main $plugin) {
      parent::__construct($plugin);
      $this->plugin = $plugin;
    }

    public function onRun($currentTick) {
      foreach($this->plugin->manager->arenas as $arena) {
        $arena->tick();
      }
    }


  }