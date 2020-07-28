<?php

namespace NinjaKnights\CosmeticMenu\util;

use NinjaKnights\CosmeticMenu\Main;
use pocketmine\utils\Config;

class saveRes
{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function saveRes(){
        //
		foreach(["steve.png", "steve.json", "particles.yml", "gadgets.yml", "suits.yml", "hats.yml", "trails.yml", "morphs.yml"] as $file) {
			$this->main->saveResource($file);
        }
        
        //suits
        foreach(["youtube", "frog"] as $suits) {
            $this->main->saveResource("skins/suits/". $suits . ".png");
            $this->main->saveResource("skins/suits/". $suits . ".json");
        }
        
        //hats
        foreach(["tv", "melon"] as $hats) {
            $this->main->saveResource("skins/hats/". $hats . ".png");
            $this->main->saveResource("skins/hats/". $hats . ".json");
		}
    }
    
}