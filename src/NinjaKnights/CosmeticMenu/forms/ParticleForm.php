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
                    if($player->hasPermission("cosmeticmenu.particles.raincloud")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle1)) {

                            $this->main->particle1[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                            
                    } 
                break;
                //Flame Rings
                case 1:
                    if($player->hasPermission("cosmeticmenu.particles.flamerings")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle2)) {

                            $this->main->particle2[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }
                        }
                    }
                break;
                //Blizzard Aura
                case 2:
                    if($player->hasPermission("cosmeticmenu.particles.blizzardaura")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle3)) {

                            $this->main->particle3[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                    }
                break;
                //Cupid's Love
                case 3:
                    if($player->hasPermission("cosmeticmenu.particles.cupidslove")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle4)) {

                            $this->main->particle4[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        } 
                    }
                break;
                //Bullet Helix
                case 4:
                    if($player->hasPermission("cosmeticmenu.particles.bullethelix")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle5)) {

                            $this->main->particle5[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                    }
                break;
                //Conduit Halo
                case 5:
                    if($player->hasPermission("cosmeticmenu.particles.conduitaura")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle6)) {

                            $this->main->particle6[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        } 
                    }
                break;
                //Witch Curse
                case 6:
                    if($player->hasPermission("cosmeticmenu.particles.witchcurse")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle7)) {

                            $this->main->particle7[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                    }
                break;
                //Emerald Twirl
                case 7:
                    if($player->hasPermission("cosmeticmenu.particles.emeraldtwirl")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle8)) {

                            $this->main->particle8[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                    }
                break;
                //Blood Helix
                case 8:
                    if($player->hasPermission("cosmeticmenu.particles.bloodhelix")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->particle9)) {

                            $this->main->particle9[] = $name;

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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            }

                        }
                    }
                break;

                case 9:
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

                case 10:
                    $this->main->getForms()->menuForm($player);
                break;
            }
        });
        $particlecfg = $this->main->particlecfg;   
        $form->setTitle($particlecfg->getNested("Name"));
        $form->setContent($particlecfg->getNested("Form-Content"));
        $perm = "cosmeticmenu.particles.";

        if($particlecfg->getNested("Rain-Cloud.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."raincloud")){
                $form->addButton("Rain Cloud",0,"",0);
            }
        }

        if($particlecfg->getNested("Flame-Rings.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."flamerings")){
                $form->addButton("Flame Rings",0,"",1);
            }
        }

        if($particlecfg->getNested("Blizzard-Aura.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."blizzardaura")){
                $form->addButton("Blizzard Aura",0,"",2);
            }
        }

        if($particlecfg->getNested("Cupids-Love.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."cupidslove")){
                $form->addButton("Cupid's Love",0,"",3);
            }
        }

        if($particlecfg->getNested("Bullet-Helix.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."bullethelix")){
                $form->addButton("Bullet Helix",0,"",4);
            }
        }

        if($particlecfg->getNested("Conduit-Aura.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."conduitaura")){
                $form->addButton("Conduit Aura",0,"",5);
            }
        }
        
        if($particlecfg->getNested("Witch-Curse.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."witchcurse")){
                $form->addButton("Witch Curse",0,"",6);
            }
        }
        
        if($particlecfg->getNested("Emerald-Twirl.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."emeraldtwirl")){
                $form->addButton("Emerald Twirl",0,"",7);
            }
        }

        if($particlecfg->getNested("Blood-Helix.Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."bloodhelix")){
                $form->addButton("Blood Helix",0,"",8);
            }
        }
        $form->addButton("Clear",0,"",9);
        $form->addButton("§l§8<< Back",0,"",10);
        $form->sendToPlayer($player);
        return $form;
    }

}