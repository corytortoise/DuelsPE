<?php
    
  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */

  namespace corytortoise\DuelsPE\events;

  use pocketmine\event\plugin\PluginEvent;
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
	 * @param Array		$players
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
