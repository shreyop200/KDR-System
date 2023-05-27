<?php

namespace wockgod\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use wockgod\KDR;

class StatsCommand extends Command {

    public function __construct(){
        parent::__construct("stats", "View another players K/D statistics", "/stats <player>");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (count($args) < 1) {
            $sender->sendMessage("§cUsage: /stats <player>");
            return;
        }
        $playerName = $args[0];
        $playerStats = KDR::getInstance()->getConfig()->getNested("players.$playerName");
        if ($playerStats === null) {
            $sender->sendMessage("§cPlayer not found.");
            return;
        }
        $kills = $playerStats["kills"];
        $deaths = $playerStats["deaths"];
        $kdr = $deaths > 0 ? round($kills / $deaths, 2) : $kills;
        $message = KDR::getInstance()->getConfig()->getNested("messages.stats", "{player}'s Statistics: KDR: {kdr} (Kills: {kills}, Deaths: {deaths}).");
        $message = str_replace("{player}", $playerName, $message);
        $message = str_replace("{kdr}", $kdr, $message);
        $message = str_replace("{kills}", $kills, $message);
        $message = str_replace("{deaths}", $deaths, $message);
        $sender->sendMessage($message);
    }
}