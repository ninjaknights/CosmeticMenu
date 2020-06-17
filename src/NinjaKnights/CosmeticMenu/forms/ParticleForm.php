<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use NinjaKnights\CosmeticMenu\libs\jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Location;
    
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
                            }

                        }
                    }
                break;
                //Blood Helix
                case 7:
                    if($player->hasPermission("cosmetic.particles.bloodhelix")){
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
                            } elseif(in_array($name, $this->main->particle9)) {
                                unset($this->main->particle9[array_search($name, $this->main->particle9)]);
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
                            }

                        }
                    }
                break;
                //Emerald Twirl
                case 8:
                    if($player->hasPermission("cosmetic.particles.emeraldtwirl")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle9)) {

                            $this->getMain()->particle9[] = $name;

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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
                            }

                        }
                    }
                break;
                //Test
                case 9:
                    if($player->hasPermission("cosmetic.particles.test")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->particle10)) {

                            $this->getMain()->particle10[] = $name;

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
                            } elseif(in_array($name, $this->main->particle10)) {
                                unset($this->main->particle10[array_search($name, $this->main->particle10)]);
                            }

                        }
                    }
                break;

                case 10:
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
                    } elseif(in_array($name, $this->main->particle10)) {
                        unset($this->main->particle10[array_search($name, $this->main->particle10)]);
                    }
                break;

                case 11:
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
        $form->addButton("Conduit Halo");
        $form->addButton("Wicth Curse");
        $form->addButton("Blood Helix\nNot Working for now");//must change
        $form->addButton("Emerald Twirl");
        $form->addButton("Not Added");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}