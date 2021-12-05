<?php

namespace JonyGamesYT9\SimpleBroadcast\Commands;

use JonyGamesYT9\SimpleBroadcast\Provider\YamlProvider;
use JonyGamesYT9\SimpleBroadcast\SimpleBroadcast;
use pocketmine\command\Command as Base;
use pocketmine\command\CommandSender as Sender;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\Plugin;
use function str_replace;
use function str_repeat;

/**
* Class BroadcastCommand
* @package JonyGamesYT9\SimpleBroadcast\Commands
*/
class BroadcastCommand extends Base implements PluginOwned
{
 
 /** @var SimpleBroadcast $plugin */ 
  private SimpleBroadcast $plugin;

  /**
  * BroadcastCommand Constructor.
  * @param SimpleBroadcast $plugin
  */
  public function __construct(SimpleBroadcast $plugin) {
    $this->plugin = $plugin;
    parent::__construct("broadcast", "Broadcast System By: JonyGamesYT9", null, []);
  }

  /**
  * @param Sender $sender
  * @param string $label
  * @param array $args
  * @return mixed|void
  */
  public function execute(Sender $sender, string $label, array $args) {
    if (empty($args[0])) {
      $sender->sendMessage("§l§7SimpleBroadcast | §r§fFor more help use /broadcast help");
      return;
    }
    switch ($args[0]) {
      case "help":
        if ($sender->hasPermission("broadcast.command.help")) {
          $sender->sendMessage("§l§7" . str_repeat("=", 15));
          $sender->sendMessage("§6/broadcast help: §7All Commands");
          $sender->sendMessage("§6/broadcast author: §7Author of plugin");
          $sender->sendMessage("§6/broadcast send <text>: §7Send message to all users");
          $sender->sendMessage("§l§7" . str_repeat("=", 15));
        } else {
          $sender->sendMessage("§l§7" . str_repeat("=", 15));
          $sender->sendMessage("§6/broadcast help: §7All Commands");
          $sender->sendMessage("§6/broadcast author: §7Author of plugin");
          $sender->sendMessage("§l§7" . str_repeat("=", 15));
        }
        break;
      case "author":
        $sender->sendMessage("§l§7SimpleBroadcast | §r§fv5.0.0");
        $sender->sendMessage("§7Author: §6JonyGamesYT9");
        $sender->sendMessage("§7Twitter: §6@JonySeGur");
        $sender->sendMessage("§7Github: §6JonyGamesYT9");
        break;
      case "send":
        if ($sender->hasPermission("broadcast.command.send")) {
          if (empty($args[1])) {
            $sender->sendMessage("§l§7SimpleBroadcast | §r§fYou must enter a text.");
            return;
          }
          foreach ($this->getPlugin()->getServer()->getOnlinePlayers() as $players) {
            unset($args[0]);
            $title = YamlProvider::getInstance()->getPrefix();
            $message = str_replace(["&"], ["§"], implode(" ", $args));
            $players->sendMessage(str_replace(["&"], ["§"], $title) . "§r " . $message);
          }
        }
        break;
      default:
        $sender->sendMessage("§l§7SimpleBroadcast | §r§fFor more help use /broadcast help");
        break;
    }
  }
  
  /**
   * @return SimpleBroadcast
   */
  public function getPlugin(): SimpleBroadcast
  {
    return $this->plugin;
  }

  /**
  * @return Plugin
  */
  public function getOwningPlugin(): Plugin
  {
    return SimpleBroadcast::getInstance();
  }
}