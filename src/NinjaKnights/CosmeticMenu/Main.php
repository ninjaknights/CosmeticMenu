<?php

namespace NinjaKnights\CosmeticMenu;

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
use pocketmine\block\Lava;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\EnumTag;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BlockForceFieldParticle;//
use pocketmine\level\particle\BubbleParticle;//
use pocketmine\level\particle\CriticalParticle;//
use pocketmine\level\particle\DestroyBlockParticle;//
use pocketmine\level\particle\DustParticle;//
use pocketmine\level\particle\EnchantParticle;//
use pocketmine\level\particle\EnchantmentTableParticle;//
use pocketmine\level\particle\EntityFlameParticle;//
use pocketmine\level\particle\ExplodeParticle;//
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\FloatingTextParticle;//
use pocketmine\level\particle\GenericParticle;//
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\HugeExplodeSeedParticle;//
use pocketmine\level\particle\InkParticle;//
use pocketmine\level\particle\InstantEnchantParticle;
use pocketmine\level\particle\ItemBreakParticle;//-//
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\LavaParticle;//
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\Particle;//
use pocketmine\level\particle\PortalParticle;//
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\RedstoneParticle;//
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\SnowballPoofParticle;
use pocketmine\level\particle\SplashParticle;//
use pocketmine\level\particle\SporeParticle;//
use pocketmine\level\particle\TerrainParticle;//
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\WaterParticle;//

/* Will be used later on
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\BlazeShootSound;
*/

use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

use NinjaKnights\CosmeticMenu\Particles;
use NinjaKnights\CosmeticMenu\Cooldown;

class Main extends PluginBase implements Listener {
       
    /**@var Item*/
	private $item;
	/**@var int*/
	protected $damage = 0;
	
	public $inv = [];
    public $inventories;

    public $tntCooldown = [ ];
	public $tntCooldownTime = [ ];
	public $lsCooldownTime = [ ];
	public $lsCooldown = [ ];
	public $sbCooldown = [ ];
	public $sbCooldownTime = [ ];

    /**
     * @param EntityLevelChangeEvent $event
     */
	
	public $skeleton = array("SkeletonMask");
	public $witherskeleton = array("WitherSkeletonMask");
	public $creeper = array("CreeperMask");
	public $zombie = array("ZombieMask");
	public $dragon = array("DragonMask");
	
	public $trail1 = array("FlameTrail");
	public $trail2 = array("SnowTrail");
	public $trail3 = array("HeartTrail");
	public $trail4 = array("SmokeTrail ");
	public $particle1 = array("Rain Cloud");
	public $particle2 = array("Diamond Rain");
	public $particle3 = array("SnowAura");
	public $particle4 = array("CupidsLove");
	
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->EconomyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
        $this->PurePerms = $this->getServer()->getPluginManager()->getPlugin('PurePerms');
		$this->getScheduler()->scheduleRepeatingTask(new Particles($this), 5);
		$this->getScheduler()->scheduleRepeatingTask(new Cooldown($this), 20);
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
		
		$player->setGamemode(2);
		
		$this->getItems($player);
		
		$x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
		$y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
		$z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
		
		$player->teleport(new Vector3($x, $y, $z));
		
		$armor = $player->getArmorInventory();
		$armor->clearAll();
	}
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
		$item4->setCustomName("SmokeBomb");
		
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
		
		$item1 = Item::get(470, 0, 1);
		$item1->setCustomName("Rain Cloud");
		
		$item2 = Item::get(264, 0, 1);
		$item2->setCustomName("Diamond Rain");
		
		$item3 = Item::get(370, 0, 1);
		$item3->setCustomName("SnowAura");
		
		$item4 = Item::get(351, 1, 1);
		$item4->setCustomName("CupidsLove");
		
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
		$item3->setCustomName("Creeper Mask");
		
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
		
		$item1 = Item::get(351, 14, 1);
		$item1->setCustomName("Flame Trail");
		
		$item2 = Item::get(351, 7, 1);
		$item2->setCustomName("Snow Trail");
		
		$item3 = Item::get(351, 1, 1);
		$item3->setCustomName("Heart Trail");
		
		$item4 = Item::get(351, 8, 1);
		$item4->setCustomName("Smoke Trail");
		
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
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		
		if ($block->getId() === 0) {
              $player->sendPopup("§cPlease wait");
              return true;
        }
		
		if($iname == "§l§dCosmetic§eMenu") {
			$this->getMenu($player);
		}
		//Gadgets
		if($iname == "Gadgets") {
			if($player->hasPermission("cosmetic.gadgets")) {
				
				$this->getGadgets($player);
				
			} else {
				
				$player->sendMessage("You don't have permission to use Gadgets!");
				
			}
		}
		//Particles
		if($iname == "Particles") {
			if($player->hasPermission("cosmetic.particles")) {
				
				$this->getParticles($player);
				
			} else {
				
				$player->sendMessage("You don't have permission to use Particles!");
				
			}
		}
		//Pets
		if($iname == "Pets") {
			if($player->hasPermission("cosmetic.pets")) {
				
				$this->getPets($player);
				
			} else {
				
				$player->sendMessage("You don't have permission to use Pets!");
				
			}
		}
		//Masks
		if($iname == "Masks") {
			if($player->hasPermission("cosmetic.masks")) {
				
				$this->getMasks($player);
				
			} else {
				
				$player->sendMessage("You don't have permission to use Masks!");
				
			}
		}
		//Trails
		if($iname == "Trails") {
			if($player->hasPermission("cosmetic.Trails")) {
				
				$this->getTrails($player);
				
			} else {
				
				$player->sendMessage("You don't have permission to use Trails!");
				
			}
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
			if($player->hasPermission("cosmetic.gadgets.tntlauncher")) {
			if(!isset($this->tntCooldown[$player->getName()])){
               $nbt = new CompoundTag("", [
                    "Pos" => new ListTag("Pos", [
                        new DoubleTag("", $player->x),
                        new DoubleTag("", $player->y + $player->getEyeHeight()),
                        new DoubleTag("", $player->z)
                    ]),
                    "Motion" => new ListTag("Motion", [
                        new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
                        new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
                        new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
                    ]),
                    "Rotation" => new ListTag("Rotation", [
                        new FloatTag("", $player->yaw),
                        new FloatTag("", $player->pitch)
                    ]),
                ]);
                $tnt = Entity::createEntity("PrimedTNT", $player->getLevel(), $nbt, null);
                $tnt->setMotion($tnt->getMotion()->multiply(2));
                $tnt->spawnTo($player);
                $this->tntCooldown[$player->getName()] = $player->getName();
                $time = "60";
                $this->tntCooldownTime[$player->getName()] = $time;

            } else {
                $player->sendPopup("§cYou can't use the TNT-Launcher for another ".$this->tntCooldownTime[$player->getName()]." seconds.");
            }
            } else {
				
				$player->sendMessage("You don't have permission to use TNT-Launcher!");
				
			}
        }
		//LightningStick
		if($iname == "LightningStick"){
        	if($player->hasPermission("cosmetic.gadgets.lightningstick")) {
				if(!isset($this->lsCooldown[$player->getName()])) {				
				$block = $event->getBlock();
				$lightning = new AddActorPacket();
				$lightning->entityRuntimeId = Entity::$entityCount++;
				$lightning->type = 93;
				$lightning->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
				$lightning->motion = $player->getMotion();
				$lightning->metadata = [];
				foreach ($player->getLevel()->getPlayers() as $players) {
				$players->dataPacket($lightning);
				$this->lsCooldown[$player->getName()] = $player->getName();
            	$time = "60";
            	$this->lsCooldownTime[$player->getName()] = $time;
				}
				} else {
                $player->sendPopup("§cYou can't use the LightningStick for another ".$this->lsCooldownTime[$player->getName()]." seconds.");
            	}
			} else {
				$player->sendMessage("You don't have permission to use LightningStick!");
			}
		}
        //Leaper
        if($iname == "Leaper"){
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
				
				$player->sendMessage("You don't have permission to use Leaper!");
				
			}
        }
		//SmokeBomb
		if($iname == "SmokeBomb"){
			if($player->hasPermission("cosmetic.gadgets.smokebomb")) {
			if(!isset($this->sbCooldown[$player->getName()])){
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
				$snowball = Entity::createEntity("Snowball", $player->getLevel(), $nbt, $player);
				$snowball->setMotion($snowball->getMotion()->multiply($f));
				$snowball->spawnToAll();
				$this->sbCooldown[$player->getName()] = $player->getName();
                $time = "30";
                $this->sbCooldownTime[$player->getName()] = $time;

            }else{
                $player->sendPopup("§cYou can't use the SmokeBomb for another ".$this->sbCooldownTime[$player->getName()]." seconds.");
            }
            } else {
				
				$player->sendMessage("You don't have permission to use SmokeBomb!");
				
			}
	    }

	//Particles	
		//RainCloud
		if($iname == "Rain Cloud") {
			if($player->hasPermission("cosmetic.particles.raincloud")) {
				
			if(!in_array($name, $this->particle1)) {
				
				$this->particle1[] = $name;
				$player->sendMessage($prefix . "You have enabled your Rain Cloud Particle");
				
				if(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} 
				
			} 
			else {
				
				unset($this->particle1[array_search($name, $this->particle1)]);
				$player->sendMessage($prefix . "You have disabled your Rain Cloud Particle");
				
				if(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} 
			}
			} 
			else {		
				$player->sendMessage("You don't have permission to use RainCloud!");				
			}			
		}
	    //Diamond Rain
		if($iname == "Diamond Rain") {
			if($player->hasPermission("cosmetic.particles.diamondrain")) {
				
			if(!in_array($name, $this->particle2)) {
				
				$this->particle2[] = $name;
				$player->sendMessage($prefix . "You have enabled your Diamond Rain Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} 
				
			} 
			else {
				
				unset($this->particle2[array_search($name, $this->particle2)]);
				$player->sendMessage($prefix . "You have disabled your Diamond Rain Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} 
			}
			} 
			else {	
				$player->sendMessage("You don't have permission to use DiamondRain!");		
			}				
		}
	   	//SnowAura
        if($iname == "SnowAura") {	
		    if($player->hasPermission("cosmetic.particles.snowaura")) {
				
	        if(!in_array($name, $this->particle3)) {
				
				$this->particle3[] = $name;
				$player->sendMessage($prefix . "You have enabled your SnowAura Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} 
				elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				} 
				
			} 
			else {
				
				unset($this->particle3[array_search($name, $this->particle3)]);
				$player->sendMessage($prefix . "You have disabled your SnowAura Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} 
				elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle4)) {
					unset($this->particle4[array_search($name, $this->particle4)]);
				}	
			}
			} 
			else {
				$player->sendMessage("You don't have permission to use SnowAura!");			
			}							
		}
		//CupidsLove
		if($iname == "CupidsLove") {	
		    if($player->hasPermission("cosmetic.particles.cupidslove")) {
				
	        if(!in_array($name, $this->particle4)) {
				
				$this->particle4[] = $name;
				$player->sendMessage($prefix . "You have enabled your CupidsLove Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				}
				elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 
				
			} 
			else {
				
				unset($this->particle4[array_search($name, $this->particle4)]);
				$player->sendMessage($prefix . "You have disabled your CupidsLove Particle");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} 
				elseif(in_array($name, $this->particle2)) {
					unset($this->particle2[array_search($name, $this->particle2)]);
				} 
				elseif(in_array($name, $this->particle3)) {
					unset($this->particle3[array_search($name, $this->particle3)]);
				} 	
			}
			} 
			else {
				$player->sendMessage("You don't have permission to use CupidsLove!");				
			}							
		}

	//Masks
	    //Skeleton
	    if($iname == "Skeleton Mask") {
			if($player->hasPermission("cosmetic.masks.skeleton")) {
				
			if(in_array($name, $this->skeleton)) {
				
				unset($this->skeleton[array_search($name, $this->skeleton)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
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
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}
		    } else {
				
				$player->sendMessage("You don't have permission to use Skeleton Mask!");
				
			}							
		}
		//WitherSkeleton
		if($iname == "WitherSkeleton Mask") {
			if($player->hasPermission("cosmetic.masks.witherskeleton")) {
				
			if(in_array($name, $this->witherskeleton)) {
				
				unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
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
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}
		    } else {
				
				$player->sendMessage("You don't have permission to use WitherSkeleton Mask!");
				
			}							
		}
		//Zombie
		if($iname == "Zombie Mask") {
			if($player->hasPermission("cosmetic.masks.zombie")) {
				
			if(in_array($name, $this->zombie)) {
				
				unset($this->zombie[array_search($name, $this->zombie)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
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
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				} elseif(in_array($name, $this->dragon)) {
					unset($this->dragon[array_search($name, $this->dragon)]);
				}				
			}	
		    } else {
				
				$player->sendMessage("You don't have permission to use Zombie Mask!");
				
			}				
		}
		//Creeper
		if($iname == "Creeper Mask") {
			if($player->hasPermission("cosmetic.masks.creeper")) {
				
			if(in_array($name, $this->creeper)) {
				
				unset($this->creeper[array_search($name, $this->creeper)]);
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
				
				$this->creeper[] = $name;
				$player->sendMessage($prefix . "You have The Creeper Mask on!");
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
		    } else {
				
				$player->sendMessage("You don't have permission to use Creeper Mask!");
				
			}							
		}
		//Dragon
		if($iname == "Dragon Mask") {
			if($player->hasPermission("cosmetic.masks.dragon")) {
				
			if(in_array($name, $this->dragon)) {
				
				unset($this->dragon[array_search($name, $this->dragon)]);
				$player->sendMessage($prefix . "You have no Mask on");
				$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
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
				
				if(in_array($name, $this->creeper)) {
					unset($this->creeper[array_search($name, $this->creeper)]);
				} elseif(in_array($name, $this->witherskeleton)) {
					unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
				} elseif(in_array($name, $this->zombie)) {
					unset($this->zombie[array_search($name, $this->zombie)]);
				} elseif(in_array($name, $this->skeleton)) {
					unset($this->skeleton[array_search($name, $this->skeleton)]);
				}				
			}
		    } else {
				
				$player->sendMessage("You don't have permission to use Dragon Mask!");
				
			}							
		}

    //Trails
	    //FlameTrail
		if($iname == "Flame Trail") {
		    if($player->hasPermission("cosmetic.trails.flame")) {
				
	    	if(!in_array($name, $this->trail1)) {
				
				$this->trail1[] = $name;
				$player->sendMessage($prefix . "You have enabled your Flame Trail Particle");
				
				if(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				}
				
			} 
			else {
				
				unset($this->trail1[array_search($name, $this->trail1)]);
				$player->sendMessage($prefix . "You have disabled your Flame Trail Particle");
				
				if(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				}	
			}
			} 
			else {
				
				$player->sendMessage("You don't have permission to use Flame Trail!");
				
			}				
		}
		//Snow Trail
	    if($iname == "Snow Trail") {
		    if($player->hasPermission("cosmetic.trails.snow")) {
				
		    if(!in_array($name, $this->trail2)) {
				
				$this->trail2[] = $name;
				$player->sendMessage($prefix . "You have enabled your Snow Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				}
				
			} 
			else {
				
				unset($this->trail2[array_search($name, $this->trail2)]);
				$player->sendMessage($prefix . "You have disabled your Snow Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				} 	
			}
			} 
			else {
				
				$player->sendMessage("You don't have permission to use Snow Trail!");
				
			}				
		}
		//Heart Trail
		if($iname == "Heart Trail") {
		    if($player->hasPermission("cosmetic.trails.heart")) {
				
		    if(!in_array($name, $this->trail3)) {
				
				$this->trail3[] = $name;
				$player->sendMessage($prefix . "You have enabled your Heart Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				}
				elseif(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				}
				
			} 
			else {
				
				unset($this->trail3[array_search($name, $this->trail3)]);
				$player->sendMessage($prefix . "You have disabled your Heart Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				} 
				elseif(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail4)) {
					unset($this->trail4[array_search($name, $this->trail4)]);
				} 	
			}
			} 
			else {
				
				$player->sendMessage("You don't have permission to use Heart Trail!");
				
			}				
		}
		//Smoke Trail
		if($iname == "Smoke Trail") {
		    if($player->hasPermission("cosmetic.trails.heart")) {
				
		    if(!in_array($name, $this->trail4)) {
				
				$this->trail4[] = $name;
				$player->sendMessage($prefix . "You have enabled your Smoke Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				}
				elseif(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				}
				
			} 
			else {
				
				unset($this->trail4[array_search($name, $this->trail4)]);
				$player->sendMessage($prefix . "You have disabled your Smoke Trail Particle");
				
				if(in_array($name, $this->trail1)) {
					unset($this->trail1[array_search($name, $this->trail1)]);
				} 
				elseif(in_array($name, $this->trail2)) {
					unset($this->trail2[array_search($name, $this->trail2)]);
				} 
				elseif(in_array($name, $this->trail3)) {
					unset($this->trail3[array_search($name, $this->trail3)]);
				} 	
			}
			} 
			else {
				
				$player->sendMessage("You don't have permission to use Smoke Trail!");
				
			}				
		}
    }

	public function onItemSpawn(ItemSpawnEvent $event) {
        $item = $event->getEntity();
        $delay = 5;  
        $this->getScheduler()->scheduleDelayedTask(new class($item) extends PluginTask {
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

    public function onSnowballDown(EntityDespawnEvent $event) {
       if($event->getType() === 81){
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
	
}		