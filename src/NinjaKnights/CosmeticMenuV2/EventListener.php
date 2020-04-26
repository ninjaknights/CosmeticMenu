<?php

namespace NinjaKnights\CosmeticMenuV2;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\player\PlayerInteractEvent;

use jojoe77777\FormAPI\FormAPI;

use NinjaKnights\CosmeticMenuV2\forms\MainForm;
use NinjaKnights\CosmeticMenuV2\Main;

class EventListener implements Listener {

    private $main;

    public function __construct(Main $main) {
		$this->main = $main;
    }

    public function onJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		
		$this->getItem($player);
    }
    
    public function getItem(Player $player) {
		$inv = $player->getInventory();

		$item1 = Item::get(399, 0, 1);
		$item1->setCustomName("CosmeticMenu");
		$inv->setItem(4, $item1);
	} 

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
		$name = $player->getName();
		$iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
		$inv = $player->getInventory();
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        if ($block->getId() === 0) {
            $player->sendPopup("§cPlease wait");
            return true;
        }

        if ($iname == "CosmeticMenu") {
        	$this->getMain()->getForms()->menuForm($player);
		}
    }
    
    function getMain() : Main {
        return $this->main;
    }
}