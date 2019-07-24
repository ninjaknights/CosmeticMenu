<?php

namespace CosmeticMenu;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\UseItemPacket;
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
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle;
use pocketmine\entity\Arrow;
use pocketmine\utils\Random;
use pocketmine\entity\Snowball;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\inventory\Inventory;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\block\Air;
use pocketmine\network\mcpe\protocol\AddItemEntityPacket;
use pocketmine\event\player\PlayerRespawnEvent;
use CosmeticMenu\Particles;

class Main extends PluginBase implements Listener {
    //Particles
    public $water = array("WaterParticles");
    public $fire = array("FireParticles");
    public $heart = array("HeartParticles");
    public $smoke = array("SmokeParticles");
    /**@var Item*/
    private $item;
    /**@var int*/
    protected $damage = 0;
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new Particles($this), 5);
        $this->getLogger()->info("CosmeticMenu enabled!");
    }
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $inv = $player->getInventory();
        $inv->clearAll();
        $item = Item::get(345, 0, 1);
        $inv->setItem(0, $item);
    }
    public function playerSpawnEvent(PlayerRespawnEvent $ev) {
        $item = new Item(345, 0, 1);
        $ev->getPlayer()->getInventory()->addItem($item);
    }
   public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($player instanceof Player) {
            $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
            $item = $player->getInventory()->getItemInHand();
            $level = $player->getLevel();
            //particlebomb I HATE PARTICLES
        } 
	           
            if ($block->getId() === 0) {
                $player->sendPopup("§cPlease wait");
                return true;
            }
			//Leaper
            if ($item->getId() == 288) {
                $player->setMotion(new Vector3(0, 5, 0));
                $player->sendPopup("§aLeaped!");
            }
           
	//TNTLauncher
         if ($item->getId() == 352) {
            foreach ($player->getInventory()->getContents() as $item) {
                $nbt = new CompoundTag("", ["Pos" => new ListTag("Pos", [new DoubleTag("", $player->x), new DoubleTag("", $player->y + $player->getEyeHeight()), new DoubleTag("", $player->z) ]), "Motion" => new ListTag("Motion", [new DoubleTag("", -\sin($player->yaw / 180 * M_PI) * \cos($player->pitch / 180 * M_PI)), new DoubleTag("", -\sin($player->pitch / 180 * M_PI)), new DoubleTag("", \cos($player->yaw / 180 * M_PI) * \cos($player->pitch / 180 * M_PI)) ]), "Rotation" => new ListTag("Rotation", [new FloatTag("", $player->yaw), new FloatTag("", $player->pitch) ]) ]);
                $f = 3.0;
                $snowball = Entity::createEntity("PrimedTNT", $player->getLevel(), $nbt, $player);
                $snowball->setMotion($snowball->getMotion()->multiply($f));
                $snowball->spawnToAll();
            }
       }			
			 
            //Menu
            if ($item->getId() == 345) {
                $player->getInventory()->removeItem(Item::get(ITEM::COMPASS));
                $player->getInventory()->addItem(Item::get(ITEM::MINECART));
                $player->getInventory()->addItem(Item::get(ITEM::GLOWSTONE_DUST));  
                $player->getInventory()->addItem(Item::get(ITEM::REDSTONE));				
            }
			
		    //BackToCompass (Redstone)
            if ($item->getId() == 331) {
                $player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
				$player->getInventory()->removeItem(Item::get(ITEM::MINECART));
				$player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
                $player->getInventory()->addItem(Item::get(ITEM::COMPASS));
            }
		
            //Gadgets
            if ($item->getid() == 328) {
                $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
                $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
				$player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
                $player->getInventory()->addItem(Item::get(ITEM::MAGMA_CREAM));
                $player->getInventory()->addItem(Item::get(ITEM::FEATHER));
                $player->getInventory()->addItem(Item::get(ITEM::BONE));
				$player->getInventory()->addItem(Item::get(ITEM::BLAZE_ROD));
				$player->getInventory()->addItem(Item::get(ITEM::BED));
            }
			        
            //Particle
            if ($item->getid() == 348) {
                $player->getInventory()->removeItem(Item::get(ITEM::MINECART));
                $player->getInventory()->removeItem(Item::get(ITEM::GLOWSTONE_DUST));
				$player->getInventory()->removeItem(Item::get(ITEM::REDSTONE));
                $player->getInventory()->addItem(Item::get(ITEM::DYE, 4, 1));
                $player->getInventory()->addItem(Item::get(ITEM::DYE, 14, 1));
                $player->getInventory()->addItem(Item::get(ITEM::DYE, 1, 1));
                $player->getInventory()->addItem(Item::get(ITEM::DYE, 15, 1));
				$player->getInventory()->addItem(Item::get(ITEM::BED));
            }
			//BackToMenu (Bed)
			if ($item->getid() == 355) {
			    $player->getInventory()->removeItem(Item::get(ITEM::BED, 1, 1));
			    $player->getInventory()->removeItem(Item::get(ITEM::MAGMA_CREAM));
                $player->getInventory()->removeItem(Item::get(ITEM::FEATHER));
                $player->getInventory()->removeItem(Item::get(ITEM::BONE));
				$player->getInventory()->removeItem(Item::get(ITEM::BLAZE_ROD));
				$player->getInventory()->removeItem(Item::get(ITEM::BED));
                $player->getInventory()->removeItem(Item::get(ITEM::DYE, 4, 1));
                $player->getInventory()->removeItem(Item::get(ITEM::DYE, 14, 1));
                $player->getInventory()->removeItem(Item::get(ITEM::DYE, 1, 1));
                $player->getInventory()->removeItem(Item::get(ITEM::DYE, 15, 1));
                $player->getInventory()->addItem(Item::get(ITEM::MINECART));
                $player->getInventory()->addItem(Item::get(ITEM::GLOWSTONE_DUST));
				$player->getInventory()->addItem(Item::get(ITEM::REDSTONE));
        }
    }
    public function onPlayerItemHeldEvent(PlayerItemHeldEvent $e) {
        $i = $e->getItem();
        $p = $e->getPlayer();
        //ItemNames
        if ($i->getId() == 345) {
            $p->sendPopup("§l§dCosmetic§eMenu");
        }
        //Gadgets (minecrat)
        if ($i->getId() == 328) {
            $p->sendPopup("§l§6Gadgets");
        }
        //BunnyHop (feather)
        if ($i->getId() == 288) {
            $p->sendPopup("§l§bBunnyHop");
        }
        //ParticleBomb (magma cream)
        if ($i->getId() == 378) {
            $p->sendPopup("§l§dParticle§eBomb");
        }
        //LightningStick (blaze rod)
        if ($i->getId() == 369) {
            $p->sendPopup("§l§6Lighting§aStick");
        }
		 //TNTLauncher (bone)
        if ($i->getId() == 352) {
            $p->sendPopup("§l§cTNT§aLauncher");
        } 
        //Partical (glowstone dust)
        if ($i->getId() == 348) {
            $p->sendPopup("§l§bParticles");
        }
        //Water
        if ($i->getId() == 351 && $i->getDamage() == 4) {
            $p->sendPopup("§l§6Water");
        }
        //Fire
        if ($i->getId() == 351 && $i->getDamage() == 14) {
            $p->sendPopup("§l§6Fire");
        }
        //Hearts
        if ($i->getId() == 351 && $i->getDamage() == 1) {
            $p->sendPopup("§l§6Hearts");
        }
        //Smoke
        if ($i->getId() == 351 && $i->getDamage() == 15) {
            $p->sendPopup("§l§6Smoke");
        }
        //BackToCompass
        if ($i->getId() == 355) {
            $p->sendPopup("§l§7Back...");
        }
         //BackToMenu
        if ($i->getId() == 331) {
            $p->sendPopup("§l§7Back...");
        } 		
    }
    /*
     * LightingStick
     * Particals
     */
	public function ExplosionPrimeEvent(ExplosionPrimeEvent $p) {
                 $p->setBlockBreaking(false);
	}
}
