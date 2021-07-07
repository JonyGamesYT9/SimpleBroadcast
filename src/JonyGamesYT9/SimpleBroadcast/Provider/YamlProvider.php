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
  private static $instance;

  /** @var Config $config */
  private $config;

  /** @var array|string $messages */
  private $messages = [];

  /**
  * @return void
  */
  public static function init(): void
  {
    SimpleBroadcast::getInstance()->saveResource("Config.yml");
    YamlProvider::$instance = new YamlProvider();
    $this->config = new Config(SimpleBroadcast::getInstance()->getDataFolder() . "Config.yml", Config::YAML);
  }

  /**
  * @return int
  */
  public function getConfigVersion(): int
  {
    return $this->config->get("config-version");
  }

  /**
  * @return int
  */
  public function getMessageInterval(): int
  {
    return $this->config->get("message_interval");
  }

  /**
  * @return string
  */
  public function getPrefix(): string
  {
    return $this->config->get("prefix");
  }

  /**
  * @return string
  */
  public function getMessages(): array
  {
    foreach ($this->config->get("messages") as $messages) {
      $this->messages[] = $messages;
    }
    return $this->messages;
  }

  /**
  * @return YamlProvider
  */
  public static function getInstance(): YamlProvider
  {
    return YamlProvider::$instance;
  }
}
