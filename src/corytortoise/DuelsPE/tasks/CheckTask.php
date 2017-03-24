<?php

  namespace corytortoise\DuelsPE\tasks;

  use pocketmine\scheduler\PluginTask;
  use corytortoise\DuelsPE\Main;

  class CheckTask extends PluginTask {
    
    private $plugin;

    public function __construct(Main $plugin) {
      $this->plugin = $plugin;
    }
    
    public function onRun($currentTick){
      $this->plugin->checkQueue();
   }
    
  }
