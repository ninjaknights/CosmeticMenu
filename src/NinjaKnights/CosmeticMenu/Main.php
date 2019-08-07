<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDespawnEvent;
use pocketmine\event\entity\EntityTeleportEvent;
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
use pocketmine\entity\Item as ItemE;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\entity\object\ItemEntity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BlockForceFieldParticle;
use pocketmine\level\particle\BubbleParticle;//
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DestroyBlockParticle;//
use pocketmine\level\particle\DustParticle;//
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\HugeExplodeSeedParticle;
use pocketmine\level\particle\InkParticle;
use pocketmine\level\particle\InstantEnchantParticle;
use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\Particle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\SnowballPoofParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle\SporeParticle;
use pocketmine\level\particle\TerrainParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\WaterParticle;

/* Will be used later on
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\BlazeShootSound;
*/

use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

Class Main extends PluginBase implements Listener{
       
    /**@var Item*/
	private $item;
	/**@var int*/
	protected $damage = 0;
	
	public $skeleton = array("SkeletonMask");
	public $witherskeleton = array("WitherSkeletonMask");
	public $crepper = array("CrepperMask");
	public $zombie = array("ZombieMask");
	public $dragon = array("DragonMask");
	
	public $tparticle1 = array("FlameTrailParticles");
	public $tparticle2 = array(" ");
	public $tparticle3 = array(" ");
	public $tparticle4 = array(" ");
	public $tparticle5 = array(" ");
	public $tparticle6 = array(" ");
	public $tparticle7 = array(" "); 
	public $tparticle8 = array(" "); 
	public $tparticle9 = array(" ");
	public $particle1 = array("Rain Cloud");
	public $particle2 = array("Diamond Rain");
	public $particle3 = array("SnowAura");
	public $particle4 = array(" ");
	public $particle5 = array(" ");
	public $particle6 = array(" "); 
	public $particle7 = array(" "); 
	public $particle8 = array(" "); 
	public $particle9 = array(" "); 
	
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->EconomyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
        $this->PurePerms = $this->getServer()->getPluginManager()->getPlugin('PurePerms');
		$this->getScheduler()->scheduleRepeatingTask(new Particles($this), 5);
        $this->getLogger()->info("§aCosmeticMenu loaded!");
 @mkdir($this->getDataFolder());
        $this->config = new Config ($this->getDataFolder() . "config.yml" , Config::YAML, array("name" => "§aNinjaKnights"));
        $this->saveResource("config.yml");
    }
	public function onPickup(InventoryPickupItemEvent $event){
		$player = $event->getInventory()->getHolder();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			$event->setCancelled();
		}
	}
	public function onDrop(PlayerDropItemEvent $event){
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			$event->setCancelled();
		}
	}
	public function onHit(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if ($entity instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				$damager = $event->getDamager();
				if($damager instanceof Player) {
					if($entity->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
						$event->setCancelled();
					}
				}
			}
		} 
	}
	public function onDamage(EntityDamageEvent $event) {
		$player = $event->getEntity();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if($player instanceof Player) {
				$event->setCancelled();	
			}
		}
	}
	public function onPlace(BlockPlaceEvent $event) {
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if($player->hasPermission("cosmetic.build")) {
				if($player->getGamemode() == 2 or $player->getGamemode() == 0) {
 					$event->setCancelled();
				}
			} elseif(!$player->hasPermission("cosmetic.build")) {
 				$event->setCancelled();
			}
		}
	}
	public function onBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if($player->hasPermission("cosmetic.build")) {
				if($player->getGamemode() == 2 or $player->getGamemode() == 0) {
 					$event->setCancelled();
				}
			} elseif(!$player->hasPermission("cosmetic.build")) {
 				$event->setCancelled();
			}
		}
	}	
	public function onJoin(PlayerJoinEvent $event) {
		
		$player = $event->getPlayer();
		$name = $player->getName();
		
		$player->setFood($player->getMaxFood()); 
		
		//$player->getInventory()->setSize(9);
		
		$player->setGamemode(2);
		
		$this->getItems($player);
		
		$x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
		$y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
		$z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
		
		$player->teleport(new Vector3($x + 0.5, $y + 0.5, $z + 0.5));
		
		$armor = $player->getArmorInventory();
		$armor->clearAll();
	}
/*	public function onLevelChange(EntityTeleportEvent $event) {
		$player = $event->getEntity();
		if($player instanceof Player) {
			$inv = $player->getInventory();
			if ($this->getServer()->getDefaultLevel()->getName() == $event->getFolderName()) {
				$inv->clearAll();
				$player->removeAllEffects();
				$this->getItems($player);
			}
			elseif ($this->getServer()->getDefaultLevel()->getName() == $event->getFolderName()) {
				$inv->clearAll();
				$player->removeAllEffects();
			}
		}
	}*/
	public function onRespawn(PlayerRespawnEvent $event){

		$player = $event->getPlayer();
		$this->getItems($player);
		$player->setGamemode(2);
	}	
	public function onHunger(PlayerExhaustEvent $event) {
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			$event->setCancelled();
		}
	}	
	public function onProjectileHit(ProjectileHitEvent $event){
		if($event->getEntity()->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			$explosion = new Explosion(new Position($event->getEntity()->getX(), $event->getEntity()->getY(), $event->getEntity()->getZ(), $event->getEntity()->getLevel()), 1, null);
			$explosion->explodeB();
		}
	}	
	public function ExplosionPrimeEvent(ExplosionPrimeEvent $event){
		$event->setBlockBreaking(false);
	}
	//Items
    public function getItems(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(345, 0, 1);
		$item1->setCustomName("§l§dCosmetic§eMenu");
		$inv->setItem(4, $item1);
    }  
	//MainMenu
    public function getMenu(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(342, 0, 1);
		$item1->setCustomName("Gadgets");
		
		$item2 = Item::get(348, 0, 1);
		$item2->setCustomName("Particles");
		
		$item3 = Item::get(397, 3, 1);
		$item3->setCustomName("Masks");
		
		$item4 = Item::get(331, 0, 1);
		$item4->setCustomName("Trails");
		
		$item5 = Item::get(383, 13, 1);
		$item5->setCustomName("Pets");
		
		$item6 = Item::get(355, 0, 1);
		$item6->setCustomName("Back");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(4, $item5);
		$inv->setItem(8, $item6);
	}
	//Gadgets
	public function getGadgets(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(352, 0, 1);
		$item1->setCustomName("TNT-Launcher");
		
		$item2 = Item::get(288, 0, 1);
		$item2->setCustomName("Leaper");
		
		$item3 = Item::get(369, 0, 1);
		$item3->setCustomName("LightningStick");
		
		$item4 = Item::get(385, 0, 1);
		$item4->setCustomName("Bomb");
		
		$item5 = Item::get(355, 1, 1);
		$item5->setCustomName("BackToMenu");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(8, $item5);

	}
	//Particles
	public function getParticles(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(351, 15, 1); //RainCloud
		$item1->setCustomName("Rain Cloud");
		
		$item2 = Item::get(351, 14, 1);
		$item2->setCustomName("Diamond Rain");
		
		$item3 = Item::get(351, 13, 1);
		$item3->setCustomName("SnowAura");
		
		$item4 = Item::get(0, 0, 1);
		$item4->setCustomName("");
		
		$item5 = Item::get(355, 1, 1);
		$item5->setCustomName("BackToMenu");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(8, $item5);

	}
	//Masks
	public function getMasks(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(ITEM::SKULL,0,1);
		$item1->setCustomName("Skeleton Mask");
		
		$item2 = Item::get(ITEM::SKULL,1,1);
		$item2->setCustomName("WitherSkeleton Mask");
		
		$item3 = Item::get(ITEM::SKULL,4,1);
		$item3->setCustomName("Crepper Mask");
		
		$item4 = Item::get(ITEM::SKULL,2,1);
		$item4->setCustomName("Zombie Mask");
		
		$item5 = Item::get(ITEM::SKULL,5,1);
		$item5->setCustomName("Dragon Mask");
		
		$item6 = Item::get(355, 1, 1);
		$item6->setCustomName("BackToMenu");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(4, $item5);
		$inv->setItem(8, $item6);

	}
	//Pets
	public function getPets(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(0, 0, 1);
		$item1->setCustomName("");
		
		$item2 = Item::get(0, 0, 1);
		$item2->setCustomName("");
		
		$item3 = Item::get(0, 0, 1);
		$item3->setCustomName("");
		
		$item4 = Item::get(0, 0, 1);
		$item4->setCustomName("");
		
		$item5 = Item::get(355, 1, 1);
		$item5->setCustomName("BackToMenu");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(8, $item5);

	}
	//Trails
	public function getTrails(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		$inv->clearAll();
		
		$item1 = Item::get(377, 0, 1);
		$item1->setCustomName("Flame Trail");
		
		$item2 = Item::get(0, 0, 1);
		$item2->setCustomName("");
		
		$item3 = Item::get(0, 0, 1);
		$item3->setCustomName("");
		
		$item4 = Item::get(0, 0, 1);
		$item4->setCustomName("");
		
		$item5 = Item::get(355, 1, 1);
		$item5->setCustomName("BackToMenu");
		
		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
		$inv->setItem(2, $item3);
		$inv->setItem(3, $item4);
		$inv->setItem(8, $item5);

	}
	//OnInteract
	public function onInteract(PlayerInteractEvent $event) {
		$cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$prefix = $cfg->get("Prefix");
		$player = $event->getPlayer();
		$name = $player->getName();
		$iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
		$inv = $player->getInventory();
		$armor = $player->getArmorInventory();
		$inventory = $player->getInventory();
		$blockid = $event->getBlock()->getID();
		//$block = $event->getBlock();
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		
		if($iname == "§l§dCosmetic§eMenu") {
			$this->getMenu($player);
		}
		//Gadgets
		if($iname == "Gadgets") {
			$this->getGadgets($player);
		}
		//Particles
		if($iname == "Particles") {
			$this->getParticles($player);
		}
		//Pets
		if($iname == "Pets") {
			$this->getPets($player);
		}
		//Masks
		if($iname == "Masks") {
			$this->getMasks($player);
		}
		//Trails
		if($iname == "Trails") {
	       $this->getTrails($player);
		}
		//Back
		if($iname == "Back") {
			
			$inv = $player->getInventory();
			$inv->clearAll();
			
			$this->getItems($player);
			
		}
		//BackToMenu
		if($iname == "BackToMenu") {
			
			$inv = $player->getInventory();
			$inv->clearAll();
			
			$this->getMenu($player);
			
		}
	//Gadgets
		//TNT-Launcher
		if($iname == "TNT-Launcher"){
		    $nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x),
					new DoubleTag("", $player->y+$player->getEyeHeight()),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		    ] );
		
		
		   $f = 3.0;
		   $tntentity = Entity::createEntity("PrimedTNT", $player->getlevel(), $nbt, $player);
		   $tntentity->setMotion($tnt->getMotion()->multiply($f));
		   $tntentity->spawnToAll();
		}
		//LightningStick
		if($iname == "LightningStick"){
			$block = $event->getBlock();
			$lightningentity = new AddActorPacket();
			$lightningentity->entityRuntimeId = Entity::$entityCount++;
			$lightningentity->type = 93;
			$lightningentity->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
			$lightningentity->motion = $player->getMotion();
			$lightningentity->metadata = [];
			foreach ($player->getLevel()->getPlayers() as $players) {
				$players->dataPacket($lightningentity);
			}
		}
        //Leaper
        if($iname == "Leaper"){
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
        }
		//Bomb
		if($iname == "Bomb"){
		
		
		}
	//Particles	
		//RainCloud
		if($iname == "Rain Cloud") {
			
			if(!in_array($name, $this->particle1)) {
				
				$this->particle1[] = $name;
				$player->sendMessage($prefix . "You have enabled your Rain Cloud Particle");
				
				if(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}
				
			} else {
				
				unset($this->particle1[array_search($name, $this->particle1)]);
				$player->sendMessage($prefix . "You have disabled your Rain Cloud Particle");
				
				if(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}	
			}	
		}
	    //Diamond Rain
		if($iname == "Diamond Rain") {
			
			if(!in_array($name, $this->particle2)) {
				
				$this->particle2[] = $name;
				$player->sendMessage($prefix . "You have enabled your Diamond Rain Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}
				
			} else {
				
				unset($this->particle2[array_search($name, $this->particle2)]);
				$player->sendMessage($prefix . "You have disabled your Diamond Rain Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}	
			}
		}
	   	//SnowAura
        if($iname == "SnowAura") {	
		
	        if(!in_array($name, $this->particle3)) {
				
				$this->particle3[] = $name;
				$player->sendMessage($prefix . "You have enabled your SnowAura Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}
				
			} else {
				
				unset($this->particle3[array_search($name, $this->particle3)]);
				$player->sendMessage($prefix . "You have disabled your SnowAura Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} elseif(in_array($name, $this->particle5)) {
					unset($this->particle5[array_search($name, $this->particle5)]);
				} elseif(in_array($name, $this->particle6)) {
					unset($this->particle6[array_search($name, $this->particle6)]);
				} elseif(in_array($name, $this->particle7)) {
					unset($this->particle7[array_search($name, $this->particle7)]);
				} elseif(in_array($name, $this->particle8)) {
					unset($this->particle8[array_search($name, $this->particle8)]);
				} elseif(in_array($name, $this->particle9)) {
					unset($this->particle9[array_search($name, $this->particle9)]);
				}	
			}
		}
		//CupidsLove
		
	//Masks
	    //Skeleton
	    if($iname == "Skeleton Mask") {
			
			if(in_array($name, $this->skeleton)) {
				
				unset($this->skeleton[array_search($name, $this->skeleton)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}
				
			} else {
				
				$this->skeleton[] = $name;
				$player->sendMessage($prefix . "You have The Skeleton Mask on!");
				$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,0,1));
				$player->sendPopup("§l§aPlop!");
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}	
		}
		//WitherSkeleton
		if($iname == "WitherSkeleton Mask") {
			
			if(in_array($name, $this->witherskeleton)) {
				
				unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}
				
			} else {
				
				$this->witherskeleton[] = $name;
				$player->sendMessage($prefix . "You have The WitherSkeleton Mask on!");
				$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,1,1));
				$player->sendPopup("§l§aPlop!");
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}	
		}
		//Zombie
		if($iname == "Zombie Mask") {
			
			if(in_array($name, $this->zombie)) {
				
				unset($this->zombie[array_search($name, $this->zombie)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}
				
			} else {
				
				$this->zombie[] = $name;
				$player->sendMessage($prefix . "You have The Zombie Mask on!");
				$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,2,1));
				$player->sendPopup("§l§aPlop!");
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}	
		}
		//Crepper
		if($iname == "Crepper Mask") {
			
			if(in_array($name, $this->crepper)) {
				
				unset($this->crepper[array_search($name, $this->crepper)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}
				
			} else {
				
				$this->crepper[] = $name;
				$player->sendMessage($prefix . "You have The Crepper Mask on!");
				$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,4,1));
				$player->sendPopup("§l§aPlop!");
				
				if(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}	
		}
		//Dragon
		if($iname == "Dragon Mask") {
			
			if(in_array($name, $this->dragon)) {
				
				unset($this->dragon[array_search($name, $this->dragon)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				}
				
			} else {
				
				$this->dragon[] = $name;
				$player->sendMessage($prefix . "You have The Dragon Mask on!");
				$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,5,1));
				$player->sendPopup("§l§aPlop!");
				
				if(in_array($name, $this->crepper)) {
					unset($this->crepper[array_search($name, $this->crepper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				}				
			}	
		}
    //Trails
	    //FlameTrail
		if($iname == "Flame Trail") {
		
		if(!in_array($name, $this->tparticle1)) {
				
				$this->tparticle1[] = $name;
				$player->sendMessage($prefix . "You have enabled your Flame Trail Particle");
				
				if(in_array($name, $this->tparticle2)) {
					unset($this->tparticle2[array_search($name, $this->tparticle2)]);
				} elseif(in_array($name, $this->tparticle3)) {
					unset($this->tparticle3[array_search($name, $this->tparticle3)]);
				} elseif(in_array($name, $this->tparticle4)) {
					unset($this->tparticle4[array_search($name, $this->tparticle4)]);
				} elseif(in_array($name, $this->tparticle5)) {
					unset($this->tparticle5[array_search($name, $this->tparticle5)]);
				} elseif(in_array($name, $this->tparticle6)) {
					unset($this->tparticle6[array_search($name, $this->tparticle6)]);
				} elseif(in_array($name, $this->tparticle7)) {
					unset($this->tparticle7[array_search($name, $this->tparticle7)]);
				} elseif(in_array($name, $this->tparticle8)) {
					unset($this->tparticle8[array_search($name, $this->tparticle8)]);
				} elseif(in_array($name, $this->tparticle9)) {
					unset($this->tparticle9[array_search($name, $this->tparticle9)]);
				}
				
			} else {
				
				unset($this->tparticle1[array_search($name, $this->tparticle1)]);
				$player->sendMessage($prefix . "You have disabled your Flame Trail Particle");
				
				if(in_array($name, $this->tparticle2)) {
					unset($this->tparticle2[array_search($name, $this->tparticle2)]);
				} elseif(in_array($name, $this->tparticle3)) {
					unset($this->tparticle3[array_search($name, $this->tparticle3)]);
				} elseif(in_array($name, $this->tparticle4)) {
					unset($this->tparticle4[array_search($name, $this->tparticle4)]);
				} elseif(in_array($name, $this->tparticle5)) {
					unset($this->tparticle5[array_search($name, $this->tparticle5)]);
				} elseif(in_array($name, $this->tparticle6)) {
					unset($this->tparticle6[array_search($name, $this->tparticle6)]);
				} elseif(in_array($name, $this->tparticle7)) {
					unset($this->tparticle7[array_search($name, $this->tparticle7)]);
				} elseif(in_array($name, $this->tparticle8)) {
					unset($this->tparticle8[array_search($name, $this->tparticle8)]);
				} elseif(in_array($name, $this->tparticle9)) {
					unset($this->tparticle9[array_search($name, $this->tparticle9)]);
				}	
			}
		}
		//
	
    }	
	public function onItemSpawn(ItemSpawnEvent $event) {
        $item = $event->getEntity();
        $delay = 5;  
        $this->getScheduler()->scheduleDelayedTask(new class($item) extends PluginTask
        {
            public $itemEntity;
            
            public function __construct(ItemEntity $itemEntity)
            {
                $this->itemEntity = $itemEntity;
            }

            public function onRun(int $currentTick)
            {
                if(!$this->itemEntity->isFlaggedForDespawn()) $this->itemEntity->flagForDespawn();
            }
            
        }, 5*$delay);
    }
	
}		

class Particles extends PluginTask {
	
	public function __construct($plugin) {
		$this->plugin = $plugin;
	}

	public function onRun($tick) {
		
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
			$name = $player->getName();
			$inv = $player->getInventory();
			
			$players = $player->getLevel()->getPlayers();
			$level = $player->getLevel();
			
			$x = $player->getX();
			$y = $player->getY();
			$z = $player->getZ();
			
		//Particles
			//Rain Cloud
			if(in_array($name, $this->plugin->particle1)) {
				$x = $player->getX();
				$y = $player->getY();
				$z = $player->getZ();
				
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 0.5, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 1, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 0.5, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 1, $y + 3, $z)));

				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z + 0.5)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z + 1)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z - 0.5)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z - 1)));
				
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 0.5, $y + 3, $z + 0.5)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 0.5, $y + 3, $z - 0.5)));

				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x + 0.5, $y + 3, $z - 0.5)));	
				$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->addParticle(new MobSpawnParticle(new Vector3($x - 0.5, $y + 3, $z + 0.5)));
				
				
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, 1))); 
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.1, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.2, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.3, $y + 2.3, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.4, $y + 2.3, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.3, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.3, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.1, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.3, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.3, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.3, $z + 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.3, $z + 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.7, $y + 2.3, $z + 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z -1))); 
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.1, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.2, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.3, $y + 2.3, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.4, $y + 2.3, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.3, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.3, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.1, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.3, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.3, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.3, $z - 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.3, $z - 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.7, $y + 2.3, $z - 0.1)));

				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, 1))); 
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.1, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.2, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.3, $y + 2.1, 1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.4, $y + 2.1, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.1, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.1, $z + 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.1, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z + 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.1, $z + 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.1, $z + 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.1, $z + 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.1, $z + 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.7, $y + 2.1, $z + 0.1)));				
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z -1))); 
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.1, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.2, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.3, $y + 2.1, $z -1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.4, $y + 2.1, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.1, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.1, $z - 0.7)));
				$level->addParticle(new RainSplashParticle(new Vector3($x, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.1, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z - 0.8)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.1, $z - 0.4)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.2, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.3, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.4, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.5, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.6, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x + 0.7, $y + 2.1, $z - 0.2)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.5, $y + 2.1, $z - 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.6, $y + 2.1, $z - 0.1)));
				$level->addParticle(new RainSplashParticle(new Vector3($x - 0.7, $y + 2.1, $z - 0.1)));				
			}
			//Diamond Rain
            if(in_array($name, $this->plugin->particle2)) {
	            $x = $player->getX();
				$y = $player->getY();
				$z = $player->getZ(); 
			   
			    $level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
				$level->dropItem(new Vector3($x, $y + 2.7, $z), Item::get(ITEM::GOLDEN_APPLE)->setCustomName("GodAPPLE"));
			}	
			//SnowAura
			if(in_array($name, $this->plugin->particle3)) {
	            $x = $player->getX();
				$y = $player->getY();
			    $z = $player->getZ(); 
				
				$center = new Vector3($x, $y + 2, $z);
				$particle = new SnowballPoofParticle($center, 1);
				
				for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$y = $center->y;
					
					$particle->setComponents($x, $y, $z);
					$level->addParticle($particle);
				}
		 }	
		//Trails
		    //Flame Trail
			if(in_array($name, $this->plugin->tparticle1)) {
				
				$x = $player->getX();
				$y = $player->getY();
				$z = $player->getZ();
				
				$level->addParticle(new FlameParticle(new Vector3($x, $y + 0.5, $z)));
				$level->addParticle(new FlameParticle(new Vector3($x + 0.1, $y + 0.5, $z)));
				$level->addParticle(new FlameParticle(new Vector3($x - 0.1, $y + 0.5, $z)));
				$level->addParticle(new FlameParticle(new Vector3($x, $y + 0.5, $z + 0.1)));
				$level->addParticle(new FlameParticle(new Vector3($x, $y + 0.5, $z - 0.1)));
				$level->addParticle(new FlameParticle(new Vector3($x + 0.1, $y + 0.5, $z + 0.1)));
				$level->addParticle(new FlameParticle(new Vector3($x - 0.1, $y + 0.5, $z - 0.1)));
				$level->addParticle(new FlameParticle(new Vector3($x + 0.1, $y + 0.5, $z - 0.1)));
				$level->addParticle(new FlameParticle(new Vector3($x - 0.1, $y + 0.5, $z + 0.1)));
			}
			//
}
}	
}
