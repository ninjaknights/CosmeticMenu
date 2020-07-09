<?php

declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\cosmetics\Suits;
    
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\scheduler\Task;
use pocketmine\utils\Color;

use NinjaKnights\CosmeticMenu\Main;

class Frog extends Task {

    private $main;

	public function __construct(Main $main){
		$this->main = $main;
	}

	public function onRun($tick){
		foreach($this->main->getServer()->getOnlinePlayers() as $player) {
			$name = $player->getName();
			
            if(in_array($name, $this->main->suit2)) {
				$effect = Effect::getEffect(8);
				$player->addEffect(new EffectInstance($effect, 999, 1));

            }
		}
	}


}