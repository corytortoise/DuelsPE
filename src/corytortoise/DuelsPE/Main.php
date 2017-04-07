<?php

  /* ____             _     ____  _____ 
  * |  _ \ _   _  ___| |___|  _ \| ____|
  * | | | | | | |/ _ \ / __| |_) |  _|  
  * | |_| | |_| |  __/ \__ \  __/| |___ 
  * |____/ \__,_|\___|_|___/_|   |_____|
  */

  namespace corytortoise\DuelsPE;

  use pocketmine\plugin\PluginBase;
  use pocketmine\Player;
  use pocketmine\utils\Config;
  use pocketmine\utils\TextFormat;

  //Plugin Files

  use corytortoise\DuelsPE\tasks\SignUpdateTask;
  use corytortoise\DuelsPE\EventListener;
  use corytortoise\DuelsPE\tasks\GameTimer;
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
    public $manager;

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
      $this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML,array("arenas" => array(), "signs" => array()));
      $this->config = $this->getConfig();
      $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
      $this->saveResource("messages.yml");
      $this->messages = new Config($this->getDataFolder() . "messages.yml");
      $this->manager = new GameManager($this);
      $this->loadArenas();
      $this->loadSigns();
      $this->signDelay = $this->config->get("sign-refresh");
      $timer = new GameTimer($this);
      $this->getServer()->getScheduler()->scheduleRepeatingTask($timer, 20);
      $this->signTask = new SignUpdateTask($this);
      $this->getServer()->getScheduler()->scheduleRepeatingTask($this->signTask, $this->signDelay * 20);
      $this->loadKit();
      $this->registerCommand();
      $this->getLogger()->notice($this->getPrefix() . TextFormat::YELLOW . "Loading arenas and signs...");
      $this->getLogger()->notice($this->getPrefix() . TextFormat::GREEN . "Loaded " . count(array_keys($this->manager->arenas)) . " Arenas!");
    }

    public function getPrefix() {
      $prefix = $this->config->get("prefix");
      $finalPrefix = str_replace("&", "§", $prefix);
      return $finalPrefix . " ";
    }
	    
    public function registerCommand() {
        $this->getServer()->getCommandMap()->registerCommand("duel", new DuelCommand("duel", $this));
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

    /**
     * 
     * @param type $kit
     */
    private function loadKit($kit) {
      if(!is_array($kit)) {
        $this->getLogger()->warning("Kit not configured properly. Using default...");
        $this->option = "default";
      } else {
        $this->option = "custom";
      }
    }
    
    /**
     * 
     * @param string $message
     * @return string $finalMessage
     */
    public static function getMessage(string $message = "") {
      $msg = $this->messages->get($message);
      if($msg != null) {
      $finalMessage = str_replace("&", TextFormat::ESCAPE, $msg);
      return $finalMessage;
      } else {
        return $this->getPrefix() . "Uh oh, no message found!";
      }
    }

    //////////////////////////////////////////////
    //
    // API Methods
    //
    //////////////////////////////////////////////

    /**
     * 
     * @param Player $player
     * @return boolean
     */
    public function isPlayerInGame(Player $player) {
      if($this->manager->isPlayerInGame($player)) {
        return true;
      } else {
        return false;
      }
    }

    /*
    *
    * Queue Management
    *
    */

    /**
     * Adds a specific pocketmine\Player to the queue.
     * @param Player $player
     */
    public function addToQueue(Player $player) {
      $player->sendMessage($this->getPrefix() . $this->getMessage("queue-join"));
      array_push($this->queue, $player->getName());
    }

    public function checkQueue() {
      if(count($this->queue) > 2) {
        //TODO: Rework this for teams.
        if($this->isArenaAvailable()) {
          $this->manager->startArena(array_shift($this->queue), array_shift($this->queue));
        }
      }
    } 
    
    public function isArenaAvailable() {
      if($this->getArenaCount() - $this->getActiveArenaCount() >= 1) {
        return true;
      } else {
        return false;
      }
    }

    /*
    *
    * Match Management
    *
    */

    /**
     * 
     * @param \corytortoise\DuelsPE\Arena $arena
     */
    public function endMatch(Arena $arena) {
        $arena->stop();
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

    /**
     * 
     * @param type $name
     * @return type
     */
    public function getArenaByName($name = "null") {
      return $this->manager->getArenaByName($name);
    }

    /**
     * 
     * @return int Arenas
     */
    public function getArenaCount() {
      return count($this->manager->arenas);
    }

    /* Returns number of active arenas */
    public function getActiveArenaCount() {
    $count = 0;
      foreach($this->manager->arenas as $arena) {
        if($arena->isActive() === true) {
          $count++;
        } else {
          continue;
        }
      }
    }

    public function onDisable() {
      $this->manager->shutDown();
      $this->config->save();
    }
    
  }
  
  
