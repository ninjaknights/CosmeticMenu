<?php

declare(strict_types=1);

namespace NinjaKnights\CosmeticMenuV2\cosmetics\Suits;
    
use NinjaKnights\CosmeticMenuV2\Main;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task;
use pocketmine\utils\Color;
use pocketmine\nbt\tag\CompoundTag;

class Frog extends Task {

    private $main;

	public function __construct(Main $main){
		$this->main = $main;
		
		$this->armors = [
			ItemFactory::get(Item::LEATHER_CAP),
			ItemFactory::get(Item::LEATHER_TUNIC),
			ItemFactory::get(Item::LEATHER_LEGGINGS),
			ItemFactory::get(Item::LEATHER_BOOTS)
		];

		$this->color = new Color(5, 79, 0);
	}

	public function onRun($tick){
		foreach($this->main->getServer()->getOnlinePlayers() as $player) {
			$name = $player->getName();
			
			$armors = array_map(function(Armor $armor) : Armor{
				$armor->setCustomColor($this->color);
				return $armor;
			}, $this->armors);
            if(in_array($name, $this->main->suit2)) {
				$player->getArmorInventory()->setContents($armors);
				$effect = Effect::getEffect(8);
				$player->addEffect(new EffectInstance($effect, 999, 1));

            }
		}
	}


}