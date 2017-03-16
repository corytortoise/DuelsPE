<?php

  /* This event will be called when a match ends.
  * It will allow for other plugins to perform actions at the end of each match, and they will be able to get the winner, the loser, etc.
  * I will eventually use this for a stats extension plugin too.
  * Implementing Cancellable is probably unnecessary, but I'll do it anyway.
  */

  namespace corytortoise\DuelsPE\events;

  use pocketmine\event\plugin\PluginEvent;
  use pocketmine\event\Cancellable;
  use pocketmine\Player;

  use corytortoise\DuelsPE\Main;

  class GameEndEvent extends PluginEvent implements Cancellable {

    private $plugin;

    private $winner;
    private $loser;

    private $arena;

    public function __construct(Main $plugin, Player $winner, Player $loser, Arena $arena) {
      parent::__construct($plugin);
      $this->plugin = $plugin;
      $this->winner = $winner;
      $this->loser = $loser;
      $this->arena = $arena;
    }

    public function getWinner() {
      return $this->winner;
    }

    public function getLoser() {
      return $this->loser;
    }

    public function getArena() {
      return $this->arena;
    }

  }
