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

class saveSkin
{

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public $acceptedSkinSize = [
        64 * 32 * 4,
        64 * 64 * 4,
        128 * 128 * 4
    ];
    public $skin_widght_map = [
        64 * 32 * 4 => 64,
        64 * 64 * 4 => 64,
        128 * 128 * 4 => 128
    ];

    public $skin_height_map = [
        64 * 32 * 4 => 32,
        64 * 64 * 4 => 64,
        128 * 128 * 4 => 128
    ];

    public function saveSkin(Skin $skin, $name)
    {
        $path = $this->main->getDataFolder();
        if (!file_exists($path . "saveskin")) {
            mkdir($path . "saveskin", 0777);
        }
        $img = $this->skinDataToImage($skin->getSkinData());
        if ($img == null) {
            return;
        }
        imagepng($img, $path . "saveskin/" . $name . ".png");
    }

    public function skinDataToImage($skinData)
    {
        $size = strlen($skinData);
        if (!$this->validateSize((int)$size)) {
            $this->main->getServer()->broadcastMessage("An error occur on Clothes plugin, id: 1");
            return null;
        }
        $width = $this->skin_widght_map[$size];
        $height = $this->skin_height_map[$size];
        $skinPos = 0;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            $this->main->getServer()->broadcastMessage("An error occur on Clothes plugin,id: 2");
            return null;
        }

        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $r = ord($skinData[$skinPos]);
                $skinPos++;
                $g = ord($skinData[$skinPos]);
                $skinPos++;
                $b = ord($skinData[$skinPos]);
                $skinPos++;
                $a = 127 - intdiv(ord($skinData[$skinPos]), 2);
                $skinPos++;
                $col = imagecolorallocatealpha($image, $r, $g, $b, $a);
                imagesetpixel($image, $x, $y, $col);
            }
        }
        imagesavealpha($image, true);
        return $image;
    }

    public function validateSize(int $size)
    {
        if (!in_array($size, $this->acceptedSkinSize)) {
            return false;
        }
        return true;
    }
}