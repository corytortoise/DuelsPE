<?php

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

    public function onEnable() {
      $this->saveDefaultConfig();
      if(!is_dir($this->getDataFolder()) {
        mkdir($this->getDataFolder());
      }
	   $this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML,array("arenas" => array(), "signs" => array()));
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

    public function loadArenas() {
      $this->getLogger()->notice($this->getPrefix() . C::YELLOW . "Loading arenas...");
      foreach($this->data["arenas"] as $arena) {
        $this->manager->loadArena($arena);
      }
    }

    public function loadSigns() {
      foreach($this->data["signs"] as $sign) {
        if($this->getServer()->isLevelLoaded($sign[3]) !== true) {
          $this->getServer()->loadLevel($sign[3]);
        }
        $level = $this->getServer()->getLevelByName($sign[3]);
        if(
      }
    }


    public function loadKit($kit) {
      if(!is_array($kit)) {
        $this->getLogger()->warning("Kit not configured properly. Using default...");
        $this->option = default;
      } else {
        $this->option = custom;
      }
    }

  }
