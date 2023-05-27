<?php

namespace wockgod\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use wockgod\KDR;
use jojoe77777\FormAPI\SimpleForm;

class StatsCommand extends Command {

    public function __construct(){
        parent::__construct("stats", "View another player's K/D statistics", "/stats <player>");
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

        $form = new SimpleForm(function (Player $player, ?int $data) use ($playerName, $kdr, $kills, $deaths) {
            if ($data !== null) {
                if ($data === 0) {
                    // Add any additional actions here
                }
            }
        });

        $form->setTitle("$playerName's Statistics");
        $form->setContent("Kill/Death Ratio: $kdr\nKills: $kills\nDeaths: $deaths");

        // Add the "Confirmed" button
        $form->addButton("Confirmed");

        $sender->sendForm($form);
    }
}
