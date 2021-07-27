<?php

namespace JonyGamesYT9\SimpleBroadcast;

use JonyGamesYT9\SimpleBroadcast\Commands\BroadcastCommand;
use JonyGamesYT9\SimpleBroadcast\Provider\YamlProvider;
use JonyGamesYT9\SimpleBroadcast\Scheduler\BroadcastScheduler;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;
use function is_numeric;

/**
* Class SimpleBroadcast
* @package JonyGamesYT9\SimpleBroadcast
*/
class SimpleBroadcast extends \pocketmine\plugin\PluginBase
{

  /** @var SimpleBroadcast $instance */
  private static $instance;

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
    if (Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI") === null) {
      SimpleBroadcast::getInstance()->getLogger()->error("SimpleBroadcast: You need the EconomyAPI plugin for the plugin to work properly. But calm there will be no mistakes");
    }
    SimpleBroadcast::getInstance()->saveResource("Config.yml");
    $version = YamlProvider::getInstance()->getConfigVersion();
    if ($version === 2) {
      Server::getInstance()->getCommandMap()->register("simplebroadcast", new BroadcastCommand($this));
      $interval = YamlProvider::getInstance()->getMessageInterval();
      if (!is_numeric($interval) || empty($interval)) {
        SimpleBroadcast::getInstance()->getLogger()->error("SimpleBroadcast: Message interval is not numeric or is empty, check config.yml file!");
        Server::getInstance()->getPluginManager()->disablePlugin($this);
      } else
      {
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
  
  /**
   * @param Player $pl 
   * @return int
   */
  public function getPlayerMoney(Player $pl): int
  {
		$economyAPI = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
		if ($economyAPI instanceof EconomyAPI) {
			return $economyAPI->myMoney($pl);
		} else {
			return 0;
		}
	}
}
