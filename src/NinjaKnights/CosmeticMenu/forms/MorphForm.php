<?php 

namespace NinjaKnights\CosmeticMenu\forms;
    
use NinjaKnights\CosmeticMenu\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
    
class MorphForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function openMorphs($player) {
        $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.morphs.zombie")){
                        Server::getInstance()->dispatchCommand($player, "morph zombie");
                    }
                break;

                case 1:
                    Server::getInstance()->dispatchCommand($player, "morph remove");
                break;

                case 2:
                    $this->main->getForms()->menuForm($player);    
                break;
            }
        });

        $form->setTitle("Morphs");
        $form->setContent($this->main->morphFormContent);
        if($this->main->zombie){
            $form->addButton("Zombie",0,"",0);
        }
        $form->addButton("Remove",0,"",1);
        $form->addButton("§l§8<< Back",0,"",2);
        $form->sendToPlayer($player);
        return $form;
    }

}