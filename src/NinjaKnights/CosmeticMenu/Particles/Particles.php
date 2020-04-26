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
use NinjaKnights\CosmeticMenu\Particles\WitchCurse;
use NinjaKnights\CosmeticMenu\Particles\Conduit;


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
				if($this->r < 0){
					$this->r++;
					return true;
				}							  						 
				
		   		$a = cos(deg2rad($this->r/0.04))* 0.5;
				$b = sin(deg2rad($this->r/0.04))* 0.5;
				$c = cos(deg2rad($this->r/0.04))* 0.8;
				$d = sin(deg2rad($this->r/0.04))* 0.8;
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
			//Flame Ring
            if(in_array($name, $this->plugin->particle2)) {
				$size = 0.8;
		   	    $a = cos(deg2rad($this->r/0.04))* $size;
				$b = sin(deg2rad($this->r/0.04))* $size;
				$c = cos(deg2rad($this->r/0.04))* 0.6;
				$d = sin(deg2rad($this->r/0.04))* 0.6;
				$level->addParticle(new FlameParticle(new Vector3($x + $a, $y + $c + $d + 1.2, $z + $b)));
				$level->addParticle(new FlameParticle(new Vector3($x - $b, $y + $c + $d + 1.2, $z - $a)));
				$this->r++; 
			}	
			//Blizzard Aura
			if(in_array($name, $this->plugin->particle3)) {
	     		$size = 0.6;
		   	    $a = cos(deg2rad($this->r/0.06))* $size;
				$b = sin(deg2rad($this->r/0.06))* $size;
				$level->addParticle(new DustParticle((new Vector3($x - $a, $y + 2, $z - $b)), 250, 250, 250));
				$level->addParticle(new DustParticle((new Vector3($x + $a, $y + 2, $z + $b)), 250, 250, 250));
				$this->r++;
		    }	
		    //CupidsLove
			if(in_array($name, $this->plugin->particle4)) {
		     	$size = 1.2;
		   		$a = cos(deg2rad($this->r/0.09))* $size;
				$b = sin(deg2rad($this->r/0.09))* $size;
				$c = sin(deg2rad($this->r/0.2))* $size;
				$level->addParticle(new HeartParticle(new Vector3($x - $a, $y + $c + 1.4, $z - $b)));
				$this->r++; 			
			}
			//Bullet Helix 
			if(in_array($name, $this->plugin->particle5)) {
	     		$size = 1.2;
		   	    $a = cos(deg2rad($this->r/0.09))* $size;
				$b = sin(deg2rad($this->r/0.09))* $size;
				$c = cos(deg2rad($this->r/0.3))* $size;
				$level->addParticle(new Bullet(new Vector3($x - $a, $y + $c + 1.4, $z - $b)));
				$level->addParticle(new Bullet(new Vector3($x + $a, $y + $c + 1.4, $z + $b)));
				$this->r++; 			
			}
			//Conduit Halo
			if(in_array($name, $this->plugin->particle6)) {
	     		$size = 0.6;
		   	    $a = cos(deg2rad($this->r/0.06))* $size;
				$b = sin(deg2rad($this->r/0.06))* $size;
				$level->addParticle(new Conduit(new Vector3($x - $a, $y + 2, $z - $b)));
				$level->addParticle(new Conduit(new Vector3($x - $a, $y + 2, $z - $b)));
				$this->r++;
			}
			//Wicth Curse
			if(in_array($name, $this->plugin->particle7)) {
				if($this->r < 0){
					$this->r++;
					return true;
				}
				$a = cos($this->r*0.1)* 2;
				$b = sin($this->r*0.1)* 2;
				$level->addParticle(new WitchCurse(new Vector3($x + $a, $y + 1, $z + $b)));
				$level->addParticle(new WitchCurse(new Vector3($x - $a, $y + 1, $z - $b)));
				$level->addParticle(new WitchCurse(new Vector3($x + $b, $y + 1, $z - $a)));
				$level->addParticle(new WitchCurse(new Vector3($x - $b, $y + 1, $z + $a)));
				$this->r++;
			}
			//Blood Helix
			if(in_array($name, $this->plugin->particle8)) {
				if($this->r < 0){
					$this->r++;
					return true;
				}
				$radio = 5;
				for($size = 2.2; $size > 0; $size-=0.4){
					$radio = $size/3;
		   			$a = $radio*cos(deg2rad($this->r/0.09))* $size;
					$b = $radio*sin(deg2rad($this->r/0.09))* $size;
					$y = 4.8-$size;
					$level->addParticle(new DustParticle((new Vector3($x + $a, $y + 2, $z + $b)),148, 37, 37));
					$this->r++; 
				}
			}
			//Emerald Twirl
			if(in_array($name, $this->plugin->particle9)) {
				if($this->r < 0){
					$this->r++;
					return true;
				}
	     		$size = 1;
		   	    $a = cos(deg2rad($this->r/0.09))* $size;
				$b = sin(deg2rad($this->r/0.09))* $size;
				$c = sin(deg2rad($this->r/0.2))* $size;
				$level->addParticle(new HappyVillagerParticle(new Vector3($x - $a, $y + $c + 1.4, $z - $b)));
				$this->r++;
			}
			//change
			if(in_array($name, $this->plugin->particle10)) {
	     		$size = 0.6;
		   	    $a = cos(deg2rad($this->r/0.06))* $size;
				$b = sin(deg2rad($this->r/0.06))* $size;
				$c = cos(deg2rad($this->r/0.3))* $size;
				$level->addParticle(new DustParticle((new Vector3($x - $a, $y + 2, $z - $b)), 250, 250, 250));
				$level->addParticle(new DustParticle((new Vector3($x + $a, $y + 2, $z + $b)), 250, 250, 250));
				$this->r++;  			
				
			}

		}
	}
}		