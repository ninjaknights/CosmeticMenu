<?php 

namespace NinjaKnights\CosmeticMenuV2\forms;
    
use NinjaKnights\CosmeticMenuV2\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
    
class TrailForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openTrails($player) {
        $form = $this->getMain()->getForm()->createSimpleForm(function (Player $player, $data) {
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
                    $this->getMain()->getForms()->menuForm($player);
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
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}