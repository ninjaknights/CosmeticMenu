<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\Server;

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
        foreach($this->main->lCooldown as $player) {     
            if($this->main->lCooldownTime[$player] <= 0) {
                unset($this->main->lCooldown[$player]);
                unset($this->main->lCooldownTime[$player]);
            } else {
                $this->main->lCooldownTime[$player]--;
            }
        }
    }

    function getMain() : Main {
        return $this->main;
    }
}