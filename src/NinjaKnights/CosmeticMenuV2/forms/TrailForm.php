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
    
                        if(!in_array($name, $this->getMain()->trail1)) {
                    
                            $this->getMain()->trail1[] = $name;
                            
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
                    if($player->hasPermission("cosmetic.trails.snow")){
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
                    if($player->hasPermission("cosmetic.trails.heart")){
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
                    if($player->hasPermission("cosmetic.trails.smoke")){
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
                    $this->getMain()->getForms()->menuForm($player);
                break;
            }
        });
           
        $form->setTitle("Trails");
        $form->setContent("Pick One");
        $form->addButton("Flame Trail");
        $form->addButton("Snow Trail");
        $form->addButton("Heart Trail");
        $form->addButton("Smoke Trail");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}