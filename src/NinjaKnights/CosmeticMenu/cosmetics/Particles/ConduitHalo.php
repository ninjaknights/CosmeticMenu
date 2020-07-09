<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class ConduitHalo extends Task {
	
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
            if(in_array($name, $this->main->particle6)) {
                $size = 0.8;
				$a = cos(deg2rad($this->r / 0.04)) * $size;
				$b = sin(deg2rad($this->r / 0.04)) * $size;
				$c = cos(deg2rad($this->r / 0.04)) * 0.6;
				$d = sin(deg2rad($this->r / 0.04)) * 0.6;
				$level->addParticle(new GenericParticle(new Vector3($x - $b, $y + $c + $d + 1.2, $z - $a), Particle::TYPE_CONDUIT));
				$level->addParticle(new GenericParticle(new Vector3($x + $a, $y + $c + $d + 1.2, $z + $b), Particle::TYPE_CONDUIT));
				$level->addParticle(new GenericParticle(new Vector3($x + $b, $y + $c + $d + 1.2, $z - $a), Particle::TYPE_CONDUIT));
				$level->addParticle(new GenericParticle(new Vector3($x + $a, $y + $c + $d + 1.2, $z - $b), Particle::TYPE_CONDUIT));
				$level->addParticle(new GenericParticle(new Vector3($x + $a, $y + 2, $z + $b), Particle::TYPE_CONDUIT));
				$this->r++;
            } 	
        }
    }

}