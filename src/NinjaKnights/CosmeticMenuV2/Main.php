<?php

namespace NinjaKnights\CosmeticMenuV2;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\player\PlayerInteractEvent;

use jojoe77777\FormAPI\FormAPI;

use NinjaKnights\CosmeticMenuV2\forms\MainForm;
use NinjaKnights\CosmeticMenuV2\forms\GadgetForm;
use NinjaKnights\CosmeticMenuV2\forms\ParticleForm;
use NinjaKnights\CosmeticMenuV2\forms\MorphForm;
use NinjaKnights\CosmeticMenuV2\forms\TrailForm;
use NinjaKnights\CosmeticMenuV2\forms\HatForm;
use NinjaKnights\CosmeticMenuV2\EventListener;

use NinjaKnights\CosmeticMenuV2\cosmetics\Particles\RainCloud;
use NinjaKnights\CosmeticMenuV2\cosmetics\Particles\FlameRings;

class Main extends PluginBase implements Listener {

	private $formapi;
    /**
     * @var Forms
     */
	private $forms;
	private $gadgets;
	private $particles;
	private $morphs;
	private $trails;
	private $hats;

	public $cloudHandlers = [];

    public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->loadPlugins();
		$this->loadClass();
		$this->tasks = [];
	}

	private function loadClass() : void {
		$this->forms = new MainForm($this);
		$this->gadgets = new GadgetForm($this);
		$this->particles = new ParticleForm($this);
		$this->morphs = new MorphForm($this);
		$this->trails = new TrailForm($this);
		$this->hats = new HatForm($this);
    }
	
	private function loadPlugins() : void {
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
	}

	function getMain() : Main {
        return $this;
	}

    /**
     * @return FormAPI
     */
    function getForm() : FormAPI {
        return $this->formapi;
	}
	
	function getForms() : MainForm {
        return $this->forms;
	}
	
	function getGadgets() : GadgetForm {
        return $this->gadgets;
	}
	function getParticles() : ParticleForm {
        return $this->particles;
	}
	function getMorphs() : MorphForm {
        return $this->morphs;
	}
	function getTrails() : TrailForm {
        return $this->trails;
	}
	function getHats() : HatForm {
        return $this->hats;
    }

}