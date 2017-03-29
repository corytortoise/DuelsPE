<?php

  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */

  namespace corytortoise\DuelsPE;

  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerDeathEvent;
  use pocketmine\event\player\PlayerQuitEvent;

  //DuelsPE Files
  use corytortoise\DuelsPE\Main;

  class EventListener implements Listener {

    public function __construct(Main $plugin) {
      $this->plugin = $plugin;
    }

    public function onDeath(PlayerDeathEvent $event) {
      $player = $event->getPlayer();
      if($this->plugin->isPlayerInGame($player) === true) {
        $this->plugin->manager()->playerDeath($player);
      }
    }
    
    public function onQuit(PlayerQuitEvent $event) {
      $player = $event->getPlayer();
      if($this->plugin->isPlayerInGame($player) === true) {
        $this->plugin->manager()->playerDeath($player);
      }
    }
  }
