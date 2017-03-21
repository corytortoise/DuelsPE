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
use corytortoise\DuelsPE\Arena;

class GameEndEvent extends PluginEvent {
	/** @var Main */
	private $plugin;
	/** @var Player */
	private $winner;
	/** @var Player */
	private $loser;
	/** @var Arena */
	private $arena;

  /**	
 	* @param Main $plugin
	 * @param Player            $winner
	 * @param Player          $looser
	 * @param Arena             $arena
	 */
	public function __construct(Main $plugin, Player $winner, Player $loser, Arena $arena) {
		parent::__construct($plugin);
		$this->plugin = $plugin;
		$this->winner = $winner;
		$this->loser = $loser;
		$this->arena = $arena;
	}

	/**
	 * @return Player
	 **/
	public function getWinner() {
		return $this->winner;
	}

	/**
	 * @return Player
	 **/
	public function getLoser() {
		return $this->loser;
	}

	/**
	 * @return Arena
	 **/
	public function getArena() {
		return $this->arena;
	}
}
