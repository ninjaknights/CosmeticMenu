<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Gadgets;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDespawnEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityCombustByBlockEvent;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\utils\Terminal;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerRespawnEvent; 
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\block\Solid;
use pocketmine\entity\object\FallingBlock;
use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\entity\Snowball;
use pocketmine\entity\Egg;
use pocketmine\level\Explosion;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\utils\Config;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\entity\EffectInstance;;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\inventory\ArmorInventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\entity\object\ItemEntity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\EnumTag;

use NinjaKnights\CosmeticMenu\Cooldown;
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
        	if($player->hasPermission("cosmetic.gadgets.lightningstick")) {	
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
			if($player->hasPermission("cosmetic.gadgets.leaper")) {
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
