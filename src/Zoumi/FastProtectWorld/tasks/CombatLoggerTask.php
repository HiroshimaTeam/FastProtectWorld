<?php

namespace Zoumi\FastProtectWorld\tasks;

use pocketmine\scheduler\Task;
use Zoumi\FastProtectWorld\listeners\EntityListener;
use Zoumi\FastProtectWorld\listeners\PlayerListener;

class CombatLoggerTask extends Task {

    public function onRun(int $currentTick)
    {
        if (empty(EntityListener::$combatLogger)) return;
        foreach (EntityListener::$combatLogger as $player => $value){
            if (time() >= $value["left"]){
                unset(EntityListener::$combatLogger[$player]);
            }
        }
    }

}