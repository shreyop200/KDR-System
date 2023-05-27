<?php

namespace wockgod;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use wockgod\command\KDRCommand;
use wockgod\command\StatsCommand;

class KDR extends PluginBase {

    private static $instance;

    /** @var Config */
    private $config;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->registerCommands();
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new KDRListener(), $this);
        $this->config = $this->getConfig();
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            $playerName = $player->getName();
            if (!$this->config->exists("players.$playerName.kills")) {
                $this->config->setNested("players.$playerName.kills", 0);
            }
            if (!$this->config->exists("players.$playerName.deaths")) {
                $this->config->setNested("players.$playerName.deaths", 0);
            }
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function registerCommands(){
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("kdr", new KDRCommand());
        $commandMap->register("stats", new StatsCommand());
    }
}
