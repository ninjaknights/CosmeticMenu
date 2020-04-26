<?php 

namespace NinjaKnights\CosmeticMenuV2\cosmetics\Particles;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;

use pocketmine\level\particle\FlameParticle;

use NinjaKnights\CosmeticMenuV2\Main;

class FlameRings extends PluginTask {
	
	public function __construct(Main $main) {
        $this->main = $main;
        $this->r = 0;
    }
    
    public function onRun($tick) {
        foreach($this->main->getServer()->getOnlinePlayers() as $player) {
            $level = $player->getLevel();
        
            $x = $player->getX();
            $y = $player->getY();
            $z = $player->getZ();
            $size = 0.8;
            $a = cos(deg2rad($this->r/0.04))* $size;
            $b = sin(deg2rad($this->r/0.04))* $size;
            $c = cos(deg2rad($this->r/0.04))* 0.6;
            $d = sin(deg2rad($this->r/0.04))* 0.6;
            $level->addParticle(new FlameParticle(new Vector3($x + $a, $y + $c + $d + 1.2, $z + $b)));
            $level->addParticle(new FlameParticle(new Vector3($x - $b, $y + $c + $d + 1.2, $z - $a)));
            $this->r++; 
                
        }
    }    
}