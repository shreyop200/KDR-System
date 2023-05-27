<?php

namespace wockgod\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use wockgod\KDR;

class KDRCommand extends Command {

    public function __construct(){
        parent::__construct("kdr", "View your K/D statistics", "/kdr");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cThis command can only be used in-game.");
            return;
        }
        $playerName = $sender->getName();
        $kills = KDR::getInstance()->getConfig()->getNested("players.$playerName.kills", 0);
        $deaths = KDR::getInstance()->getConfig()->getNested("players.$playerName.deaths", 0);
        $kdr = $deaths > 0 ? round($kills / $deaths, 2) : $kills;
        $sender->sendMessage("§aYour kill/death ratio is $kdr (Kills: $kills, Deaths: $deaths).");
    }
}
