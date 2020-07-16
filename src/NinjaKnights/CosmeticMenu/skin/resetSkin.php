<?php
/*
*
* Taken from https://github.com/TungstenVn/Clothes
* Thanks to Tungsten plugin that I could make these cool things
* All rights to him
*
*/
namespace NinjaKnights\CosmeticMenu\skin;

use pocketmine\entity\Skin;
use pocketmine\Player;
use NinjaKnights\CosmeticMenu\Main;

class resetSkin
{

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function setSkin(Player $player)
    {
        $skin = $player->getSkin();
        $name = $player->getName();
        $path = $this->main->getDataFolder() . "saveskin/" . $name . ".png";
        if(!file_exists($path)){
            $path = $this->main->getDataFolder()."steve.png";
        }
        $img = @imagecreatefrompng($path);
        $size = getimagesize($path);
        $skinbytes = "";
        for ($y = 0; $y < $size[1]; $y++) {
            for ($x = 0; $x < $size[0]; $x++) {
                $colorat = @imagecolorat($img, $x, $y);
                $a = ((~((int)($colorat >> 24))) << 1) & 0xff;
                $r = ($colorat >> 16) & 0xff;
                $g = ($colorat >> 8) & 0xff;
                $b = $colorat & 0xff;
                $skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($img);
        $player->setSkin(new Skin($skin->getSkinId(), $skinbytes, "", "geometry.humanoid.custom", file_get_contents($this->main->getDataFolder() . "steve.json")));
        $player->sendSkin();
    }
}