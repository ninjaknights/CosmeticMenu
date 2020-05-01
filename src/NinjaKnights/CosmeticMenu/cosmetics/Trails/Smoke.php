<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Trails;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task;

use NinjaKnights\CosmeticMenu\Main;

class Smoke extends Task {

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
            if(in_array($name, $this->main->trail4)) {
                $size = 0.6;
                $a = cos(deg2rad($this->r/0.06))* $size;
                $b = sin(deg2rad($this->r/0.06))* $size;
                $level->addParticle(new SmokeParticle((new Vector3($x - $a, $y + 0.3, $z - $b)),250, 250, 250));
                $this->r++;
            }
        }
    }


}