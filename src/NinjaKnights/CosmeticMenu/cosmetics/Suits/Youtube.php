<?php

declare(strict_types=1);

namespace NinjaKnights\CosmeticMenu\cosmetics\Suits;
    
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\scheduler\Task;
use pocketmine\utils\Color;

use NinjaKnights\CosmeticMenu\Main;

class Youtube extends Task {

	private $main;

	private $armors;
	/** @var int */
	protected $step = 0;
	/** @var Color */
	protected $color;

	public function __construct(Main $main){
		$this->main = $main;

	}

	public function onRun($tick){
		foreach($this->main->getServer()->getOnlinePlayers() as $player) {
			$name = $player->getName();
			$inv = $player->getInventory();

			$players = $player->getLevel()->getPlayers();
			$level = $player->getLevel();
			$location = $player->getLocation();

			$x = $player->getX();
			$y = $player->getY();
			$z = $player->getZ();

		
			if(in_array($name, $this->main->suit1)) {
				//$level->dropItem(new Vector3($x, $y + 0.3, $z), Item::get(ITEM::GOLDEN_APPLE));
				
			}
		}
	}

	

}