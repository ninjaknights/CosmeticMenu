<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;

use NinjaKnights\CosmeticMenu\particleeffects\Bullet;

use NinjaKnights\CosmeticMenu\Main;

class BulletHelix extends PluginTask {
	
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
                $level->addParticle(new Bullet(new Vector3($x - $a, $y + $c + 1.4, $z - $b)));
                $level->addParticle(new Bullet(new Vector3($x + $a, $y + $c + 1.4, $z + $b)));
                $this->r++; 
            } 	
        }
    }

}