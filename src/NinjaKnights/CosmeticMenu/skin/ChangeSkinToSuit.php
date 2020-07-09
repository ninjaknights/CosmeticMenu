<?php

namespace NinjaKnights\CosmeticMenu\skin;

use NinjaKnights\CosmeticMenu\Main;
use pocketmine\event\Listener;
use pocketmine\entity\Skin;

class ChangeSkinToSuit implements Listener {

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function setSkin($player, string $pic, string $json, string $geo) {
        $skin = $player->getSkin();
        $path = $this->main->getDataFolder() . $pic . ".png";
        $img = @imagecreatefrompng($path);
        $skinbytes = "";
        $s = (int)@getimagesize($path)[1];

        for($y = 0; $y < $s; $y++) {
            for($x = 0; $x < 64; $x++) {
                $colorat = @imagecolorat($img, $x, $y);
                $a = ((~((int)($colorat >> 24))) << 1) & 0xff;
                $r = ($colorat >> 16) & 0xff;
                $g = ($colorat >> 8) & 0xff;
                $b = $colorat & 0xff;
                $skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }

        @imagedestroy($img);

        $player->setSkin(new Skin($skin->getSkinId(), $skinbytes, "", "geometry." . $geo, file_get_contents($this->main->getDataFolder() . $json . ".json")));
        $player->sendSkin();
    }
}