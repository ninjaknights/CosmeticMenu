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
        $particlecfg = $this->main->particlecfg;
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                /*case 0:
                    if($player->hasPermission("cosmeticmenu.gadgets")){
                        $this->main->getGadgetForm()->openGadgets($player);
                    } 
                break;*/

                case 0:
                    if($player->hasPermission("cosmeticmenu.particles")){
                        $this->main->getParticleForm()->openParticles($player);
                    }
                break;

                case 1:
                    if($player->hasPermission("cosmeticmenu.suits")){
                        $this->main->getSuitForm()->openSuits($player);
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmeticmenu.hats")){
                        $this->main->getHatForm()->openHats($player);
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmeticmenu.trails")){
                        $this->main->getTrailForm()->openTrails($player);
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmeticmenu.morphs")){
                        $this->main->getMorphForm()->openMorphs($player);
                    }
                break;
            }
        });
           
        $form->setTitle($this->main->config->getNested("Name"));
        $form->setContent($this->main->cosmeticFormContent);
        $perm = "cosmeticmenu.";
        //Particles
        $particlecfg = $this->main->particlecfg;
        if($particlecfg->getNested("Enable")){
            $this->particleSupport = true;
            if($player->hasPermission($perm ."particles")){
                $form->addButton($particlecfg->getNested("Name"),0,"",0);
            }
        }
        //Suits
        $suitcfg = $this->main->suitcfg;
        if($suitcfg->getNested("Enable")){
            $this->suitSupport = true;
            if($player->hasPermission($perm ."suits")){
                $form->addButton($suitcfg->getNested("Name"),0,"",1);
            }
        }
        //Hats
        $hatcfg = $this->main->hatcfg;
        if($hatcfg->getNested("Enable")){
            $this->hatSupport = true;
            if($player->hasPermission($perm ."hats")){
                $form->addButton($hatcfg->getNested("Name"),0,"",2);
            }
        }
        //Trails
        $trailcfg = $this->main->trailcfg;
        if($trailcfg->getNested("Enable")){
            $this->trailSupport = true;
            if($player->hasPermission($perm ."trails")){
                $form->addButton($trailcfg->getNested("Name"),0,"",3);
            }
        }
        //Morphs
        $morphcfg = $this->main->morphcfg;
        if($morphcfg->getNested("Enable")){
            $this->morphSupport = true;
            if($player->hasPermission($perm ."morphs")){
                $form->addButton($morphcfg->getNested("Name"),0,"",4);
            }
        }
        $form->sendToPlayer($player);
    }

}