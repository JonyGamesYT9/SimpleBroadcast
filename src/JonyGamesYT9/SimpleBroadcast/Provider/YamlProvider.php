<?php

namespace JonyGamesYT9\SimpleBroadcast\Provider;

use JonyGamesYT9\SimpleBroadcast\SimpleBroadcast;
use pocketmine\utils\Config;

/**
* Class YamlProvider
* @package JonyGamesYT9\SimpleBroadcast\Provider
*/
class YamlProvider
{

  /** @var YamlProvider $instance */
  private static YamlProvider $instance;

  /** @var Config $config */
  public Config $config;

  /** @var array $messages */
  public array $messages = [];

  /**
  * @return void
  */
  public static function init(): void
  {
    SimpleBroadcast::getInstance()->saveResource("Config.yml");
    YamlProvider::$instance = new YamlProvider();
    YamlProvider::getInstance()->config = new Config(SimpleBroadcast::getInstance()->getDataFolder() . "Config.yml", Config::YAML);
  }

  /**
  * @return int
  */
  public function getConfigVersion(): int
  {
    return YamlProvider::getInstance()->config->get("config-version");
  }

  /**
  * @return int
  */
  public function getMessageInterval(): int
  {
    return YamlProvider::getInstance()->config->get("message_interval");
  }

  /**
  * @return string
  */
  public function getPrefix(): string
  {
    return YamlProvider::getInstance()->config->get("prefix");
  }

  /**
  * @return array
  */
  public function getMessages(): array
  {
    return YamlProvider::getInstance()->messages;
  }

  /**
  * @return YamlProvider
  */
  public static function getInstance(): YamlProvider
  {
    return YamlProvider::$instance;
  }
}
