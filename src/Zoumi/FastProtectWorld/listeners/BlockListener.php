<?php

namespace Zoumi\FastProtectWorld\listeners;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use Zoumi\FastProtectWorld\api\WorldManager;
use Zoumi\FastProtectWorld\Main;

class BlockListener implements Listener {

    public function onPlace(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        $block = $event->getBlock();
        /**
        if (isset(Main::$pos1[$player->getName()])) {
            if (empty(Main::$pos1[$player->getName()])) {
                if (!$event->isCancelled()) $event->setCancelled(true);
                Main::$pos1[$player->getName()] = $block->asPosition();
                $player->sendMessage("§aPosition 1 effectué (" . (int)$block->asPosition()->getX() . " " . (int)$block->asPosition()->getY() . " " . $block->asPosition()->getZ() . ")");
                return;
            }
        }
        if (isset(Main::$pos2[$player->getName()])) {
            if (empty(Main::$pos2[$player->getName()])) {
                if (!$event->isCancelled()) $event->setCancelled(true);
                Main::$pos1[$player->getName()] = $block->asPosition();
                $player->sendMessage("§aPosition 2 effectué (" . (int)$block->asPosition()->getX() . " " . (int)$block->asPosition()->getY() . " " . $block->asPosition()->getZ() . ")");
                return;
            }
        }
         */
        $world = $player->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (!WorldManager::getPlace($world) && !$player->isCreative(true)){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
        }
    }

    public function onBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        $block = $event->getBlock();
        /**
        if (isset(Main::$pos1[$player->getName()])) {
            if (empty(Main::$pos1[$player->getName()])) {
                if (!$event->isCancelled()) $event->setCancelled(true);
                Main::$pos1[$player->getName()] = $block->asPosition();
                $player->sendMessage("§aPosition 1 effectué (" . (int)$block->asPosition()->getX() . " " . (int)$block->asPosition()->getY() . " " . $block->asPosition()->getZ() . ")");
                return;
            }
        }
        if (isset(Main::$pos2[$player->getName()])) {
            if (empty(Main::$pos2[$player->getName()])) {
                if (!$event->isCancelled()) $event->setCancelled(true);
                Main::$pos1[$player->getName()] = $block->asPosition();
                $player->sendMessage("§aPosition 2 effectué (" . (int)$block->asPosition()->getX() . " " . (int)$block->asPosition()->getY() . " " . $block->asPosition()->getZ() . ")");
                return;
            }
        }
         */
        $world = $player->getLevel()->getFolderName();
        if (WorldManager::worldExist($world)){
            if (!WorldManager::getBreak($world) && !$player->isCreative(true)){
                if (!$event->isCancelled()) return $event->setCancelled(true);
            }
        }
    }

}