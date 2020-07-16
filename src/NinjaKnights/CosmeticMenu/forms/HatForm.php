<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use NinjaKnights\CosmeticMenu\EventListener;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
    
class HatForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openHats($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                //TV Hat
                case 0:
                    if($player->hasPermission("cosmetic.hats.tv")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->main->hat1)) {

                            $this->main->setSkin()->setSkin($player, "tv", "hats");
                            $this->main->hat1[] = $name;
                            
                            if(in_array($name, $this->main->hat2)) {
                                unset($this->main->hat2[array_search($name, $this->main->hat2)]);
                            }

                        } else {
                            $this->resetSkin($player);

                            if(in_array($name, $this->main->hat1)) {
                                unset($this->main->hat1[array_search($name, $this->main->hat1)]);
                            }elseif(in_array($name, $this->main->hat2)) {
                                unset($this->main->hat2[array_search($name, $this->main->hat2)]);
                            }

                        }
                        
                    }
                break;
				
                case 1:
                    $name = $player->getName();
                    $this->resetSkin($player);
                   
                    if(in_array($name, $this->main->hat1)) {
                        unset($this->main->hat1[array_search($name, $this->main->hat1)]);
                    }elseif(in_array($name, $this->main->hat2)) {
                        unset($this->main->hat2[array_search($name, $this->main->hat2)]);
                    }
				break;
				
				case 2:
                    $this->main->getForms()->menuForm($player);   
                break;
            }
        });
        $form->setTitle("Hats");
        $form->setContent($this->main->hatFormContent);
        if($this->main->tvhat){
            $form->addButton("TV Hat",0,"",0);
        }
        $form->addButton("Clear",0,"",1);
        $form->addButton("§l§8<< Back",0,"",2);
        $form->sendToPlayer($player);
        return $form;
    }

    public function resetSkin(Player $player)
    {
        $player->sendPopup("§aReset to original skin successfull");
        $reset = $this->main->resetSkin();
        $reset->setSkin($player);
    }

}