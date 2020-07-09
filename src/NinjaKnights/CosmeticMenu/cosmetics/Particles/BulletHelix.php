<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class BulletHelix extends Task {
	
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
            if(in_array($name, $this->main->particle5)) {
                $size = 1.2;
                $a = cos(deg2rad($this->r/0.09))* $size;
                $b = sin(deg2rad($this->r/0.09))* $size;
                $c = cos(deg2rad($this->r/0.3))* $size;
                $level->addParticle(new GenericParticle(new Vector3($x - $a, $y + $c + 1.4, $z - $b), Particle::TYPE_SHULKER_BULLET));
                $level->addParticle(new GenericParticle(new Vector3($x + $a, $y + $c + 1.4, $z + $b), Particle::TYPE_SHULKER_BULLET));
                $this->r++; 
            } 
        }
    }

}