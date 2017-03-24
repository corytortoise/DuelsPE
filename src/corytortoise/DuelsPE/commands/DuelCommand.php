<?php

  /*
  * This Class will handle all commands and getting positions of players when they do /duel 1 or /duel 2.
  * Maybe that should be moved to the main class?
  */

  namespace corytortoise\DuelsPE\commands;

  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\Player;

  use corytortoise\DuelsPE\Main;

  class DuelCommand extends Command {

  private $plugin;

  private $pos1 = array();
  private $pos2 = array();

    public function __construct(Main $plugin) {
      parent::__construct("duel", "Main DuelsPE command", "Usage: /duel [ create | join | 1 | 2 | quit ]", ["duel"]);
      $this->plugin = $plugin;
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
      if($sender instanceof Player) {
        if(!isset($args[0])) {
          if($this->plugin->isPlayerInQueue($sender) == false) {
            $this->plugin->addToQueue($sender);
          }
        } else {

        switch($args[0]) {

            case "join":
              if($this->plugin->isPlayerInQueue($sender) === false) {
                $this->plugin->addToQueue($sender);
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("in-queue"));
              }
            break;

            case "quit":
            case "leave":
              if($this->plugin->isPlayerInQueue($sender) === false) {
                $this->plugin->removeFromQueue($sender);
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("not-in-queue"));
              }

            break;
            case "1":

            break;
            case "2":

            break;
            case "create":

            break;
            default:
            $sender->sendMessage($this->getPrefix() . $this->getUsage());
            break;
          }
        }
      }
    }

    public function getPrefix() {
      return $this->plugin->getPrefix();
    }

    public function getMessage($string = "null") {
      return $this->plugin->getMessage($string);
    }

  }
