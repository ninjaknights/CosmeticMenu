<?php 

namespace NinjaKnights\CosmeticMenuV2\forms;
    
use NinjaKnights\CosmeticMenuV2\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
    
class SuitForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openSuits($player) {
        $form = $this->getMain()->getForm()->createSimpleForm(function (Player $player, $data) {
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
                            $this->getMain()->suit1[] = $name;
                            
                            if(in_array($name, $this->main->suit2)) {
                                unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                            }

                        } else {

                            $player->removeAllEffects();
                            $armors = [
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR)
                            ];

                            $player->getArmorInventory()->setContents($armors);
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
                            $this->getMain()->suit2[] = $name;
                            
                            if(in_array($name, $this->main->suit1)) {
                                unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                            }

                        } else {

                            $player->removeAllEffects();
                            $armors = [
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR),
                                ItemFactory::get(Item::AIR)
                            ];

                            $player->getArmorInventory()->setContents($armors);
                            if(in_array($name, $this->main->suit1)) {
                                unset($this->main->suit1[array_search($name, $this->main->suit1)]);
                            }elseif(in_array($name, $this->main->suit2)) {
                                unset($this->main->suit2[array_search($name, $this->main->suit2)]);
                            }

                        }
                        
                    }
                break;
				
				case 2:
                    $player->removeAllEffects();
                    $armors = [
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR),
                        ItemFactory::get(Item::AIR)
                    ];
                    $player->getArmorInventory()->setContents($armors);
                    $name = $player->getName();
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