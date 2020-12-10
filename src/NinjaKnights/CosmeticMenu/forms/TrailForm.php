<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
    
class TrailForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openTrails($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmeticmenu.trails.flame")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->main->trail1)) {
                    
                            $this->main->trail1[] = $name;
                            
                            if(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                            
                        } else {
                            
                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                        }
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmeticmenu.trails.snow")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->main->trail2)) {
                    
                            $this->main->trail2[] = $name;

                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                            
                        } else {
                            
                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                        }
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmeticmenu.trails.heart")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->main->trail3)) {
                    
                            $this->main->trail3[] = $name;

                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                            
                        } else {
                            
                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                        }
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmeticmenu.trails.smoke")){
                        $name = $player->getName();
    
                        if(!in_array($name, $this->main->trail4)) {
                    
                            $this->main->trail4[] = $name;
                            
                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            }
                            
                        } else {
                            
                            if(in_array($name, $this->main->trail1)) {
                                unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                            } elseif(in_array($name, $this->main->trail2)) {
                                unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                            } elseif(in_array($name, $this->main->trail3)) {
                                unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                            } elseif(in_array($name, $this->main->trail4)) {
                                unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                            }
                        }
                    }
                break;

                case 4:
                    $name = $player->getName();

                    if(in_array($name, $this->main->trail1)) {
                        unset($this->main->trail1[array_search($name, $this->main->trail1)]);
                    } elseif(in_array($name, $this->main->trail2)) {
                        unset($this->main->trail2[array_search($name, $this->main->trail2)]);
                    } elseif(in_array($name, $this->main->trail3)) {
                        unset($this->main->trail3[array_search($name, $this->main->trail3)]);
                    } elseif(in_array($name, $this->main->trail4)) {
                        unset($this->main->trail4[array_search($name, $this->main->trail4)]);
                    }
                break;

                case 5:
                    $this->main->getForms()->menuForm($player);
                break;
            }
        });
        $trailcfg = $this->main->trailcfg;
        $form->setTitle($trailcfg->getNested("Name"));
        $form->setContent($trailcfg->getNested("Form-Content"));
        $perm = "cosmeticmenu.trails.";
        if($trailcfg->getNested("Flame-Trail.Enable")){
            $this->trailSupport = true;
            if($player->hasPermission($perm ."flame")){
                $form->addButton("Flame Trail",0,"",0);
            }
        }

        if($trailcfg->getNested("Snow-Trail.Enable")){
            $this->trailSupport = true;
            if($player->hasPermission($perm ."snow")){
                $form->addButton("Snow Trail",0,"",1);
            }
        }

        if($trailcfg->getNested("Heart-Trail.Enable")){
            $this->trailSupport = true;
            if($player->hasPermission($perm ."heart")){
                $form->addButton("Heart Trail",0,"",2);
            }
        }

        if($trailcfg->getNested("Smoke-Trail.Enable")){
            $this->trailSupport = true;
            if($player->hasPermission($perm ."smoke")){
                $form->addButton("Smoke Trail",0,"",3);
            }
        }
        $form->addButton("Clear",0,"",4);
        $form->addButton("§l§8<< Back",0,"",5);
        $form->sendToPlayer($player);
        return $form;
    }

}