<?php

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class BloodHelix extends Task {

    public function __construct(Main $main) {
        $this->main = $main;
        $this->r = 0;
    }

    public function onRun($tick) {
        foreach($this->main->getServer()->getOnlinePlayers() as $player) {
            $level = $player->getLevel();
            $name = $player->getName();
            
            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();
            if(in_array($name, $this->main->particle9)) {
                if ($this->r < 0) {
                    $this->r++;
                    return;
                }
                $time = microtime(true) - \pocketmine\START_TIME;
                $seconds = floor($time % 14);
                $size = $seconds / 10;
                $a = cos(deg2rad($this->r / 0.04)) * $size;
                $b = sin(deg2rad($this->r / 0.04)) * $size;

                $t = microtime(true) - \pocketmine\START_TIME;
                $s = floor($t % 14);
                $c = $s / 5;

                $level->addParticle(new GenericParticle(new Vector3($x - $a, $y - $c + 2.8, $z - $b), Particle::TYPE_REDSTONE, ((255 & 0xff) << 24) | ((189 & 0xff) << 16) | ((3 & 0xff) << 8) | (0 & 0xff)));
                $level->addParticle(new GenericParticle(new Vector3($x + $a, $y - $c + 2.8, $z + $b), Particle::TYPE_REDSTONE, ((255 & 0xff) << 24) | ((189 & 0xff) << 16) | ((3 & 0xff) << 8) | (0 & 0xff)));
                $level->addParticle(new GenericParticle(new Vector3($x - $b, $y - $c + 2.8, $z + $a), Particle::TYPE_REDSTONE, ((255 & 0xff) << 24) | ((189 & 0xff) << 16) | ((3 & 0xff) << 8) | (0 & 0xff)));
                $level->addParticle(new GenericParticle(new Vector3($x + $b, $y - $c + 2.8, $z - $a), Particle::TYPE_REDSTONE, ((255 & 0xff) << 24) | ((189 & 0xff) << 16) | ((3 & 0xff) << 8) | (0 & 0xff)));
                $this->r++;
            }
        }   
    }
}