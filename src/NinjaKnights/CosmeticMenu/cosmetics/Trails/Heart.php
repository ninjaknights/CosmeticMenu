<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Trails;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\Particle;

use NinjaKnights\CosmeticMenu\Main;

class Heart extends Task {

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
            if(in_array($name, $this->main->trail3)) {
                $size = 0.6;
                $a = cos(deg2rad($this->r/0.06))* $size;
                $b = sin(deg2rad($this->r/0.06))* $size;
                $level->addParticle(new GenericParticle(new Vector3($x - $a, $y + 0.3, $z - $b), Particle::TYPE_HEART));
                $this->r++;
            }
        }
    }


}