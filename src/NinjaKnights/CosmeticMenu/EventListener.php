<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent; 
use pocketmine\event\player\PlayerChangeSkinEvent;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\transaction\action\DropItemAction;
use pocketmine\inventory\transaction\action\SlotChangeAction;

use NinjaKnights\CosmeticMenu\Main;

class EventListener implements Listener {

	private $main;

	public function __construct(Main $main) {
			$this->main = $main;
	}

	private function isCosmeticItem(Item $item) : bool{
		if($this->main->cosmeticItemSupport){
			if($item->getCustomName() == $this->main->cosmeticName && $item->getId() == $this->main->cosmeticItemType && $item->getLore() == $this->main->cosmeticDes){
				return true;
			}
			$in = $item->getCustomName();
			if($in == "TNT-Launcher" || $in == "Lightning Stick" || $in == "Leaper" || $in == "§l§4<< Back") {
				return true;
			}
		}
		return false;
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$player->removeAllEffects();
		if($this->main->cosmeticItemSupport){
			if($player->hasPermission("cosmetic.item")){
				$this->main->reloadConfig();
				$world = $this->main->config->get("WorldName");

				$air = Item::get(0, 0 , 1);
				$item = Item::get($this->main->cosmeticItemType);
				$item->setCustomName($this->main->cosmeticName);
				$item->setLore($this->main->cosmeticDes);
				$slot = $this->main->config->getNested("Cosmetic.Slot");
				if($this->main->getServer()->getLevelByName($world)){
					$player->getInventory()->setItem($slot+1,$air,true);
					$player->getInventory()->setItem($slot,$item,true);
				} else {
					$player->getInventory()->setItem($slot,$item,false);
				}
			} else {
				$air = Item::get(0, 0 , 1);
				$slot = $this->main->config->getNested("Cosmetic.Slot");
				$player->getInventory()->setItem($slot,$air,true);
			}
		}

		$name = $player->getName();
		$skin = $player->getSkin();
		$saveSkin = $this->main->saveSkin();
		$saveSkin->saveSkin($skin, $name);
	}

	public function onRespawn(PlayerRespawnEvent $event){
		if($this->main->cosmeticItemSupport){
			$world = $this->main->config->get("WorldName");
			$this->main->reloadConfig();

			$player = $event->getPlayer();
			$air = Item::get(0, 0 , 1);
			$item = Item::get($this->main->cosmeticItemType);
			$item->setCustomName($this->main->cosmeticName);
			$item->setLore($this->main->cosmeticDes);
			$slot = $this->main->config->getNested("Cosmetic.Slot");
			if($this->main->getServer()->getLevelByName($world)) {
				$player->getInventory()->setItem($slot+1,$air,true);
				$player->getInventory()->setItem($slot,$item,true);
			} else {
				$player->getInventory()->setItem($slot,$item,false);
			}
		}
	}

	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		if($this->main->cosmeticItemSupport){
			$item = Item::get($this->main->cosmeticItemType);
			$item->getCustomName($this->main->cosmeticName);
			$item->getLore($this->main->cosmeticDes);
			$player->getInventory()->removeItem($item);
		}
		$name = $player->getName();

		//Suits
		if(in_array($name, $this->main->suit1)) {
			unset($this->main->suit1[array_search($name, $this->main->suit1)]);
		}elseif(in_array($name, $this->main->suit2)) {
			unset($this->main->suit2[array_search($name, $this->main->suit2)]);
		}

		//Hats
		if(in_array($name, $this->main->hat1)) {
			unset($this->main->hat1[array_search($name, $this->main->hat1)]);
		}elseif(in_array($name, $this->main->hat2)) {
			unset($this->main->hat2[array_search($name, $this->main->hat2)]);
		}
		$player->removeAllEffects();
	}

	public function onChangeSkin(PlayerChangeSkinEvent $event) {
		$player = $event->getPlayer();
		$name = $player->getName();
		$skin = $player->getSkin();
		$saveSkin = $this->main->saveSkin();
		$saveSkin->saveSkin($skin, $name);
	}

	public function onInventoryTransaction(InventoryTransactionEvent $event){
		if($this->main->cosmeticItemSupport && $this->main->cosmeticForceSlot){
			$transaction = $event->getTransaction();
			foreach($transaction->getActions() as $action){
				$item = $action->getSourceItem();
				$source = $transaction->getSource();
				if($source instanceof Player && $this->isCosmeticItem($item)){
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

			$slot = $this->main->config->getNested("Cosmetic.Slot");
			$item = Item::get(0, 0 , 1);
			$inv->setItem($slot+1, $item);

			$item1 = Item::get($this->main->cosmeticItemType);
			$item1->setCustomName($this->main->cosmeticName);
			$item1->setLore($this->main->cosmeticDes);
			$player->getInventory()->setItem($slot,$item1,true);

		}

		if($this->main->cosmeticItemSupport){
			if($item->getCustomName() == $this->main->cosmeticName && $item->getId() == $this->main->cosmeticItemType && $item->getLore() == $this->main->cosmeticDes){
				if($player->hasPermission("cosmetic.item")){
					$this->main->getForms()->menuForm($player);
				}
			}
		}
	}
}