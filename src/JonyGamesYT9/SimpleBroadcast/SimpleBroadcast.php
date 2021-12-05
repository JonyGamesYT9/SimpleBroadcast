<?php

namespace JonyGamesYT9\SimpleBroadcast;

use JonyGamesYT9\SimpleBroadcast\Commands\BroadcastCommand;
use JonyGamesYT9\SimpleBroadcast\Provider\YamlProvider;
use JonyGamesYT9\SimpleBroadcast\Scheduler\BroadcastScheduler;
use pocketmine\Server;
use pocketmine\player\Player;
use function is_numeric;

/**
* Class SimpleBroadcast
* @package JonyGamesYT9\SimpleBroadcast
*/
class SimpleBroadcast extends \pocketmine\plugin\PluginBase
{

  /** @var SimpleBroadcast $instance */
  private static SimpleBroadcast $instance;

  /**
  * @return void
  */
  public function onLoad(): void
  {
    SimpleBroadcast::$instance = $this;
    YamlProvider::init();
  }

  /**
  * @return void
  */
  public function onEnable(): void
  {
    SimpleBroadcast::getInstance()->saveResource("Config.yml");
    $version = YamlProvider::getInstance()->getConfigVersion();
    if ($version === 5) {
      Server::getInstance()->getCommandMap()->register("simplebroadcast", new BroadcastCommand());
      $interval = YamlProvider::getInstance()->getMessageInterval();
      if (!is_numeric($interval) || empty($interval)) {
        SimpleBroadcast::getInstance()->getLogger()->error("SimpleBroadcast: Message interval is not numeric or is empty, check config.yml file!");
        Server::getInstance()->getPluginManager()->disablePlugin($this);
      } else
      {
        foreach (YamlProvider::getInstance()->config->get("messages") as $messages) {
      YamlProvider::getInstance()->messages[] = $messages;
    }
        SimpleBroadcast::getInstance()->getScheduler()->scheduleRepeatingTask(new BroadcastScheduler(), $interval * 20);
      }
    } else
    {
      SimpleBroadcast::getInstance()->getLogger()->error("SimpleBroadcast: Error in config.yml please delete file and restart server!");
      Server::getInstance()->getPluginManager()->disablePlugin($this);
    }
  }

  /**
  * @return SimpleBroadcast
  */
  public static function getInstance(): SimpleBroadcast
  {
    return SimpleBroadcast::$instance;
  }
}
