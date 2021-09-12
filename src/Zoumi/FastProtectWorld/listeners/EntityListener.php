<?php

namespace Zoumi\FastProtectWorld\listeners;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use Zoumi\FastProtectWorld\api\WorldManager;

class EntityListener implements Listener {

    public static $combatLogger = [];

    public function onEntityDamage(EntityDamageEvent $event){
        $entity = $event->getEntity();
        $cause = $event->getCause();
        $world = $entity->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            switch ($cause){
                case EntityDamageEvent::CAUSE_FALL:
                    if (!WorldManager::getEntityDamage($world)["fall"]){
                        if (!$event->isCancelled()) return $event->setCancelled(true);
                    }
                    break;
            }
        }
    }

    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event){
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        $world = $damager->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (WorldManager::getEntityDamage($world)["damageByEntity"]){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
            if (WorldManager::getCustomKb($world) !== false) {
                $event->setKnockBack((float)WorldManager::getCustomKb($world));
            }
            if ($damager instanceof Player && $entity instanceof Player) {
                if (WorldManager::getAnti2v1($world)) {
                    if (isset(self::$combatLogger[$damager->getName()])) {
                        if (self::$combatLogger[$damager->getName()]["target"] !== $entity->getName()) {
                            if (!$event->isCancelled()) return $event->setCancelled(true);
                        }
                    }
                    if (isset(self::$combatLogger[$entity->getName()])) {
                        if (self::$combatLogger[$entity->getName()]["target"] !== $damager->getName()) {
                            if (!$event->isCancelled()) return $event->setCancelled(true);
                        }
                    }
                    self::$combatLogger[$damager->getName()] = [
                        "left" => time() + 5,
                        "target" => $entity->getName()
                    ];
                    self::$combatLogger[$entity->getName()] = [
                        "left" => time() + 5,
                        "target" => $damager->getName()
                    ];
                }
            }
        }
    }

}