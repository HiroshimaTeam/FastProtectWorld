<?php

namespace Zoumi\FastProtectWorld\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use Zoumi\FastProtectWorld\api\WorldManager;
use Zoumi\FastProtectWorld\Main;
use Zoumi\FastProtectWorld\utils\Form;

class WorldProtect extends Command
{

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("use.worldprotect")) {
            if (!isset($args[0])) {
                $sender->sendMessage(
                    "§7-=+ §cPage d'aide §7+=-\n" .
                    "§f>> §7create §f- §aPermet de créer une protection d'un monde ou d'un endroit.\n" .
                    "§f>> §7flags §f- §aPermet de gérer les flags d'un monde.\n" .
                    "§f>> §7setkb §f- §aPermet de définir le knockback d'un monde.\n" .
                    "§7-=+ §cPage d'aide §7+=-"
                );
            } else {
                switch (strtolower($args[0])) {
                    case "create":
                        if (!isset($args[1])) {
                            $sender->sendMessage("§cVous devez entrer le nom d'un monde existant.");
                            return;
                        }
                        if (WorldManager::worldExist($args[1])) {
                            $sender->sendMessage("§cCe monde est déjà enregistré.");
                            return;
                        }
                        if (!file_exists(Main::getInstance()->getServer()->getDataPath() . "/worlds/" . $args[1])) {
                            $sender->sendMessage("§cVous devez entrer le nom d'un monde existant.");
                            return;
                        }
                        WorldManager::createWorld($args[1]);
                        $sender->sendMessage("§aLe monde " . $args[1] . " a bien été créer. Pour modifier les flags faites /worldprotect flags [nom du monde].");
                        break;
                    case "flags":
                        if (!isset($args[1])) {
                            $sender->sendMessage("§cVous devez entrer le nom d'un monde existant.");
                            return;
                        }
                        if (!WorldManager::worldExist($args[1])) {
                            $sender->sendMessage("§cVous devez entrer le nom d'un monde existant.");
                            return;
                        }
                        if ($sender instanceof Player) {
                            Form::sendFlagsMenu($sender, $args[1]);
                        }
                        break;
                    case "setkb":
                        if (!isset($args[2])) {
                            $sender->sendMessage("§cVous devez faire /worldprotect setkb [nom du monde] [false|float|int].");
                            return;
                        }
                        if (!WorldManager::worldExist($args[1])) {
                            $sender->sendMessage("§cVous devez entrer le nom d'un monde existant.");
                            return;
                        }
                        if ($args[2] === false) {
                            WorldManager::setCustomKb($args[1], false);
                            $sender->sendMessage("§aVous avez bien retiré le custom kb du monde " . $args[1] . ".");
                            return;
                        } else {
                            if (is_numeric($args[2]) || is_float($args[2])) {
                                WorldManager::setCustomKb($args[1], $args[2]);
                                $sender->sendMessage("§aVous avez bien mis le custom kb du monde " . $args[1] . " a " . $args[2] . ".");
                                return;
                            } else {
                                $sender->sendMessage("§cVous devez entré un nombre à virgule ou un nombre.");
                                return;
                            }
                        }
                        break;
                    case "list":
                        $sender->sendMessage("§aVoici la liste des mondes protégés (" . count(WorldManager::getWorlds()) . "):\n§a" . (WorldManager::getWorlds() ? implode("§f, §a", WorldManager::getWorlds()) : "Aucun") . "§f.");
                        break;
                }
            }
        }
    }

}