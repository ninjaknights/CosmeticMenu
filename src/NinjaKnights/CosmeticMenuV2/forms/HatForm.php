<?php 

namespace NinjaKnights\CosmeticMenuV2\forms;
    
use NinjaKnights\CosmeticMenuV2\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
    
class HatForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openHats($player) {
        $form = $this->getMain()->getForm()->createSimpleForm(function (Player $player, $data) {
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
                    $this->getMain()->getForms()->menuForm($player);   
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
		$form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}