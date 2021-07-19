<?php

namespace JonyGamesYT9\SimpleBroadcast\Commands;

use JonyGamesYT9\SimpleBroadcast\SimpleBroadcast;
use pocketmine\command\Command as Base;
use pocketmine\command\CommandSender as Sender;
use pocketmine\command\PluginIdentifiableCommand;

/**
 * Class BroadcastCommand 
 * @package JonyGamesYT9\SimpleBroadcast\Commands
 */
class BroadcastCommand extends Base implements PluginIdentifiableCommand {
  
  /** @var SimpleBroadcast $plugin */
  private $plugin;

  /**
   * BroadcastCommand Constructor.
   */
  public function __construct(SimpleBroadcast $plugin)
  {
    $this->plugin = $plugin;
    parent::__construct("broadcast", "Broadcast System By: JonyGamesYT9", null, []);
  }
  
  /**
   * @param Sender $sender
   * @param string $label 
   * @param array $args 
   * @return mixed|void 
   */
  public function execute(Sender $sender, string $label, array $args)
  {
    $sender->sendMessage("§l§7SimpleBroadcast | §r§fv1.0.0");
    $sender->sendMessage("§7Author: §6JonyGamesYT9");
    $sender->sendMessage("§7Twitter: §6@JonySeGur");
    $sender->sendMessage("§7Github: §6JonyGamesYT9");
  }

  /**
    * @return SimpleBroadcast
    */
  public function getPlugin(): SimpleBroadcast
  {
    return $this->plugin;
  }
}
