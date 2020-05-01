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
use pocketmine\entity\Item as ItemE;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\entity\object\ItemEntity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\EnumTag;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BubbleParticle;//
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\HugeExplodeSeedParticle;
use pocketmine\level\particle\InkParticle;
use pocketmine\level\particle\InstantEnchantParticle;
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\Particle;//-//
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\SnowballPoofParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle\SporeParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\WaterParticle;

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

	public function onEggDown(EntityDespawnEvent $event) {
		if($event->getType() === 82){
		   $entity = $event->getEntity();
		   $shooter = $entity->getOwningEntity();
		   $x = $entity->getX();
		   $y = $entity->getY();
		   $z = $entity->getZ();
		   $level = $entity->getLevel();
		   for ($i = 1; $i < 4; $i++) {
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 1, $y + $i, $z + 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 1, $y + $i, $z - 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 1, $y + $i, $z - 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 1, $y + $i, $z + 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 1, $y + $i, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 1, $y + $i, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + $i, $z + 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + $i, $z - 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + $i, $z)));
			}        
		}
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
				$block = $event->getBlock();
				$lightning = new AddActorPacket();
				$lightning->entityRuntimeId = Entity::$entityCount++;
				$lightning->type = 93;
				$lightning->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
				$lightning->motion = $player->getMotion();
				$lightning->metadata = [];
				foreach ($player->getLevel()->getPlayers() as $players) {
					$players->dataPacket($lightning);
				}
			} else {
				$player->sendMessage("You don't have permission to use §l§dLightning §eStick!");
			}
		}
        //Leaper
        if($iname == "Leaper") {
			if($player->hasPermission("cosmetic.gadgets.leaper")) {
				
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
		   
		    } else {
				
				$player->sendMessage("You don't have permission to use §l§2Leaper!");
				
			}
        }
		//Smoke Bomb
		if($iname == "Smoke Bomb") {
			if($player->hasPermission("cosmetic.gadgets.smokebomb")) {
		       $nbt = new CompoundTag ("", [
					"Pos" => new ListTag ("Pos", [
					    new DoubleTag ("", $player->x),
						new DoubleTag ("", $player->y + $player->getEyeHeight()),
						new DoubleTag ("", $player->z)
					]),
					"Motion" => new ListTag ("Motion", [
						new DoubleTag ("", -\sin($player->yaw / 180 * M_PI) * \cos($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin($player->pitch / 180 * M_PI)),
						new DoubleTag ("", \cos($player->yaw / 180 * M_PI) * \cos($player->pitch / 180 * M_PI))
					]),
					"Rotation" => new ListTag ("Rotation", [
						new FloatTag ("", $player->yaw),
						new FloatTag ("", $player->pitch)
					])
				]);
				$f = 1.5;
				$egg = Entity::createEntity("Egg", $player->getLevel(), $nbt, $player);
				$egg->setMotion($egg->getMotion()->multiply($f));
				$egg->setHealth(1);
				$egg->spawnToAll();
				

            } else {
				
				$player->sendMessage("You don't have permission to use §l§fSmoke §8Bomb!");
				
			}
		}
		
	}
	
	function getMain() : Main {
        return $this->main;
    }

}
