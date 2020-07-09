<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class BlizzardAura extends Task {
	
	public function __construct(Main $main) {
        $this->main = $main;
        $this->r = 0;
    }
    
    public function onRun($tick) {
        foreach($this->main->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $level = $player->getLevel();
        
            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();
            if(in_array($name, $this->main->particle3)) {
                $size = 0.6;
                $a = cos(deg2rad($this->r/0.06))* $size;
                $b = sin(deg2rad($this->r/0.06))* $size;
                $level->addParticle(new GenericParticle(new Vector3($x - $a, $y + 2, $z - $b), Particle::TYPE_DUST, ((255 & 0xff) << 24) | ((250 & 0xff) << 16) | ((250 & 0xff) << 8) | (250 & 0xff)));
                $level->addParticle(new GenericParticle(new Vector3($x + $a, $y + 2, $z + $b), Particle::TYPE_DUST, ((255 & 0xff) << 24) | ((250 & 0xff) << 16) | ((250 & 0xff) << 8) | (250 & 0xff)));
                $this->r++;
            } 	
        }
    }

}