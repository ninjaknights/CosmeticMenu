<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
    
class MainForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }
    
    public function menuForm($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.gadgets")){
                        $this->main->getGadgetForm()->openGadgets($player);
                    } 
                break;

                case 1:
                    if($player->hasPermission("cosmetic.particles")){
                        $this->main->getParticleForm()->openParticles($player);
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.suits")){
                        $this->main->getSuitForm()->openSuits($player);
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.hats")){
                        $this->main->getHatForm()->openHats($player);
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmetic.trails")){
                        $this->main->getTrailForm()->openTrails($player);
                    }
                break;

                case 5:
                    if($player->hasPermission("cosmetic.morphs")){
                        $this->main->getMorphForm()->openMorphs($player);
                    }
                break;
            }
        });
           
        $form->setTitle($this->main->cosmeticName);
        $form->setContent($this->main->cosmeticFormContent);
        if($this->main->gadgetSupport){
            $form->addButton("§l§8Gadgets\n§r§7Click to Open",0,"",0);
        }
        if($this->main->particleSupport){
            $form->addButton("§l§8Particles\n§r§7Click to Open",0,"",1);
        }
        if($this->main->suitSupport){
            $form->addButton("§l§8Suits\n§r§7Click to Open",0,"",2);
        }
        if($this->main->hatSupport){
            $form->addButton("§l§8Hats\n§r§7Click to Open",0,"",3);
        }
        if($this->main->trailSupport){
            $form->addButton("§l§8Trails\n§r§7Click to Open",0,"",4);
        }
        if($this->main->morphSupport){
            $form->addButton("§l§8Morphs\n§r§7Click to Open",0,"",5);
        }
        $form->sendToPlayer($player);
    }

}