<?php

namespace wockgod;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;

class KDRListener implements Listener {


    public function onPlayerDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $cause = $player->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $damager = $cause->getDamager();
            if ($damager instanceof Player) {
                $damagerName = $damager->getName();
                $entityName = $player->getName();
                $damagerKills = KDR::getInstance()->getConfig()->getNested("players.$damagerName.kills", 0);
                $entityDeaths = KDR::getInstance()->getConfig()->getNested("players.$entityName.deaths", 0);
                KDR::getInstance()->getConfig()->setNested("players.$damagerName.kills", $damagerKills + 1);
            }
        }
        $entityName = $player->getName();
        $entityDeaths = KDR::getInstance()->getConfig()->getNested("players.$entityName.deaths", 0);
        KDR::getInstance()->getConfig()->setNested("players.$entityName.deaths", $entityDeaths + 1);
        KDR::getInstance()->getConfig()->save();
    }
}
