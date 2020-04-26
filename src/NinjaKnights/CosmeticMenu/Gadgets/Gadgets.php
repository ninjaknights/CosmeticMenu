<?php 

namespace NinjaKnights\CosmeticMenu\Gadgets;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDespawnEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
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

class Gadgets implements Listener {

	public $tntCooldown = [ ];
	public $tntCooldownTime = [ ];
	public $lsCooldownTime = [ ];
	public $lsCooldown = [ ];
	public $sbCooldown = [ ];
	public $sbCooldownTime = [ ];

	public function __construct($plugin) {
		$this->plugin = $plugin;
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
				$v0 = new Vector3($x + 1, $y + $i, $z + 1);
				$v1 = new Vector3($x - 1, $y + $i, $z - 1);
				$v2 = new Vector3($x + 1, $y + $i, $z - 1);
				$v3 = new Vector3($x - 1, $y + $i, $z + 1);
				$v4 = new Vector3($x + 1, $y + $i, $z);
				$v5 = new Vector3($x - 1, $y + $i, $z);
				$v6 = new Vector3($x, $y + $i, $z + 1);
				$v7 = new Vector3($x, $y + $i, $z - 1);
				$v8 = new Vector3($x, $y + $i, $z);
				$level->addParticle(new MobSpawnParticle($v0));
				$level->addParticle(new MobSpawnParticle($v1));
				$level->addParticle(new MobSpawnParticle($v2));
				$level->addParticle(new MobSpawnParticle($v3));
				$level->addParticle(new MobSpawnParticle($v4));
				$level->addParticle(new MobSpawnParticle($v5));
				$level->addParticle(new MobSpawnParticle($v6));
				$level->addParticle(new MobSpawnParticle($v7));
				$level->addParticle(new MobSpawnParticle($v8));
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

        if ($block->getId() === 0) {
            $player->sendPopup("§cPlease wait");
            return true;
		}
    
    }

}
