<?php

  /*
  * This is the main file in the plugin.
  * Most of the functions and data management
  * occurs here.
  */

  namespace corytortoise\DuelsPE;

  use pocketmine\plugin\PluginBase;
  use pocketmine\Server;
  use pocketmine\Player;
  use pocketmine\event\Listener;
  use pocketmine\utils\Config;
  use pocketmine\utils\TextFormat as C;

  //Plugin Files

  use corytortoise\DuelsPE\Match;
  use corytortoise\DuelsPE\EventListener;
  use corytortoise\DuelsPE\tasks\GameTimer;
  use corytortoise\DuelsPE\tasks\CheckTask;
  use corytortoise\DuelsPE\commands\DuelCommand;

    class Main extends PluginBase {

    /*** Config File ***/
    private $config;

    /*** Messages/Language File ***/
    private $messages;

    /*** Data File ***/
    private $data;

    /*** Kit Option ***/
    private $option;

    /*** GameManager ***/
    private $manager;

    /*** How often to refresh signs ***/
    public $signDelay;

    /*** Players in Queue ***/
    public $queue = array();

    /*
    *
    * Startup and Initialization
    *
    */

    public function onEnable() {
      $this->saveDefaultConfig();
      if(!is_dir($this->getDataFolder())) {
        mkdir($this->getDataFolder());
      }
	    $this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML,array("arenas" => array(), "signs" => array()))->getAll();
      $this->config = $this->getConfig();
      $this->saveResource("messages.yml");
      $this->messages = new Config($this->getDataFolder() . "messages.yml");
      $this->manager = new GameManager($this);
      $this->loadArenas();
      $this->loadSigns();
      $this->signDelay = $this->config->get("sign-refresh");
      $timer = new GameTimer($this);
      $this->getServer()->getScheduler()->scheduleRepeatingTask($timer, 20);
      $signTask = new SignUpdateTask($this);
      $this->getServer()->getScheduler()->scheduleRepeatingTask($this->signTask, $signDelay * 20);
      $this->loadKit();
      $this->getLogger()->notice($this->getPrefix() . C::YELLOW . "Loading arenas and signs...");
    }

    public function getPrefix() {
      $prefix = $this->config->get("prefix");
      $prefix = str_replace("&", "§", $prefix);
      return $prefix . " ";
    }

    private function loadArenas() {
      $this->getLogger()->notice($this->getPrefix() . C::YELLOW . "Loading arenas...");
      foreach($this->data["arenas"] as $arena) {
        $this->manager->loadArena($arena);
      }
    }

    private function loadSigns() {
      foreach($this->data["signs"] as $sign) {
        if($this->getServer()->isLevelLoaded($sign[3]) !== true) {
          $this->getServer()->loadLevel($sign[3]);
        }
        $level = $this->getServer()->getLevelByName($sign[3]);

      }
    }


    private function loadKit($kit) {
      if(!is_array($kit)) {
        $this->getLogger()->warning("Kit not configured properly. Using default...");
        $this->option = "default";
      } else {
        $this->option = "custom";
      }
    }

    //////////////////////////////////////////////
    //
    // API Methods
    //
    //////////////////////////////////////////////

    public function isPlayerInGame(Player $player) {
      if($this->manager->isPlayerInGame($player)) {
        return true;
      } else {
        return false;
      }
    }

    public function onDisable() {
      $this->manager->shutDown();
      $this->data->save();
    }

    /*
    *
    * Queue Management
    *
    */

    /** @var Player $player */
    public function addToQueue($player) {
      array_push($this->queue, $player->getName);
    }

    public function checkQueue() {
      if(count($this->queue) > 2) {
      //  if() ##TO-DO
      }
    } 

    /*
    *
    * Match Management
    *
    */

    /** @var Arena $arena */
    public function endMatch(Arena $arena) {

    }

    /**
    * This function will return true if a Player is in the defined arena.
    * It will return false if they are not. Leave $arena null to return the arena they are in.
    * @var Player $player
    * @var Arena $arena
    */
    public function getMatchFromPlayer($player, $arena = null) {
      if($arena == null) {
        if($this->manager->getPlayerArena($player) !== null) {
          return $this->manager->getPlayerArena($player);
        } else {
          return null;
        }
      } else {
        if($this->manager->isPlayerInArena($player, $arena) == true) {
          return true;
        } else {
          return false;
        }
      }
    }
    /** @var string $name */
    public function getArenaByName($name = "null") {
      return $this->manager->getArenaByName($name);
    }

  }
