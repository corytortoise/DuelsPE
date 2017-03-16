<?php

  /* This event will be called at the beginning of each match.
  * Possible uses include custom arena starting, like giving both players effects
  * or something.
  */

  namespace corytortoise\DuelsPE\events;

  use pocketmine\event\plugin\PluginEvent;
  use pocketmine\event\Cancellable;
  use pocketmine\Player;

  use corytortoise\DuelsPE\Main;

  class GameStartEvent extends PluginEvent implements Cancellable {

    private $plugin;

    private $players = array();

    private $arena;

    public function __construct(Main $plugin, Player[] $players, Arena $arena) {
      parent::__construct($plugin);
      $this->plugin = $plugin;
      $this->players = $players;
      $this->arena = $arena;
    }

    public function getPlayers() {
      return $this->players;
    }

    public function getArena() {
      return $this->arena;
    }

  }
