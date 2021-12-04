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
class BroadcastScheduler extends \pocketmine\scheduler\Task {

  /**
  */
  public function onRun()
  {
    $messages = YamlProvider::getInstance()->getMessages();
    $random = $messages[array_rand($messages)];
    $title = YamlProvider::getInstance()->getPrefix();
    $online = count(Server::getInstance()->getOnlinePlayers());
    foreach (Server::getInstance()->getOnlinePlayers() as $players) {
      if ($players instanceof Player) {
        $money = SimpleBroadcast::getInstance()->getPlayerMoney($players);
        $selected_message = str_replace(["&", "{online}", "{name}", "{money}"], ["§", $online, $players->getName(), $money], $random);
        $players->sendMessage(str_replace(["&"], ["§"], $title) . " " . $selected_message);
      }
    }
  }
}
