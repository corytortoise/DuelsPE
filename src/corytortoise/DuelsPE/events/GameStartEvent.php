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
use corytortoise\DuelsPE\Arena;

class GameStartEvent extends PluginEvent {
	/** @var Main */
	private $plugin;
	/** @var Player[] */
	private $players = array();
	/** @var Arena */
	private $arena;

	 /**	
 	* @param Main	 	$plugin
	 * @param Array		 $players
	 * @param Arena		$arena
	 */
	public function __construct(Main $plugin, Array $players, Arena $arena) {
		parent::__construct($plugin);
		$this->plugin = $plugin;
		$this->players = $players;
		$this->arena = $arena;
	}

	/** @return Player[] */
	public function getPlayers() {
		return $this->players;
	}

	/** @return Arena */
	public function getArena() {
		return $this->arena;
	}
}
