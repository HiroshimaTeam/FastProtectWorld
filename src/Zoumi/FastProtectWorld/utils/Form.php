<?php

namespace Zoumi\FastProtectWorld\utils;

use pocketmine\Player;
use Zoumi\FastProtectWorld\api\WorldManager;
use Zoumi\FastProtectWorld\Main;

class Form {

    public static function sendFlagsMenu(Player $player, string $world){
        $ui = Main::$FormAPI->createCustomForm(function (Player $player, $data) use ($world){
            if ($data === null){
                return;
            }
            WorldManager::setPlace($world, $data[0]);
            WorldManager::setBreak($world, $data[1]);
            WorldManager::setInteract($world, $data[2]);
            WorldManager::setHunger($world, $data[3]);
            WorldManager::setDropItem($world, $data[4]);
            WorldManager::setAnti2v1($world, $data[5]);
            WorldManager::setFall($world, $data[6]);
            WorldManager::setDamageByEntity($world, $data[7]);
            WorldManager::setStopTime($world, $data[8]);
            $player->sendMessage("§aLes modifications on bien été enregistré.");
            return;
        });
        $ui->setTitle("§7-=+ §cFastProtectWorld §7+=-");
        $ui->addToggle("§f- §7Peuvent poser des blocs", WorldManager::getPlace($world));
        $ui->addToggle("§f- §7Peuvent casser des blocs", WorldManager::getBreak($world));
        $ui->addToggle("§f- §7Peuvent intéragir avec le décors", WorldManager::getInteract($world));
        $ui->addToggle("§f- §7Peuvent perdre de la bouffe", WorldManager::getHunger($world));
        $ui->addToggle("§f- §7Peuvent drop des items", WorldManager::getDropItem($world));
        $ui->addToggle("§f- §7Peuvent 2v1", WorldManager::getAnti2v1($world));
        $ui->addToggle("§f- §7Peuvent prendre des dégats de chute", WorldManager::getEntityDamage($world)["fall"]);
        $ui->addToggle("§f- §7Peuvent tapper les entités", WorldManager::getEntityDamage($world)["damageByEntity"]);
        $ui->addToggle("§f- §7Stopper le temps du monde", WorldManager::getStopTime($world));
        $ui->sendToPlayer($player);
    }
    
}