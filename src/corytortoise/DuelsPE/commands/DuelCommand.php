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
          if(!$this->plugin->isPlayerInQueue($sender)) {
            if(!$this->plugin->isPlayerInGame($sender)) {
            $this->plugin->addToQueue($sender);
            } else {
              $sender->sendMessage($this->getPrefix() . $this->getMessage("command-usage"));
            } 
          } else {
            $sender->sendMessage($this->getPrefix() . $this->getMessage("command-usage"));
          }
        } else {

        switch($args[0]) {

            case "join":
              if(!$this->plugin->isPlayerInQueue($sender)) {
                if(!$this->plugin->isPlayerInGame($sender)) {
                $this->plugin->addToQueue($sender);
                } else {
                  $sender->sendMessage($this->getPrefix() . $this->getMessage("in-game"));
                }
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("in-queue"));
              }
            break;

            case "quit":
            case "leave":
              if($this->plugin->isPlayerInQueue($sender)) {
                $this->plugin->removeFromQueue($sender);
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("not-in-queue"));
              }

            break;
            case "1":
              if($sender->isOp() || $sender->hasPermission("duelspe.create")) {
                $this->savePosition($sender, 1);
                $sender->sendMessage($this->getPrefix() . $this->getMessage("pos1-set"));
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("no-perm"));
              }
            break;
            case "2":
              if($sender->isOp() || $sender->hasPermission("duelspe.create")) {
                $this->savePosition($sender, 2);
                $sender->sendMessage($this->getPrefix() . $this->getMessage("pos2-set"));
              } else {
                $sender->sendMessage($this->getPrefix() . $this->getMessage("no-perm"));
              }
            break;
            case "create":
              if($sender->isOp() || $sender->hasPermission("duelspe.create")) {
                if(isset($this->pos1[$sender->getName()]) && isset($this->pos2[$sender->getName()])) {
                  $this->createArena($sender, $this->parseOptions($args));
                  $sender->sendMessage($this->getPrefix() . $this->getMessage("arena-set"));
                }
              }
            break;
            default:
            $sender->sendMessage($this->getPrefix() . $this->getMessage("command-usage"));
            break;
          }
        }
      }
    }

    private function getPrefix() {
      return $this->plugin->getPrefix();
    }

    private function getMessage(string $string = "") {
      return $this->plugin->getMessage($string);
    }
    
    private function savePosition(Player $sender, int $spawnpoint = 1) {
      //TODO: There must be a better way to save Locations. Maybe look into the methods PM uses?
      $pos = array($sender->getX(), $sender->getY(), $sender->getZ(), $sender->getYaw(), $sender->getPitch(), $sender->getLevel());
      if($spawnpoint === 1) {
        $this->pos1[$sender->getName()] = $pos;
        return;
      } elseif($spawnpoint === 2) {
        $this->pos2[$sender->getName()] = $pos;
        return;
      }
    }
    
    private function createArena(Player $player, array $options) {
      $this->manager->plugin->createArena($this->pos1[$player->getName()], $this->pos2[$player->getName()], $options);
    }
    
    private function parseOptions(array $data) {
      if(!isset($data[1])) {
        return;
      } else {
        array_shift($data);
        return $data;
      }
    }

  }
