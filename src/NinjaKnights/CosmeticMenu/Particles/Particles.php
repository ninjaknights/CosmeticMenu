<?php 

namespace NinjaKnights\CosmeticMenu\Particles;

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
use pocketmine\nbt\tag\FloatTag;;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BubbleParticle;//
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DustParticle;
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

use NinjaKnights\CosmeticMenu\Particles\Bullet;


/* Will be used later on
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\BlazeShootSound;
*/

use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Particles extends PluginTask {
	
	public function __construct($plugin) {
		$this->plugin = $plugin;
		$this->r = 0;
	}

	public function onRun($tick) {
		
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
			$name = $player->getName();
			$inv = $player->getInventory();
			
			$players = $player->getLevel()->getPlayers();
			$level = $player->getLevel();
			$location = $player->getLocation();
			
			$x = $player->getX();
			$y = $player->getY();
			$z = $player->getZ();
			
		//Particles
			//Rain Cloud
			if(in_array($name, $this->plugin->particle1)) {
				$levels = $this->plugin->getServer()->getLevels();
				foreach($levels as $l){					  						 
					$x = $player->getX();
					$y = $player->getY();
					$z = $player->getZ();
					$level = $this->plugin->getServer()->getDefaultLevel();
					$size = 0.5;
					$size2 = 0.8;
		   		    $a = cos(deg2rad($this->r/0.04))* $size;
					$b = sin(deg2rad($this->r/0.04))* $size;
					$c = cos(deg2rad($this->r/0.04))* $size2;
					$d = sin(deg2rad($this->r/0.04))* $size2;
					$time = microtime(true) - \pocketmine\START_TIME;
					$seconds = floor($time % 20);
					$up = $seconds/8;
					$level->addParticle(new MobSpawnParticle(new Vector3($x - $a, $y + 3, $z - $b)));
					$level->addParticle(new MobSpawnParticle(new Vector3($x - $b, $y + 3, $z - $a)));

					$level->addParticle(new SplashParticle(new Vector3($x - $a, $y + 2.3, $z - $b)));
					$level->addParticle(new SplashParticle(new Vector3($x - $b, $y + 2.3, $z - $a)));

					$level->addParticle(new MobSpawnParticle(new Vector3($x - $c, $y + 3, $z - $d)));
					$level->addParticle(new MobSpawnParticle(new Vector3($x - $d, $y + 3, $z - $c)));

					$level->addParticle(new MobSpawnParticle(new Vector3($x, $y + 3, $z)));
					$level->addParticle(new SplashParticle(new Vector3($x, $y + 2.3, $z)));

					$this->r++; 			
				}
							
			}
			//Flaming Ring
            if(in_array($name, $this->plugin->particle2)) {
				$levels = $this->plugin->getServer()->getLevels();
				foreach($levels as $l){					  						 
					$x = $player->getX();
					$y = $player->getY();
					$z = $player->getZ();
					$level = $this->plugin->getServer()->getDefaultLevel();
		     		$hypo = 0.8;
		   		    $a = cos(deg2rad($this->r/0.09))* $hypo;
					$b = sin(deg2rad($this->r/0.09))* $hypo;
					$time = microtime(true) - \pocketmine\START_TIME;
					$seconds = floor($time % 20);
					$up = $seconds/8;
					$p1 = new Vector3($x - $a, $y + $up, $z - $b);
					$p2 = new Vector3($x - $b, $y + $up, $z - $a);
					$pl1 = new FlameParticle(($p1));
					$pl2 = new FlameParticle(($p2));
					$level->addParticle($pl1);
					$level->addParticle($pl2);
					$this->r++; 			
				}
			}	
			//SnowAura
			if(in_array($name, $this->plugin->particle3)) {
				
	            $x = $player->getX();
				$y = $player->getY();
			    $z = $player->getZ(); 
				
				$center = new Vector3($x, $y + 2, $z);
				$particle = new SnowballPoofParticle($center);
				
				for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$y = $center->y;
					
					$particle->setComponents($x, $y, $z);
					$level->addParticle($particle);
				}
		    }	
		    //CupidsLove
			if(in_array($name, $this->plugin->particle4)) {
				$levels = $this->plugin->getServer()->getLevels();
				foreach($levels as $l){					  						 
					$x = $player->getX();
					$y = $player->getY();
					$z = $player->getZ();
					$level = $this->plugin->getServer()->getDefaultLevel();
		     		$size = 1.2;
		   		    $a = cos(deg2rad($this->r/0.09))* $size;
					$b = sin(deg2rad($this->r/0.09))* $size;
					$c = tan(deg2rad($this->r/0.09))* $size;
					$time = microtime(true) - \pocketmine\START_TIME;
					$seconds = floor($time % 20);
					$up = $seconds/10;
					$level->addParticle(new HeartParticle(new Vector3($x - $a, $y + $up, $z - $b)));
					$level->addParticle(new HeartParticle(new Vector3($x - $b, $y - $up + 2, $z - $a)));
					$this->r++; 			
				}
			}
			//Bullet Helix 
			if(in_array($name, $this->plugin->particle5)) {
				$levels = $this->plugin->getServer()->getLevels();
				foreach($levels as $l){					  						 
					$x = $player->getX();
					$y = $player->getY();
					$z = $player->getZ();
					$level = $this->plugin->getServer()->getDefaultLevel();
		     		$hypo = 1.2;
		   		    $a = cos(deg2rad($this->r/0.09))* $hypo;
					$b = sin(deg2rad($this->r/0.09))* $hypo;
					$c = tan(deg2rad($this->r/0.09))* $hypo;
					$time = microtime(true) - \pocketmine\START_TIME;
					$seconds = floor($time % 20);
					$up = $seconds/8;
					$p1 = new Vector3($x - $a, $y + 0.2 + $up, $z - $b);
					$p2 = new Vector3($x - $b, $y + 2.2 - $up, $z - $a);
					$pl1 = new Bullet(($p1));
					$pl2 = new Bullet(($p2));
					$level->addParticle($pl1);
					$level->addParticle($pl2);
					$this->r++; 			
				}
			}
			//Test 2
			if(in_array($name, $this->plugin->particle6)) {
				$x = $player->getX();
				$y = $player->getY();
				$z = $player->getZ(); 

				$center = new Vector3($x, $y + 1.2, $z);
				$particle = new DustParticle(($center),255, 255, 255);
				switch($player->getDirection()){
					case 0:
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = sin($yaw) + $center->x;
							$y = cos($yaw) + $center->y;
							$z = cos($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = cos($yaw) + $center->x;
							 $y = sin($yaw) + $center->y;
							$z = -sin($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
					break;
					case 1:
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = -sin($yaw) + $center->x;
							$y = sin($yaw) + $center->y;
							$z = cos($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = cos($yaw) + $center->x;
							 $y = cos($yaw) + $center->y;
							$z = sin($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
					break;
					case 2:
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = sin($yaw) + $center->x;
							$y = cos($yaw) + $center->y;
							$z = cos($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = cos($yaw) + $center->x;
							 $y = sin($yaw) + $center->y;
							$z = -sin($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
					break;
					case 3:
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = -sin($yaw) + $center->x;
							$y = sin($yaw) + $center->y;
							$z = cos($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
						for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20){
							$x = cos($yaw) + $center->x;
							 $y = cos($yaw) + $center->y;
							$z = sin($yaw) + $center->z;
			
							$particle->setComponents($x, $y, $z);
							$level->addParticle($particle);
						}
					break;
			    }
			}
		}
	}
}		