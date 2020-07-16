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
        foreach(["skins/suits/youtube.json", "skins/suits/youtube.png"] as $suits) {
			$this->main->saveResource($suits);
        }
        
        //hats
        foreach(["skins/hats/tv.json", "skins/hats/tv.png"] as $hats) {
			$this->main->saveResource($hats);
		}
    }
    
}