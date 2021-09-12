<?php

namespace Zoumi\FastProtectWorld\api;

use pocketmine\utils\Config;
use Zoumi\FastProtectWorld\Main;

class WorldManager {

    public static function getData(): Config{
        return new Config(Main::getInstance()->getDataFolder() . "worlds.json", Config::JSON);
    }

    public static function createWorld(string $world){
        $config = self::getData();
        $config->set($world, [
            "flags" => [
                "place" => true,
                "break" => true,
                "interact" => true,
                "hunger" => true,
                "dropItem" => true,
                "entityDamage" => [
                    "fall" => true,
                    "damageByEntity" => true
                ],
                "anti2v1" => false,
                "stopTime" => false,
                "customKb" => 0.419
            ]
        ]);
        $config->save();
    }

    public static function worldExist(string $world): bool{
        return self::getData()->exists($world);
    }

    public static function getPlace(string $world): bool{
        return self::getData()->get($world)["flags"]["place"];
    }

    public static function setPlace(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["place"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getBreak(string $world): bool{
        return self::getData()->get($world)["flags"]["break"];
    }

    public static function setBreak(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["break"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getInteract(string $world): bool{
        return self::getData()->get($world)["flags"]["interact"];
    }

    public static function setInteract(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["interact"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getEntityDamage(string $world): array{
        return self::getData()->get($world)["flags"]["entityDamage"];
    }

    public static function setFall(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["entityDamage"]["fall"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function setDamageByEntity(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["entityDamage"]["damageByEntity"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getAnti2v1(string $world): bool{
        return self::getData()->get($world)["flags"]["anti2v1"];
    }

    public static function setAnti2v1(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["anti2v1"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getCustomKb(string $world): bool{
        return self::getData()->get($world)["flags"]["customKb"];
    }

    public static function setCustomKb(string $world, $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["customKb"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getHunger(string $world): bool{
        return self::getData()->get($world)["flags"]["hunger"];
    }

    public static function setHunger(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["hunger"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getDropItem(string $world): bool{
        return self::getData()->get($world)["flags"]["dropItem"];
    }

    public static function setDropItem(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["dropItem"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getStopTime(string $world): bool{
        return self::getData()->get($world)["flags"]["stopTime"];
    }

    public static function setStopTime(string $world, bool $value){
        $config = self::getData();
        $array = $config->get($world);
        $array["flags"]["stopTime"] = $value;
        $config->set($world, $array);
        $config->save();
    }

    public static function getWorlds(): array{
        $ret = [];
        foreach (self::getData()->getAll() as $world => $flags){
            $ret[] = $world;
        }
        return $ret;
    }

}