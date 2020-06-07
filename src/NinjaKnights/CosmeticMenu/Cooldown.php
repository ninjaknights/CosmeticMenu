<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\scheduler\Task;

class Cooldown extends Task {

	private $main;

    public function __construct(Main $main) {
		  $this->main = $main;
    }
  
    public function onRun($tick) {
        foreach($this->main->tntCooldown as $player) {
	    if($this->main->tntCooldownTime[$player] <= 0) {
	        unset($this->main->tntCooldown[$player]);
	        unset($this->main->tntCooldownTime[$player]);
        } else {
	        $this->main->tntCooldownTime[$player]--;
	    }
        }  
        foreach($this->main->lsCooldown as $player) {     
        if($this->main->lsCooldownTime[$player] <= 0) {
            unset($this->main->lsCooldown[$player]);
            unset($this->main->lsCooldownTime[$player]);
        } else {
            $this->main->lsCooldownTime[$player]--;
        }
        }
        foreach($this->main->sbCooldown as $player) {     
        if($this->main->sbCooldownTime[$player] <= 0) {
            unset($this->main->sbCooldown[$player]);
            unset($this->main->sbCooldownTime[$player]);
        } else {
            $this->main->sbCooldownTime[$player]--;
        }
        }
    }

    function getMain() : Main {
        return $this->main;
    }
}