<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
    
class ParticleForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

     public function openParticles($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                //Rain Cloud
                case 0:
                    if($player->hasPermission("cosmetic.particles.raincloud")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle1)) {

                            $this->getMain()->particle1[] = $name;

                            if(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        } else {
                            
                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        }
                            
                    } 
                break;
                //Flame Rings
                case 1:
                    if($player->hasPermission("cosmetic.particles.flamingring")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle2)) {

                            $this->getMain()->particle2[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        }
                    }
                break;
                //Blizzard Aura
                case 2:
                    if($player->hasPermission("cosmetic.particles.snowaura")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle3)) {

                            $this->getMain()->particle3[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }  

                        }
                    }
                break;
                //Cupid's Love
                case 3:
                    if($player->hasPermission("cosmetic.particles.cupidslove")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle4)) {

                            $this->getMain()->particle4[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        } 
                    }
                break;
                //Bullet Helix
                case 4:
                    if($player->hasPermission("cosmetic.particles.bullethelix")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle5)) {

                            $this->getMain()->particle5[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        }
                    }
                break;
                //Conduit Halo
                case 5:
                    if($player->hasPermission("cosmetic.particles.conduithalo")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle6)) {

                            $this->getMain()->particle6[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        } 
                    }
                break;
                //Witch Curse
                case 6:
                    if($player->hasPermission("cosmetic.particles.witchcurse")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle7)) {

                            $this->getMain()->particle7[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            } 

                        }
                    }
                break;
                //Emerald Twirl
                case 7:
                    if($player->hasPermission("cosmetic.particles.emeraldtwirl")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle8)) {

                            $this->getMain()->particle8[] = $name;

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            }

                        } else {

                            if(in_array($name, $this->main->particle1)) {
                                unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                            } elseif(in_array($name, $this->main->particle2)) {
                                unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                            } elseif(in_array($name, $this->main->particle3)) {
                                unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                            } elseif(in_array($name, $this->main->particle4)) {
                                unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                            } elseif(in_array($name, $this->main->particle5)) {
                                unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                            } elseif(in_array($name, $this->main->particle6)) {
                                unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                            } elseif(in_array($name, $this->main->particle7)) {
                                unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                            } elseif(in_array($name, $this->main->particle8)) {
                                unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                            }

                        }
                    }
                break;

                case 8:
                    $name = $player->getName();
                    
                    if(in_array($name, $this->main->particle1)) {
                        unset($this->main->particle1[array_search($name, $this->main->particle1)]);
                    } elseif(in_array($name, $this->main->particle2)) {
                        unset($this->main->particle2[array_search($name, $this->main->particle2)]);
                    } elseif(in_array($name, $this->main->particle3)) {
                        unset($this->main->particle3[array_search($name, $this->main->particle3)]);
                    } elseif(in_array($name, $this->main->particle4)) {
                        unset($this->main->particle4[array_search($name, $this->main->particle4)]);
                    } elseif(in_array($name, $this->main->particle5)) {
                        unset($this->main->particle5[array_search($name, $this->main->particle5)]);
                    } elseif(in_array($name, $this->main->particle6)) {
                        unset($this->main->particle6[array_search($name, $this->main->particle6)]);
                    } elseif(in_array($name, $this->main->particle7)) {
                        unset($this->main->particle7[array_search($name, $this->main->particle7)]);
                    } elseif(in_array($name, $this->main->particle8)) {
                        unset($this->main->particle8[array_search($name, $this->main->particle8)]);
                    } elseif(in_array($name, $this->main->particle9)) {
                        unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                    } 
                break;

                case 9:
                    $this->getMain()->getForms()->menuForm($player);
                break;
            }
        });
           
        $form->setTitle("Particles");
        $form->setContent("Pick One");
        $form->addButton("Rain Cloud");
        $form->addButton("Flame Rings");
        $form->addButton("Blizzard Aura");
        $form->addButton("Cupid's Love");
        $form->addButton("Bullet Helix");
        $form->addButton("Conduit Aura");
        $form->addButton("Wicth Curse");
        $form->addButton("Emerald Twirl");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}