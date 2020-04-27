<?php

namespace NinjaKnights\CosmeticMenuV2;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\transaction\action\{SlotChangeAction,DropItemAction};

use jojoe77777\FormAPI\FormAPI;

use NinjaKnights\CosmeticMenuV2\forms\MainForm;
use NinjaKnights\CosmeticMenuV2\Main;

class EventListener implements Listener {

    private $main;

    public function __construct(Main $main) {
		  $this->main = $main;
    }

	private function cosmeticItem(Item $item) : bool{
        if($this->main->cosmeticSupport){
            if($item->getCustomName() == $this->main->cosmeticName && $item->getId() == $this->main->cosmeticItemType && $item->getLore() == $this->main->cosmeticDes){
                return true;
            }
        }
        return false;
	}

	public function onJoin(PlayerJoinEvent $event){
        if($this->main->cosmeticSupport){
			$world = $this->main->config->get("WorldName");
			$this->main->reloadConfig();

            $player = $event->getPlayer();
            $item = Item::get($this->main->cosmeticItemType);
            $item->setCustomName($this->main->cosmeticName);
            $item->setLore($this->main->cosmeticDes);
			$slot = $this->main->config->getNested("Cosmetic.Slot");
			if($this->main->getServer()->getLevelByName($world)) {
				$player->getInventory()->setItem($slot,$item,true);
			} else {
				$player->getInventory()->setItem($slot,$item,false);
			}
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $items = $player->getInventory()->getContents();
        foreach($items as $target){
            if($this->cosmeticItem($target)){
                $player->getInventory()->remove($target);
            }
        }
    }

    public function onInventoryTransaction(InventoryTransactionEvent $event){
        if($this->main->cosmeticSupport && $this->main->cosmeticForceSlot){
            $transaction = $event->getTransaction();
            foreach($transaction->getActions() as $action){
                $item = $action->getSourceItem();
                $source = $transaction->getSource();
                if($source instanceof Player && $this->cosmeticItem($item)){
                    if($action instanceof SlotChangeAction || $action instanceof DropItemAction){
                        $event->setCancelled();
                    }
                }
            }
        }
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
		$name = $player->getName();
		$iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
		$inv = $player->getInventory();
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        if($block->getId() === 0) {
            $player->sendPopup("§cPlease wait");
            return true;
        }

        //Back
        if($iname == "§l§4<< Back") {

            $item1 = Item::get(0, 0 , 1);
            $inv->setItem(0, $item1);
            $inv->setItem(8, $item1);

            $item2 = Item::get($this->main->cosmeticItemType);
            $item2->setCustomName($this->main->cosmeticName);
            $item2->setLore($this->main->cosmeticDes);
			$slot = $this->main->config->getNested("Cosmetic.Slot");
			$player->getInventory()->setItem($slot,$item2,true);

        }

        if($this->main->cosmeticSupport){
            if($this->cosmeticItem($item)){
                $this->getMain()->getForms()->menuForm($player);
            }
        }
    }
    
    function getMain() : Main {
        return $this->main;
    }
}