<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Particles;

use pocketmine\scheduler\Task as PluginTask;


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

            } 	
        }
    }

}