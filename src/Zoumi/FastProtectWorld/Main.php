<?php

namespace Zoumi\FastProtectWorld;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use Zoumi\FastProtectWorld\api\WorldManager;
use Zoumi\FastProtectWorld\commands\WorldProtect;
use Zoumi\FastProtectWorld\listeners\BlockListener;
use Zoumi\FastProtectWorld\listeners\EntityListener;
use Zoumi\FastProtectWorld\listeners\PlayerListener;
use Zoumi\FastProtectWorld\tasks\CombatLoggerTask;

class Main extends PluginBase {

    public static $instance;
    public static $FormAPI = false;

    public static function getInstance(): self{
        return self::$instance;
    }

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveResource($this->getDataFolder() . "worlds.json");

        if (!Server::getInstance()->getPluginManager()->getPlugin("FormAPI")){
            $this->getLogger()->error("[FR] Le plugin FormAPI n'a pas été trouver.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }else{
            self::$FormAPI = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        }
        
        /** Chargement des mondes */
        if (!empty(WorldManager::getData())){
            foreach (WorldManager::getData() as $world => $flags){
                if (!Server::getInstance()->isLevelLoaded($world)){
                    Server::getInstance()->loadLevel($world);
                }
                if ($flags["stopTime"]){
                    Server::getInstance()->getLevelByName($world)->stopTime();
                }
            }
        }

        /** Commands */
        $this->getServer()->getCommandMap()->registerAll("FastProtectWorld", [
            new WorldProtect("worldprotect")
        ]);

        /** Listeners */
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new EntityListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockListener(), $this);

        /** Tasks */
        $this->getScheduler()->scheduleRepeatingTask(new CombatLoggerTask(), 20);
    }

}