<?php

namespace CosmeticMenu;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\network\protocol\UseItemPacket;
use pocketmine\math\Vector3;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\utils\Config;
use pocketmine\level\Level;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\Particle;
use pocketmine\entity\Arrow;
use pocketmine\utils\Random;
use pocketmine\entity\Snowball;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\block\Air;
use pocketmine\network\protocol\AddItemEntityPacket;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\level\format\Chunk;

Class Main extends PluginBase implements Listener{
       //EnderPearl
/**@var Item*/
	private $item;
	/**@var int*/
	protected $damage = 0;
	
     public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aCosmeticMenu loaded!");
        }
	  public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $inv = $player->getInventory();
        $inv->clearAll();
        $item = Item::get(345, 0, 1);
        $inv->setItem(0, $item);
    }
       public function playerSpawnEvent(PlayerRespawnEvent $ev) {
       	$item = new Item(345,0,1);
       	$ev->getPlayer()->getInventory()->addItem($item);
       }
	
	 public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($player instanceof Player) {
            $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
            $item = $player->getInventory()->getItemInHand();
            $pos = new Vector3($player->getX() + 1, $player->getY() + 1, $player->getZ());
            $particle = new RedstoneParticle($pos, 5);  
            $particle2 = new HugeExplodeParticle($pos, 5);
            $particle3 = new WaterParticle($pos, 12);
            $particle4 = new AngryVillagerParticle($pos, 5);
            $level = $player->getLevel();
			if($item->getId() == Item::MAGMA_CREAM && $item->getDamage() == 0){ //ParticleBomb
            $level->addParticle($particle);
            $level->addParticle($particle2);
            $level->addParticle($particle3);
            $level->addParticle($particle4);
   }   
   //Leaper
       if( $block->getId() === 0){
           $player->sendTIP("§cPlease wait");
           return true;
   }
      
       if($item->getId() == 288){
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
//Particles
    if($item->getId() == Item::DYE) { // Dye
        switch($item->getDamage()) {
            case 4: // lapis: water
				$particle = new BubbleParticle(new Vector3($player->x, $player->y + 2, $player->z));
			    $random = new Random((int) (microtime(true) * 1000) + mt_rand());
					for($i = 0; $i < 90; ++$i){
						$particle->setComponents(
						$player->x - 2 + $random->nextSignedFloat() * $player->x + 2,
						$player->y - 0.5 + $random->nextSignedFloat() * $player->y + 1.5,
						$player->z - 2 + $random->nextSignedFloat() * $player->z + 2
						);
			      $level->addParticle($particle);
				  }
            break;
            case 14: // orange: fire
				$particle = new EntityFlameParticle(new Vector3($player->x, $player->y + 2, $player->z));
			    $random = new Random((int) (microtime(true) * 1000) + mt_rand());
					for($i = 0; $i <90; ++$i){
						$particle->setComponents(
						$player->x - 2 + $random->nextSignedFloat() * $player->x+ 2,
						$player->y - 0.5 + $random->nextSignedFloat() * $player->y + 1.5,
						$player->z - 2 + $random->nextSignedFloat() * $player->z + 2
						);
			      $level->addParticle($particle);
				  }
            break;
            case 1: // red: heart
				$particle = new HeartParticle(new Vector3($player->x, $player->y + 2, $player->z));
			    $random = new Random((int) (microtime(true) * 1000) + mt_rand());
					for($i = 0; $i < 90; ++$i){
						$particle->setComponents(
						$player->x - 2 + $random->nextSignedFloat() * $player->x + 2,
						$player->y - 0.5 + $random->nextSignedFloat() * $player->y + 1.5,
						$player->z - 2 + $random->nextSignedFloat() * $player->z + 2
						);
			      $level->addParticle($particle);
				  }
            break;
            case 15: // white: smoke
				$particle = new HugeExplodeParticle(new Vector3($player->x, $player->y + 2, $player->z), 2);
			    $random = new Random((int) (microtime(true) * 1000) + mt_rand());
					for($i = 0; $i < 90; ++$i){
						$particle->setComponents(
						$player->x - 2 + $random->nextSignedFloat() * $player->x + 2,
						$player->y - 0.5 + $random->nextSignedFloat() * $player->y + 1.5,
						$player->z - 2 + $random->nextSignedFloat() * $player->z + 2
						);
			      $level->addParticle($particle);
				  }
            break;
        }
    }
    //TNTLauncher
    if($item->getId() == Item::BONE){
						foreach($player->getInventory()->getContents() as $item){
						$nbt = new CompoundTag ( "", [ 
				"Pos" => new ListTag ( "Pos", [ 
						new DoubleTag ( "", $player->x ),
						new DoubleTag ( "", $player->y + $player->getEyeHeight () ),
						new DoubleTag ( "", $player->z ) 
				] ),
				"Motion" => new ListTag ( "Motion", [ 
						new DoubleTag ( "", - \sin ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI ) ),
						new DoubleTag ( "", - \sin ( $player->pitch / 180 * M_PI ) ),
						new DoubleTag ( "",\cos ( $player->yaw / 180 * M_PI ) *\cos ( $player->pitch / 180 * M_PI ) ) 
				] ),
				"Rotation" => new ListTag ( "Rotation", [ 
						new FloatTag ( "", $player->yaw ),
						new FloatTag ( "", $player->pitch ) 
				] ) 
		] );
		
		
		$f = 3.0;
		$snowball = Entity::createEntity ( "PrimedTNT", $player->getLevel(), $nbt, $player );
		$snowball->setMotion ( $snowball->getMotion ()->multiply ( $f ) );
		$snowball->spawnToAll ();
		}
     }
//Items
   if($item->getId() == Item::COMPASS && $item->getDamage() == 0){
      $player->getInventory()->removeItem(Item::get(ITEM::COMPASS));
      $player->getInventory()->addItem(Item::get(ITEM::MINECART));
      $player->getInventory()->addItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->addItem(Item::get(ITEM::SKULL,3,1));
	  $player->getInventory()->addItem(Item::get(ITEM::REDSTONE));
}
//BackToCompass
   if($item->getId() == Item::REDSTONE && $item->getDamage() == 0){
	  $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
      $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,3,1));
      $player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
	  $player->getInventory()->addItem(Item::get(ITEM::COMPASS));
   }
//Gadgets
   if($item->getid() == Item::MINECART && $item->getDamage() == 0){
      $player->getInventory()->removeItem(Item::get(ITEM::COMPASS));
      $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
      $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,3,1));
	  $player->getInventory()->removeItem(Item::get(ITEM::REDSTONE)); 
      $player->getInventory()->addItem(Item::get(ITEM::BONE));
      $player->getInventory()->addItem(Item::get(ITEM::BLAZE_ROD));
      $player->getInventory()->addItem(Item::get(ITEM::MAGMA_CREAM));
      $player->getInventory()->addItem(Item::get(ITEM::FEATHER));          
	  $player->getInventory()->addItem(Item::get(ITEM::BED)); 
}
//Masks
   if($item->getid() == Item::SKULL && $item->getDamage() == 3){
      $player->getInventory()->removeItem(Item::get(ITEM::COMPASS));
      $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
      $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,3,1));
      $player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
      $player->getInventory()->addItem(Item::get(ITEM::SKULL));
      $player->getInventory()->addItem(Item::get(ITEM::SKULL,1,1));
      $player->getInventory()->addItem(Item::get(ITEM::SKULL,2,1));     
      $player->getInventory()->addItem(Item::get(ITEM::SKULL,4,1));     
      $player->getInventory()->addItem(Item::get(ITEM::SKULL,5,1));  
	  $player->getInventory()->addItem(Item::get(ITEM::SPIDER_EYE));
      $player->getInventory()->addItem(Item::get(ITEM::BED)); 
}
    //Skeleton
     if($item->getId() == Item::SKULL && $item->getDamage() == 0){
        $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,0,1)); 
        $player->sendPopup("§l§aPlop!");  
     } 
	//Wither Skeleton
	 if($item->getId() == Item::SKULL && $item->getDamage() == 1){
		$player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,1,1));     
		$player->sendPopup("§l§aPlop!");  
	}
	//Zombie
	 if($item->getId() == Item::SKULL && $item->getDamage() == 2){
        $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,2,1));     
        $player->sendPopup("§l§aPlop!");  
	}
	//Creeper
	 if($item->getId() == Item::SKULL && $item->getDamage() == 4){
        $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,4,1));     
        $player->sendPopup("§l§aPlop!");  
	}
	//Dragon
	 if($item->getId() == Item::SKULL && $item->getDamage() == 5){
        $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,5,1));     
        $player->sendPopup("§l§aPlop!");  
	}
	//Remove Masks
	 if($item->getId() == Item::SPIDER_EYE){
		$player->getArmorInventory()->setHelmet(Item::get(ITEM::AIR));     
        $player->sendPopup("§l§aRemoved!");  
	}
//Particle
   if($item->getid() == Item::GLOWSTONE_DUST && $item->getDamage() == 0){
      $player->getInventory()->removeItem(Item::get(ITEM::COMPASS));
      $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
      $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,3,1));
	  $player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
      $player->getInventory()->addItem(Item::get(ITEM::DYE,4,1));
      $player->getInventory()->addItem(Item::get(ITEM::DYE,14,1));
      $player->getInventory()->addItem(Item::get(ITEM::DYE,1,1));
      $player->getInventory()->addItem(Item::get(ITEM::DYE,15,1));
	  $player->getInventory()->addItem(Item::get(ITEM::BED));
    } 
//BackToMainMenu
   if($item->getId() == Item::BED && $item->getDamage() == 0){
      $player->getInventory()->removeItem(Item::get(ITEM::BED));
      $player->getInventory()->removeItem(Item::get(ITEM::MAGMA_CREAM));
      $player->getInventory()->removeItem(Item::get(ITEM::FEATHER));
      $player->getInventory()->removeItem(Item::get(ITEM::BLAZE_ROD));
      $player->getInventory()->removeItem(Item::get(ITEM::DYE,15,1));
      $player->getInventory()->removeItem(Item::get(ITEM::DYE,4,1));
      $player->getInventory()->removeItem(Item::get(ITEM::DYE,1,1));
      $player->getInventory()->removeItem(Item::get(ITEM::DYE,14,1));
      $player->getInventory()->removeItem(Item::get(ITEM::BONE));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,0,1));
	  $player->getInventory()->removeItem(Item::get(ITEM::SKULL,1,1));
      $player->getInventory()->removeItem(Item::get(ITEM::SKULL,2,1));     
      $player->getInventory()->removeItem(Item::get(ITEM::SKULL,4,1));     
      $player->getInventory()->removeItem(Item::get(ITEM::SKULL,5,1));  
	  $player->getInventory()->removeItem(Item::get(ITEM::SPIDER_EYE));
      $player->getInventory()->addItem(Item::get(ITEM::MINECART));
      $player->getInventory()->addItem(Item::get(ITEM::GLOWSTONE_DUST));
	  $player->getInventory()->addItem(Item::get(ITEM::SKULL,3,1));
	  $player->getInventory()->addItem(Item::get(ITEM::REDSTONE));
	}
	   }
	   }

	public function onPlayerItemHeldEvent(PlayerItemHeldEvent $e){
		$i = $e->getItem();
		$p = $e->getPlayer();
//ItemNames
     if($i->getId() == Item::COMPASS){
        $p->sendPopup("§l§dCosmetic§eMenu");
     }
//Gadgets
     if($i->getId() == Item::MINECART){
        $p->sendPopup("§l§6Gadgets");
     }
      //BunnyHop
      if($i->getId() == Item::FEATHER){
         $p->sendPopup("§l§bBunnyHop");
      }
      //ParticleBomb
      if($i->getId() == Item::MAGMA_CREAM){
         $p->sendPopup("§l§dParticle§eBomb");
      }
      //LightningStick
      if($i->getId() == Item::BLAZE_ROD){
         $p->sendPopup("§l§6Lighting§aStick");
      } 
      //TNTLauncher
      if($i->getId() == Item::BONE){     
         $p->sendPopup("§l§cTNT§aLauncher");  
      }
//Partical
     if($i->getId() == Item::GLOWSTONE_DUST){
        $p->sendPopup("§l§bParticals");
     }
      //Water
      if($i->getId() == Item::DYE && $i->getDamage() == 4){
         $p->sendPopup("§l§6Water");
      }
      //Fire
      if($i->getId() == Item::DYE && $i->getDamage() == 14){
         $p->sendPopup("§l§6Fire");
      }
      //Hearts
      if($i->getId() == Item::DYE && $i->getDamage() == 1){
         $p->sendPopup("§l§6Hearts");
      }
      //Smoke
      if($i->getId() == Item::DYE && $i->getDamage() == 15){
         $p->sendPopup("§l§6Smoke");
      }
//Masks
	 if($i->getid() == Item::SKULL && $i->getDamage() == 3){
		$p->sendPopup("§l§2Masks");
	 }
	  //Skeleton
	  if($i->getid() == Item::SKULL && $i->getDamage() == 0){
		 $p->sendPopup("§l§2Skeleton Mask");
	  }
	  //Wither Skeleton
	  if($i->getid() == Item::SKULL && $i->getDamage() == 1){
		 $p->sendPopup("§l§2WitherSkeleton Mask");
	  }
	  //Zombie
	  if($i->getid() == Item::SKULL && $i->getDamage() == 2){
		 $p->sendPopup("§l§2Zombie Mask");
	  }
	  //Creeper
	  if($i->getid() == Item::SKULL && $i->getDamage() == 4){
		 $p->sendPopup("§l§2Creeper Mask");
	  }
	  //Dragon
	  if($i->getid() == Item::SKULL && $i->getDamage() == 5){
		 $p->sendPopup("§l§2Dragon Mask");
	  }
	  //Spider_eye
	  if($i->getid() == Item::SPIDER_EYE){
		 $p->sendPopup("§l§2Remove Masks");
	  }
     //Back
     if($i->getId() == Item::BED){     
        $p->sendPopup("§l§7Back...");  
     } 
	 //Back to compass
	 if($i->getId() == Item::REDSTONE){
	    $p->sendPopup("§l§7Back...");
	 }
	}
/**
* LightingStick
* Particals
*/
public function ExplosionPrimeEvent(ExplosionPrimeEvent $p){
          
          $p->setBlockBreaking(false);
          
      }
}