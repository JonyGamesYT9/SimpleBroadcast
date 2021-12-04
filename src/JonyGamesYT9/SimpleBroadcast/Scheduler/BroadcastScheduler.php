<?php

namespace JonyGamesYT9\SimpleBroadcast\Scheduler;

use JonyGamesYT9\SimpleBroadcast\Provider\YamlProvider;
use JonyGamesYT9\SimpleBroadcast\SimpleBroadcast;
use pocketmine\Server;
use pocketmine\player\Player;
use function count;
use function str_replace;
use function array_rand;

/**
* Class BroadcastScheduler
* @package JonyGamesYT9\SimpleBroadcast\Scheduler
*/
class BroadcastScheduler extends \pocketmine\scheduler\Task
{

  /**
   * @return void
  */
  public function onRun(): void
  {
    $messages = YamlProvider::getInstance()->getMessages();
    $random = $messages[array_rand($messages)];
    $title = YamlProvider::getInstance()->getPrefix();
    $online = count(Server::getInstance()->getOnlinePlayers());
    foreach (Server::getInstance()->getOnlinePlayers() as $players) {
      if ($players instanceof Player) {
        $selected_message = str_replace(["&", "{online}", "{name}"], ["§", $online, $players->getName()], $random);
        $players->sendMessage(str_replace(["&"], ["§"], $title) . " " . $selected_message);
      }
    }
  }
}
