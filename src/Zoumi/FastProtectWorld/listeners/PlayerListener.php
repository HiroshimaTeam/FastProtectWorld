<?php

namespace Zoumi\FastProtectWorld\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use Zoumi\FastProtectWorld\api\WorldManager;

class PlayerListener implements Listener {

    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $world = $player->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (!WorldManager::getInteract($world)){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
        }
    }

    public function onHunger(PlayerExhaustEvent $event){
        $player = $event->getPlayer();
        $world = $player->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (!WorldManager::getHunger($world)){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
        }
    }

    public function onDropItem(PlayerDropItemEvent $event){
        $player = $event->getPlayer();
        $world = $player->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (!WorldManager::getDropItem($world)){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
        }
    }

}