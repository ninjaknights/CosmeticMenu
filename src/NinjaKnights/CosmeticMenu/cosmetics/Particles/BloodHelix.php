<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;

use pocketmine\level\particle\DustParticle;

use NinjaKnights\CosmeticMenu\Main;

class BloodHelix extends PluginTask {
	
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
            if(in_array($name, $this->main->particle8)) {
				if($this->r < 0){
					$this->r++;
					return true;
				}
				$radio = 5;
				for($size = 2.2; $size > 0; $size-=0.4){
					$radio = $size/3;
		   			$a = $radio*cos(deg2rad($this->r/0.09))* $size;
					$b = $radio*sin(deg2rad($this->r/0.09))* $size;
					$y = 4.8-$size;
					$level->addParticle(new DustParticle((new Vector3($x + $a, $y + 2, $z + $b)),148, 37, 37));
					$this->r++; 
				}
            } 	
        }
    }

}