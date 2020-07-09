<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class WitchCurse extends Task {
	
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
            if(in_array($name, $this->main->particle7)) {
				if($this->r < 0){
					$this->r++;
					return true;
				}
				$a = cos($this->r*0.1)* 2;
				$b = sin($this->r*0.1)* 2;
                $level->addParticle(new GenericParticle(new Vector3($x + $a, $y + 1, $z + $b), Particle::TYPE_WITCH_SPELL));
				$level->addParticle(new GenericParticle(new Vector3($x - $a, $y + 1, $z - $b), Particle::TYPE_WITCH_SPELL));
				$level->addParticle(new GenericParticle(new Vector3($x + $b, $y + 1, $z - $a), Particle::TYPE_WITCH_SPELL));
				$level->addParticle(new GenericParticle(new Vector3($x - $b, $y + 1, $z + $a), Particle::TYPE_WITCH_SPELL));
				
				$this->r++;
            } 	
        }
    }

}