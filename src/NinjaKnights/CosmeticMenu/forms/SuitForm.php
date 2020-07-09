<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use NinjaKnights\CosmeticMenu\EventListener;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
    
class SuitForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openSuits($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                //Youtube Suit
                case 0:
                    if($player->hasPermission("cosmetic.suits.youtube")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->suit1)) {

                            $player->removeAllEffects();
                            $this->main->getSuits()->setSkin($player, "youtube", ".png", "youtube");
                            $this->getMain()->suit1[] = $name;
                            
                            if(in_array($name, $this->main->suit2)) {
                                unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                            }

                        } else {
                            $player->setSkin(EventListener::$skin[$name]);
                            $player->sendSkin();

                            if(in_array($name, $this->main->suit1)) {
                                unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                            }elseif(in_array($name, $this->main->suit2)) {
                                unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                            }

                        }
                        
                    }
                break;
                //Frog Suit
                case 1:
                    if($player->hasPermission("cosmetic.suits.frog")){
                        $name = $player->getName();
                        
                        if(!in_array($name, $this->getMain()->suit2)) {

                            $player->removeAllEffects();
                            $this->main->getSuits()->setSkin($player, "frog", ".png", "frog");
                            $this->getMain()->suit2[] = $name;
                            
                            if(in_array($name, $this->main->suit1)) {
                                unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                            }

                        } else {
                            $player->setSkin(EventListener::$skin[$name]);
                            $player->sendSkin();

                            $player->removeAllEffects();

                            if(in_array($name, $this->main->suit1)) {
                                unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                            }elseif(in_array($name, $this->main->suit2)) {
                                unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                            }

                        }
                        
                    }
                break;
				
                case 2:
                    $name = $player->getName();
                    $player->removeAllEffects();
                   
                    if(in_array($name, $this->main->suit1)) {
                        unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                    }elseif(in_array($name, $this->main->suit2)) {
                        unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                    }
				break;
				
				case 3:
                    $this->getMain()->getForms()->menuForm($player);   
                break;
            }
        });
        $form->setTitle("Suits");
        $form->setContent("Pick One");
        $form->addButton("Youtube Suit");
        $form->addButton("Frog Suit");
		$form->addButton("Clear");
		$form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }


}