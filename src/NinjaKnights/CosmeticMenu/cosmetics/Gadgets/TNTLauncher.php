<?php 

namespace NinjaKnights\CosmeticMenu\cosmetics\Gadgets;

use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\entity\PrimedTNT;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;

use NinjaKnights\CosmeticMenu\Main;

class TNTLauncher implements Listener {

	private $main;

    public function __construct(Main $main) {
		  $this->main = $main;
    }

	public function ExplosionPrimeEvent(ExplosionPrimeEvent $event){
		$event->setBlockBreaking(false);
	}

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
		$name = $player->getName();
		$iname = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();//Item Name
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));

        //TNT-Launcher
		if($iname == "TNT-Launcher"){
			if($player->hasPermission("cosmetic.gadgets.tntlauncher")) {
				if(!isset($this->main->tntCooldown[$player->getName()])){
					$nbt = new CompoundTag("", [
						"Pos" => new ListTag("Pos", [
							new DoubleTag("", $player->x),
							new DoubleTag("", $player->y + $player->getEyeHeight()),
							new DoubleTag("", $player->z)
						]),
						"Motion" => new ListTag("Motion", [
							new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
							new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
							new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
						]),
						"Rotation" => new ListTag("Rotation", [
							new FloatTag("", $player->yaw),
							new FloatTag("", $player->pitch)
						]),
					]);
					$tnt = Entity::createEntity("PrimedTNT", $player->getLevel(), $nbt, null);
					$tnt->setMotion($tnt->getMotion()->multiply(2));
					$tnt->spawnTo($player);
					$this->main->tntCooldown[$player->getName()] = $player->getName();
					$time = $this->main->config->getNested("Cooldown.TnT-Launcher");
					$this->main->tntCooldownTime[$player->getName()] = $time;
				} else {
					$player->sendPopup("§cYou can't use the TNT-Launcher for another ".$this->main->tntCooldownTime[$player->getName()]." seconds.");
				}
            } else {
				$player->sendMessage("You don't have permission to use TNT-Launcher!");
			}
        }
    }

    function getMain() : Main {
        return $this->main;
    }

}