<?php 

namespace NinjaKnights\CosmeticMenuV2\forms;
    
use NinjaKnights\CosmeticMenuV2\Main;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Location;

use NinjaKnights\CosmeticMenuV2\cosmetics\Particles\RainCloud;
    
class ParticleForm {
    
    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

     public function openParticles($player) {
        $form = $this->getMain()->getForm()->createSimpleForm(function (Player $player, $data) {
        $result = $data;
            if($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if($player->hasPermission("cosmetic.particles.raincloud")){
                        
                    } 
                break;

                case 1:
                    if($player->hasPermission("cosmetic.particles.flamingring")){
                        
                    }
                break;

                case 2:
                    if($player->hasPermission("cosmetic.particles.snowaura")){
                        
                    }
                break;

                case 3:
                    if($player->hasPermission("cosmetic.particles.cupidslove")){
                        
                    }
                break;

                case 4:
                    if($player->hasPermission("cosmetic.particles.bullethelix")){
                       
                    }
                break;

                case 5:
                    if($player->hasPermission("cosmetic.particles.test")){
                        
                    }
                break;

                case 6:
                    if($player->hasPermission("cosmetic.particles.test")){
                        
                    }
                break;

                case 7:
                    if($player->hasPermission("cosmetic.particles.test")){
                       
                    }
                break;

                case 8:
                    if($player->hasPermission("cosmetic.particles.test")){
                        
                    }
                break;

                case 9:
                    if($player->hasPermission("cosmetic.particles.test")){
                       
                    }
                break;

                case 10:
                   
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
        $form->addButton("Blood Helix");
        $form->addButton("Emerald Twirl");
        $form->addButton("Test");
        $form->addButton("Clear");
        $form->addButton("§l§8<< Back");
        $form->sendToPlayer($player);
        return $form;
    }

    function getMain() : Main {
        return $this->main;
    }

}