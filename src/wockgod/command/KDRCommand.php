<?php

namespace wockgod\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use wockgod\KDR;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

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

        $form = new SimpleForm(function (Player $player, ?int $data) use ($kills, $deaths) {
            if ($data !== null) {
                if ($data === 0) {
                    // Action when the "Confirmed" button is clicked
                    $player->sendMessage("Your KDR has been confirmed.");
                    // Add any additional actions here
                }
            }
        });

        $form->setTitle("KDR Statistics");
        $form->setContent("Kill/Death Ratio: $kdr\nKills: $kills\nDeaths: $deaths");

        // Add the "Confirmed" button
        $form->addButton("Confirmed");

        $sender->sendForm($form);
    }
}
