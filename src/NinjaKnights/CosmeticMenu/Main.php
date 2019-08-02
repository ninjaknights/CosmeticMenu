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
use pocketmine\entity\Item as ItemEntity;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;

use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\HeartParticle;

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
	
	public $particle1 = array("RedCircleParticles");
	public $particle2 = array("YellowCircleParticles");
	public $particle3 = array("GreenCircleParticles");
	public $particle4 = array("BlueCircleParticles");
	public $particle5 = array("OringeCircleParticles");
	public $particle6 = array("FireCircleParticles");
	public $particle7 = array("WaterCircleParticles"); 
	public $particle8 = array("DropsCircleParticles"); 
	public $particle9 = array("EnderDropsCircleParticles");
	public $particle10 = array("Rain Cloud");
	public $particle11 = array("LavaParticles");
	public $particle12 = array("FireWingParticles");
	public $particle13 = array("RedstoneWingParticles");
	public $particle14 = array("GreenWingParticles");
	public $particle15 = array("LavaWalkingParticles");
	public $particle16 = array("LavaWalkingParticles"); 
	public $particle17 = array("LavaWalkingParticles"); 
	public $particle18 = array("LavaWalkingParticles"); 
	public $particle19 = array("LavaWalkingParticles"); 
	public $particle20 = array("LavaWalkingParticles"); 
	
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->EconomyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
        $this->PurePerms = $this->getServer()->getPluginManager()->getPlugin('PurePerms');
		$this->getScheduler()->scheduleRepeatingTask(new ItemsLoad($this), 5);
		$this->getScheduler()->scheduleRepeatingTask(new SpawnParticles($this), 10);
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
			if($player->hasPermission("lobby.build")) {
				if($player->getGamemode() == 2 or $player->getGamemode() == 0) {
 					$event->setCancelled();
				}
			} elseif(!$player->hasPermission("lobby.build")) {
 				$event->setCancelled();
			}
		}
	}
	public function onBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		if($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if($player->hasPermission("lobby.build")) {
				if($player->getGamemode() == 2 or $player->getGamemode() == 0) {
 					$event->setCancelled();
				}
			} elseif(!$player->hasPermission("lobby.build")) {
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
/*	public function onLevelChange(EntityTeleportEvent $ev){
		if($ev->getEntity() instanceof Player){
			$player = $ev->getEntity();
			$name = $player->getName();
			if(!$player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
				$this->getItems($player);
			}
			if(in_array($name, $this->shownone)) {
				unset($this->shownone[array_search($name, $this->shownone)]);
			} elseif(in_array($name, $this->showvips)) {
				unset($this->showvips[array_search($name, $this->showvips)]);
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
	//Masks
	public function getMasks(Player $player) {
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
	//OnInteract
	public function onInteract(PlayerInteractEvent $event) {
		$cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$game1 = $cfg->get("Game-1-Name");
		$game2 = $cfg->get("Game-2-Name");
		$game3 = $cfg->get("Game-3-Name");
		$game4 = $cfg->get("Game-4-Name");
		$game1ip = $cfg->get("Game-1-IP");
		$game2ip = $cfg->get("Game-2-IP");
		$game3ip = $cfg->get("Game-3-IP");
		$game4ip = $cfg->get("Game-4-IP");
		$lobby1ip = $cfg->get("Lobby-1-IP");
		$lobby2ip = $cfg->get("Lobby-2-IP");
		$plobbyip = $cfg->get("PremiumLobby-IP");
		$nick = $cfg->get("DefaultNickName");
		$x1 = $cfg->get("Crate-1-X");
		$y1 = $cfg->get("Crate-1-Y");
		$z1 = $cfg->get("Crate-1-Z");
		$x2 = $cfg->get("Crate-2-X");
		$y2 = $cfg->get("Crate-2-Y");
		$z2 = $cfg->get("Crate-2-Z");
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
		   $tnt = Entity::createEntity("PrimedTNT", $player->getlevel(), $nbt, $player);
		   $tnt->setMotion($tnt->getMotion()->multiply($f));
		   $tnt->spawnToAll();
		}
		//LightningStick
		if($iname == "LightningStick"){
			$block = $event->getBlock();
			$pk = new AddActorPacket();
			$pk->entityRuntimeId = Entity::$entityCount++;
			$pk->type = 93;
			$pk->position = new Vector3($block->getX(), $block->getY(), $block->getZ());
			$pk->motion = $player->getMotion();
			$pk->metadata = [];
			foreach ($player->getLevel()->getPlayers() as $players) {
				$players->dataPacket($pk);
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
           $player->sendPopup("§aUsed Leap!");
        }
		//Bomb
		if($iname == "Bomb"){
		
		
		}
	//Particles	
		//RainCloud
		if($iname == "Rain Cloud") {
			
			if(!in_array($name, $this->particle10)) {
				
				$this->particle10[] = $name;
				$player->sendMessage($prefix . TextFormat::GREEN . "You have enabled your " . TextFormat::AQUA . "Rain " . TextFormat::GREEN . " Particles");
				
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle2)) {
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
				} elseif(in_array($name, $this->particle11)) {
					unset($this->particle11[array_search($name, $this->particle11)]);
				} elseif(in_array($name, $this->particle12)) {
					unset($this->particle12[array_search($name, $this->particle12)]);
				} elseif(in_array($name, $this->particle13)) {
					unset($this->particle13[array_search($name, $this->particle13)]);
				} elseif(in_array($name, $this->particle14)) {
					unset($this->particle14[array_search($name, $this->particle14)]);
				} elseif(in_array($name, $this->particle15)) {
					unset($this->particle15[array_search($name, $this->particle15)]);
				}
				
				
				
			} else {
				
				unset($this->particle10[array_search($name, $this->particle10)]);
				
				$player->sendMessage($prefix . TextFormat::RED . "You have disabled your " . TextFormat::AQUA . "Rain " . TextFormat::RED . " Particles");
				if(in_array($name, $this->particle1)) {
					unset($this->particle1[array_search($name, $this->particle1)]);
				} elseif(in_array($name, $this->particle2)) {
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
				} elseif(in_array($name, $this->particle11)) {
					unset($this->particle11[array_search($name, $this->particle11)]);
				} elseif(in_array($name, $this->particle12)) {
					unset($this->particle12[array_search($name, $this->particle12)]);
				} elseif(in_array($name, $this->particle13)) {
					unset($this->particle13[array_search($name, $this->particle13)]);
				} elseif(in_array($name, $this->particle14)) {
					unset($this->particle14[array_search($name, $this->particle14)]);
				} elseif(in_array($name, $this->particle15)) {
					unset($this->particle15[array_search($name, $this->particle15)]);
				}	
			}
			
		}
	}
	}
class ItemsLoad extends PluginTask {
	
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
			$y = $player->getY() + 2;
			$z = $player->getZ();
		
			//Rain Cloud
			if(in_array($name, $this->plugin->particle10)) {
				
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
		}
	}
}	
		
class SpawnParticles extends PluginTask{

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

	public function onRun($tick){
		$level = $this->plugin->getServer()->getDefaultLevel();
		$spawn = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn();
		$r = rand(1,300);
		$g = rand(1,300);
		$b = rand(1,300);
		$x = $spawn->getX();
		$y = $spawn->getY();
		$z = $spawn->getZ();
		$center = new Vector3($x + 0.5, $y + 0.5, $z + 0.5);
		$radius = 0.5;
		$count = 100;
		$particle = new DustParticle($center, $r, $g, $b, 1);
		for($yaw = 0, $y = $center->y; $y < $center->y + 4; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
			$x = -sin($yaw) + $center->x;
			$z = cos($yaw) + $center->z;
			$particle->setComponents($x, $y, $z);
			$level->addParticle($particle);
		}
	}
}		
