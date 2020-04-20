<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\Server;
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

use pocketmine\entity\Skin;

/* Will be used later on
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\BlazeShootSound;
*/

use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

use NinjaKnights\CosmeticMenu\Gadgets\Gadgets;
use NinjaKnights\CosmeticMenu\Cooldown;
use NinjaKnights\CosmeticMenu\Particles\Particles;
use NinjaKnights\CosmeticMenu\Trails\Trails;

class Main extends PluginBase implements Listener {

     /**@var Item*/
	private $item;
	/**@var int*/
	protected $damage = 0;
	
	public $inv = [];
    public $inventories;

    /**
     * @param EntityLevelChangeEvent $event
     */

    public $tntCooldown = [ ];
	public $tntCooldownTime = [ ];
	public $lsCooldownTime = [ ];
	public $lsCooldown = [ ];
	public $sbCooldown = [ ];
	public $sbCooldownTime = [ ];
	
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
	public $particle2 = array("Flaming Rings");
	public $particle3 = array("SnowAura");
    public $particle4 = array("Cupid's Love");
    public $particle5 = array("Bullet Helix");
    public $particle6 = array("Test");


    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new Gadgets($this), $this);
        $this->MorphX = $this->getServer()->getPluginManager()->getPlugin("MorphX");
        $this->getScheduler()->scheduleRepeatingTask(new Particles($this), 3);
        $this->getScheduler()->scheduleRepeatingTask(new Trails($this), 5);
        $this->getScheduler()->scheduleRepeatingTask(new Cooldown($this), 20);
    }

    public function onJoin(PlayerJoinEvent $event) {
		
		$player = $event->getPlayer();
		$name = $player->getName();
		
		$player->setFood($player->getMaxFood()); 
		
		$player->setGamemode(2);
		
		$this->getCosmetic($player);
		
		$x = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
		$y = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
		$z = $this->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
		
		$player->teleport(new Vector3($x, $y, $z));
    }
    
    public function getCosmetic(Player $player) {
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		$inv = $player->getInventory();
		
		$item1 = Item::get(345, 0, 1);
		$item1->setCustomName("§l§3Cosmetic§8Menu");
		$inv->setItem(0, $item1);
	} 
	
	public function openMenu($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.gadgets")){
                        $this->openGadgets($player);
                    } 
                break;

                case 1:
                    if($player->hasPermission("cosmetic.particles")){
                        $this->openParticles($player);
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.masks")){
                        $this->openHats($player);
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.trails")){
                        $this->openTrails($player);
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmetic.morphs")){
                        $this->openMorphs($player);
                    }
                break;
            }
        });
           
        $form->setTitle("§l§3Cosmetic§8Menu");
        $form->addButton("§l§6Gadgets");
        $form->addButton("§l§6Particles");
        $form->addButton("§l§6Hats");
        $form->addButton("§l§6Trails");
        $form->addButton("§l§6Morphs");
        $form->sendToPlayer($player);
        return $form;
    }

    public function openGadgets($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.gadgets.tntlauncher")){
		                $inv = $player->getInventory();
		
		                $item = Item::get(352, 0, 1);
                        $item->setCustomName("§l§4T§fN§4T§f-Launcher");
                        $inv->setItem(0, $item);
                    
                        $item1 = Item::get(355, 0 , 1);
                        $item1->setCustomName("§l§4Back");
                        $inv->setItem(8, $item1);
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmetic.gadgets.lightningstick")){
                        $inv = $player->getInventory();
		
                        $item = Item::get(369, 0, 1);
                        $item->setCustomName("§l§dLightning §eStick");
                        $inv->setItem(0, $item);

                        $item1 = Item::get(355, 0 , 1);
                        $item1->setCustomName("§l§4Back");
                        $inv->setItem(8, $item1);
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.gadgets.leaper")){
                        $inv = $player->getInventory();
		
		                $item = Item::get(288, 0, 1);
		                $item->setCustomName("§l§2Leaper");
                        $inv->setItem(0, $item);
                        
                        $item1 = Item::get(355, 0 , 1);
                        $item1->setCustomName("§l§4Back");
                        $inv->setItem(8, $item1);
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.gadgets.smokebomb")){
                        $inv = $player->getInventory();
                        
	    	            $item = Item::get(385, 0, 1);
		                $item->setCustomName("§l§fSmoke §8Bomb");   
                        $inv->setItem(0, $item);
                    
                        $item1 = Item::get(355, 0 , 1);
                        $item1->setCustomName("§l§4Back");
                        $inv->setItem(8, $item1);
                    }
                break;

                case 4:
                    $this->openMenu($player);
                break;
            }
        });
           
        $form->setTitle("Gadgets");
        $form->setContent("Pick One");
        $form->addButton("§l§4T§fN§4T§f-Launcher");
        $form->addButton("§l§dLightning §eStick");
        $form->addButton("§l§2Leaper");
        $form->addButton("§l§fSmoke §8Bomb");
        $form->addButton("§l§4Back");
        $form->sendToPlayer($player);
        return $form;
    }

    public function openParticles($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.particles.raincloud")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->particle1)) {
                    
                            $this->particle1[] = $name;
                            $player->sendMessage("You have enabled your §l§1Rain §fCloud§r Particle");
                            
                            if(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                            
                        } else {
                            
                            unset($this->particle1[array_search($name, $this->particle1)]);
                            $player->sendMessage("You have disabled your §l§1Rain §fCloud§r Particle");
                            
                            if(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                        }
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmetic.particles.flamingring")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->particle2)) {
                    
                            $this->particle2[] = $name;
                            $player->sendPopup("You have enabled your §l§6Flaming §eRings§r Particle");
                            
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                            
                        } else {
                            
                            unset($this->particle2[array_search($name, $this->particle2)]);
                            $player->sendPopup("You have disabled your §l§6Flaming §eRings§r Particle");
                            
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                        }
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.particles.snowaura")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->particle3)) {
                    
                            $this->particle3[] = $name;
                            $player->sendPopup("You have enabled your §l§fSnow §3Aura§r Particle");
                            
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                            
                        } else {
                            
                            unset($this->particle3[array_search($name, $this->particle3)]);
                            $player->sendPopup("You have disabled your §l§fSnow §3Aura§r Particle");
                           
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                        }
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.particles.cupidslove")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->particle4)) {
                    
                            $this->particle4[] = $name;
                            $player->sendPopup("You have enabled your §l§cCupid's §4Love§r Particle");
                            
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            } 
                            
                        } else {
                            
                            unset($this->particle4[array_search($name, $this->particle4)]);
                            $player->sendPopup("You have disabled your §l§cCupid's §4Love§r Particle");
                                 
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle5)) {
                                unset($this->particle5[array_search($name, $this->particle5)]);
                            }
                        }
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmetic.particles.bullethelix")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->particle5)) {
                    
                            $this->particle5[] = $name;
                            $player->sendPopup("You have enabled your Bullet Helix Particle");
                            
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            }
                            
                        } else {
                            
                            unset($this->particle5[array_search($name, $this->particle5)]);
                            $player->sendPopup("You have disabled your Bullet Helix Particle");
                                 
                            if(in_array($name, $this->particle1)) {
                                unset($this->particle1[array_search($name, $this->particle1)]);
                            } elseif(in_array($name, $this->particle2)) {
                                unset($this->particle2[array_search($name, $this->particle2)]);
                            } elseif(in_array($name, $this->particle3)) {
                                unset($this->particle3[array_search($name, $this->particle3)]);
                            } elseif(in_array($name, $this->particle4)) {
                                unset($this->particle4[array_search($name, $this->particle4)]);
                            }
                        }
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmetic.particles.test")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->particle6)) {
                    
                            $this->particle6[] = $name;
                            $player->sendPopup("You have enabled your  Particle");
                            
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
                            }
                            
                        } else {
                            
                            unset($this->particle6[array_search($name, $this->particle6)]);
                            $player->sendPopup("You have disabled your Particle");
                                 
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
                            }
                        }
                    }
                break;

                case 6:
                    $name = $player->getName();

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
                    }

                break;

                case 7:
                    $this->openMenu($player);
                break;
            }
        });
           
        $form->setTitle("Particles");
        $form->setContent("Pick One");
        $form->addButton("§l§1Rain §fCloud");
        $form->addButton("§l§6Flaming §eRings");
        $form->addButton("§l§fSnow §3Aura");
        $form->addButton("§l§cCupid's §4Love");
        $form->addButton("Bullet Helix");
        $form->addButton("Test");
        $form->addButton("Clear");
        $form->addButton("§l§4Back");
        $form->sendToPlayer($player);
        return $form;
	}
	
	public function openHats($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.masks.zombie")){
                        $name = $player->getName();
                        
                        if(in_array($name, $this->zombie)) {
                    
                            unset($this->zombie[array_search($name, $this->zombie)]);
                            $player->sendPopup("You have no §9Hat§r on");
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
                            $player->sendPopup("You have The §l§2Zombie §9Hat§r on!");
                            $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,2,1));
                            $player->sendPopup("§l§aPlop!");
                                            
                        }
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmetic.masks.skeleton")){
                        $name = $player->getName();
    
                        if(in_array($name, $this->skeleton)) {
                    
                            unset($this->skeleton[array_search($name, $this->skeleton)]);
                            $player->sendPopup("You have no §9Hat§r on");
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
                            $player->sendPopup("You have The §l§fSkeleton §9Hat§r on!");
                            $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,0,1));
                            $player->sendPopup("§l§aPlop!");
                                        
                        }
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.masks.creeper")){
                        $name = $player->getName();
                        
                        if(in_array($name, $this->creeper)) {
                    
                            unset($this->creeper[array_search($name, $this->creeper)]);
                            $player->sendPopup("You have no §9Hat§r on");
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
                            $player->sendPopup("You have The §l§aCreeper §9Hat§r on!");
                            $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,4,1));
                            $player->sendPopup("§l§aPlop!");
                                        
                        }
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.masks.witherskeleton")){
                        $name = $player->getName();
                        
                        if(in_array($name, $this->witherskeleton)) {
                    
                            unset($this->witherskeleton[array_search($name, $this->witherskeleton)]);
                            $player->sendPopup("You have no §9Hat§r on");
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
                            $player->sendPopup("You have The §l§8Wither§fSkeleton §9Hat§r on!");
                            $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,1,1));
                            $player->sendPopup("§l§aPlop!");
                                            
                        }
                    }
				break;
				
                case 4:
                    if($player->hasPermission("cosmetic.masks.dragon")){
                        $name = $player->getName();
                        
                        if(in_array($name, $this->dragon)) {
                    
                            unset($this->dragon[array_search($name, $this->dragon)]);
                            $player->sendPopup("You have no §9Hat§r on");
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
                            $player->sendPopup("You have The §l§5Dragon §9Hat§r on!");
                            $player->getArmorInventory()->setHelmet(Item::get(ITEM::SKULL,5,1));
                            $player->sendPopup("§l§aPlop!");
                                            
                        }
                    }
				break;
				
				case 5:
					$player->sendPopup("You have no §9Hat§r on");
					$player->getArmorInventory()->setHelmet(Item::get(0, 0, 1));
				break;
				
				case 6:
                    $this->openMenu($player);
                break;
            }
        });
        $form->setTitle("§9Hats");
        $form->setContent("Pick One");
        $form->addButton("§l§2Zombie §9Hat");
        $form->addButton("§l§fSkeleton §9Hat");
        $form->addButton("§l§aCreeper §9Hat");
        $form->addButton("§l§8Wither§fSkeleton §9Hat");
        $form->addButton("§l§5Dragon §9Hat");
		$form->addButton("Clear");
		$form->addButton("§l§4Back");
        $form->sendToPlayer($player);
        return $form;
    }

    public function openTrails($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.trails.flame")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->trail1)) {
                    
                            $this->trail1[] = $name;
                            $player->sendMessage("You have enabled your §l§6Flame §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            } elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }
                            
                        } else {
                            
                            unset($this->trail1[array_search($name, $this->trail1)]);
                            $player->sendMessage("You have disabled your §l§6Flame §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            } elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }	
                        }
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmetic.trails.snow")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->trail2)) {
                    
                            $this->trail2[] = $name;
                            $player->sendPopup("You have enabled your §l§fSnow §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            } 
                            elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            } 
                            elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }
                            
                        } else {
                            
                            unset($this->trail2[array_search($name, $this->trail2)]);
                            $player->sendPopup("You have disabled your §l§fSnow §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            } elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            } elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }
                        }
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.trails.heart")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->trail3)) {
                    
                            $this->trail3[] = $name;
                            $player->sendPopup("You have enabled your §l§4Heart §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            }
                            elseif(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } 
                            elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }
                            
                        } else {
                            
                            unset($this->trail3[array_search($name, $this->trail3)]);
                            $player->sendPopup("You have disabled your §l§4Heart §gTrail§r Particle");
                          
                            if(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } elseif(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            } elseif(in_array($name, $this->trail4)) {
                                unset($this->trail4[array_search($name, $this->trail4)]);
                            }
                        }
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.trails.smoke")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->trail4)) {
                    
                            $this->trail4[] = $name;
                            $player->sendPopup("You have enabled your §l§fSmoke §gTrail§r Particle");
                            
                            if(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            }
                            elseif(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } 
                            elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            }
                            
                        } else {
                            
                            unset($this->trail4[array_search($name, $this->trail4)]);
                            $player->sendPopup("You have disabled your §l§fSmoke §gTrail§r Particle");
                                
                            if(in_array($name, $this->trail2)) {
                                unset($this->trail2[array_search($name, $this->trail2)]);
                            } elseif(in_array($name, $this->trail3)) {
                                unset($this->trail3[array_search($name, $this->trail3)]);
                            } elseif(in_array($name, $this->trail1)) {
                                unset($this->trail1[array_search($name, $this->trail1)]);
                            }
                        }
                    }
                break;

                case 4:
                    $name = $player->getName();

                    if(in_array($name, $this->trail1)) {
                        unset($this->trail1[array_search($name, $this->trail1)]);
                    }
                    elseif(in_array($name, $this->trail2)) {
                        unset($this->trail2[array_search($name, $this->trail2)]);
                    } 
                    elseif(in_array($name, $this->trail3)) {
                        unset($this->trail3[array_search($name, $this->trail3)]);
                    }
                    elseif(in_array($name, $this->trail4)) {
                        unset($this->trail4[array_search($name, $this->trail4)]);
                    }
                break;

                case 5:
                    $this->openMenu($player);
                break;
            }
        });
           
        $form->setTitle("Trails");
        $form->setContent("Pick One");
        $form->addButton("§l§6Flame §gTrail");
        $form->addButton("§l§fSnow §gTrail");
        $form->addButton("§l§4Heart §gTrail");
        $form->addButton("§l§fSmoke §gTrail");
        $form->addButton("Clear");
        $form->addButton("§l§4Back");
        $form->sendToPlayer($player);
        return $form;
    }

    public function openMorphs($player) {
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, $data) {
            $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.morphs.zombie")){
                        Server::getInstance()->dispatchCommand($player, "morph zombie");
                    }
                break;

                case 1:
                    Server::getInstance()->dispatchCommand($player, "morph remove");
                break;

                case 2:
                    $this->openMenu($player);             
                break;
            }
        });

        $form->setTitle("Morphs");
        $form->setContent("Pick One");
        $form->addButton("Zombie");
        $form->addButton("Remove");
        $form->addButton("§l§4Back");
        $form->sendToPlayer($player);
        return $form;
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

        if($iname == "§l§3Cosmetic§8Menu") {
            $this->openMenu($player);
        }

        //Gadgets
		//TNT-Launcher
		if($iname == "§l§4T§fN§4T§f-Launcher") {
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
                $time = "30";
                $this->tntCooldownTime[$player->getName()] = $time;

            } else {
                $player->sendPopup("§cYou can't use the §l§4T§fN§4T§f-Launcher §c for another ".$this->tntCooldownTime[$player->getName()]." seconds.");
            }
            } else {
				
				$player->sendMessage("You don't have permission to use TNT-Launcher!");
				
			}
        }
		//Lightning Stick
		if($iname == "§l§dLightning §eStick") {
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
                $player->sendPopup("§cYou can't use the §l§dLightning §eStick for another ".$this->lsCooldownTime[$player->getName()]." seconds.");
            	}
			} else {
				$player->sendMessage("You don't have permission to use §l§dLightning §eStick!");
			}
		}
        //Leaper
        if($iname == "§l§2Leaper") {
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
		if($iname == "§l§fSmoke §8Bomb") {
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
				$egg = Entity::createEntity("Egg", $player->getLevel(), $nbt, $player);
				$egg->setMotion($egg->getMotion()->multiply($f));
				$egg->spawnToAll();
				$this->sbCooldown[$player->getName()] = $player->getName();
                $time = "30";
                $this->sbCooldownTime[$player->getName()] = $time;

            } else {
                $player->sendPopup("§cYou can't use the §l§fSmoke §8Bomb for another ".$this->sbCooldownTime[$player->getName()]." seconds.");
            }
            } else {
				
				$player->sendMessage("You don't have permission to use §l§fSmoke §8Bomb!");
				
			}
        }
        //Back
        if($iname == "§l§4Back") {

            $item1 = Item::get(345, 0, 1);
            $item1->setCustomName("§l§3Cosmetic§8Menu");
            $inv->setItem(0, $item1);  
            
            $item1 = Item::get(0, 0 , 1);
            $inv->setItem(8, $item1);

        }

    }

}