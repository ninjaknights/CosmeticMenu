<?php

namespace CosmeticMenu;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\particle\InstantEnchantParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\InkParticle;
use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle\SporeParticle;
use pocketmine\level\particle\TerrainParticle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\DestroyBlockParticle;

class Particles extends PluginTask {
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    public function onRun($tick) {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $level = $player->getLevel();
            if (in_array($name, $this->plugin->water)) {
                $particle = new \pocketmine\level\particle\WaterParticle(new Vector3($player->x, $player->y + 2.5, $player->z), 5);
                $level->addParticle($particle);
            }
			elseif (in_array($name, $this->plugin->fire)) {
                $particle = new \pocketmine\level\particle\FlameParticle(new Vector3($player->x, $player->y + 2.5, $player->z));
                $level->addParticle($particle);
            } 
			elseif (in_array($name, $this->plugin->heart)) {
                $particle = new \pocketmine\level\particle\HeartParticle(new Vector3($player->x, $player->y + 2.5, $player->z), 5);
                $level->addParticle($particle);
            }
			elseif (in_array($name, $this->plugin->smoke)) {
                $particle = new \pocketmine\level\particle\HugeExplodeParticle(new Vector3($player->x, $player->y + 2.5, $player->z));
                $level->addParticle($particle);
            }
        }
    }
}
