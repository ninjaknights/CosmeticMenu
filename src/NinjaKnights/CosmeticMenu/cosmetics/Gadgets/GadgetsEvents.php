<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Gadgets;

use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;

use NinjaKnights\CosmeticMenu\Main;

class GadgetsEvents implements Listener {

	private $main;

    public function __construct(Main $main) {
		  $this->main = $main;
    }

    public function ExplosionPrimeEvent(ExplosionPrimeEvent $event){
		$event->setBlockBreaking(false);
	}

	public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
		$name = $player->getName();
		$iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
		$inv = $player->getInventory();
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

		//Lightning Stick
		if($iname == "Lightning Stick") {
        	if($player->hasPermission("cosmeticmenu.gadgets.lightningstick")) {	
				if(!isset($this->main->lsCooldown[$player->getName()])){		
					$block = $event->getBlock();
					$lightning = new AddActorPacket();
					$lightning->entityRuntimeId = Entity::$entityCount++;
					$lightning->type = "minecraft:lightning_bolt";
					$lightning->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
					$lightning->motion = $player->getMotion();
					$lightning->metadata = [];
					foreach ($player->getLevel()->getPlayers() as $players) {
						$players->dataPacket($lightning);
					}
					$this->main->lsCooldown[$player->getName()] = $player->getName();
					$time = $this->main->config->getNested("Cooldown.Lightning Stick");
					$this->main->lsCooldownTime[$player->getName()] = $time;
				} else {
					$player->sendPopup("§cYou can't use the Lightning Stick for another ".$this->main->lsCooldownTime[$player->getName()]." seconds.");
				}
			} else {
				$player->sendMessage("You don't have permission to use §l§dLightning §eStick!");
			}
		}
        //Leaper
        if($iname == "Leaper") {
			if($player->hasPermission("cosmeticmenu.gadgets.leaper")) {
				if(!isset($this->main->lCooldown[$player->getName()])){
				
					$yaw = $player->yaw;
					if (0 <= $yaw and $yaw < 22.5) {
								$player->knockBack($player, 0, 0, 1, 1.5);
					} elseif (22.5 <= $yaw and $yaw < 67.5) {
								$player->knockBack($player, 0, -1, 1, 1.5);
					} elseif (67.5 <= $yaw and $yaw < 112.5) {
								$player->knockBack($player, 0, -1, 0, 1.5);
					} elseif (112.5 <= $yaw and $yaw < 157.5) {
								$player->knockBack($player, 0, -1, -1, 1.5);
					} elseif (157.5 <= $yaw and $yaw < 202.5) {
								$player->knockBack($player, 0, 0, -1, 1.5);
					} elseif (202.5 <= $yaw and $yaw < 247.5) {
								$player->knockBack($player, 0, 1, -1, 1.5);
					} elseif (247.5 <= $yaw and $yaw < 292.5) {
								$player->knockBack($player, 0, 1, 0, 1.5);
					} elseif (292.5 <= $yaw and $yaw < 337.5) {
								$player->knockBack($player, 0, 1, 1, 1.5);
					} elseif (337.5 <= $yaw and $yaw < 360.0) {
								$player->knockBack($player, 0, 0, 1, 1.5);
					}
					$player->sendPopup("§aLeap!");

					$this->main->lCooldown[$player->getName()] = $player->getName();
					$time = $this->main->config->getNested("Cooldown.Leaper");
					$this->main->lCooldownTime[$player->getName()] = $time;

				} else {
					$player->sendPopup("§cYou can't use the Leaper for another ".$this->main->lCooldownTime[$player->getName()]." seconds.");
				}
		    } else {
				$player->sendMessage("You don't have permission to use §l§2Leaper!");
			}
        }
		
	}
	
	function getMain() : Main {
        return $this->main;
    }

}
