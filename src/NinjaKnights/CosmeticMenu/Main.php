<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\inventory\PlayerInventory;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\transaction\action\{SlotChangeAction,DropItemAction};

use pocketmine\utils\Config;

use NinjaKnights\CosmeticMenu\forms\MainForm;
use NinjaKnights\CosmeticMenu\forms\GadgetForm;
use NinjaKnights\CosmeticMenu\forms\ParticleForm;
use NinjaKnights\CosmeticMenu\forms\MorphForm;
use NinjaKnights\CosmeticMenu\forms\TrailForm;
use NinjaKnights\CosmeticMenu\forms\SuitForm;

use NinjaKnights\CosmeticMenu\EventListener;
use NinjaKnights\CosmeticMenu\Cooldown;

use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\GadgetsEvents;
use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\TNTLauncher;

use NinjaKnights\CosmeticMenu\cosmetics\Particles\BlizzardAura;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\BloodHelix;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\BulletHelix;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\ConduitHalo;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\CupidsLove;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\EmeraldTwirl;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\FlameRings;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\RainCloud;
use NinjaKnights\CosmeticMenu\cosmetics\Particles\WitchCurse;

use NinjaKnights\CosmeticMenu\cosmetics\Trails\Flames;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Snow;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Heart;
use NinjaKnights\CosmeticMenu\cosmetics\Trails\Smoke;

use NinjaKnights\CosmeticMenu\cosmetics\Suits\Youtube;
use NinjaKnights\CosmeticMenu\cosmetics\Suits\Frog;

class Main extends PluginBase implements Listener {

	public $world;
    /**
     * @var Forms
     */
	private $forms;
	private $gadgets;
	private $particles;
	private $morphs;
	private $trails;
	private $suits;

	public $tntCooldown = [ ];
	public $tntCooldownTime = [ ];
	public $lsCooldownTime = [ ];
	public $lsCooldown = [ ];
	public $lCooldown = [ ];
	public $lCooldownTime = [ ];

	public $particle1 = array("Rain Cloud");
	public $particle2 = array("Flame Rings");
	public $particle3 = array("Blizzard Aura");
    public $particle4 = array("Cupid's Love");
    public $particle5 = array("Bullet Helix");
    public $particle6 = array("Conduit Halo");
    public $particle7 = array("Witch Curse");
    public $particle8 = array("Blood Helix");
    public $particle9 = array("Emerald Twril");
	public $particle10 = array("Test");
	
	public $trail1 = array("Flame Trail");
	public $trail2 = array("Snow Trail");
	public $trail3 = array("Heart Trail");
	public $trail4 = array("Smoke Trail ");
	
	public $suit1 = array("Suit");
	public $suit2 = array("Suit");

    public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new GadgetsEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new TNTLauncher($this), $this);
		$this->getScheduler()->scheduleRepeatingTask(new BlizzardAura($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new BloodHelix($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new BulletHelix($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new ConduitHalo($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new CupidsLove($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new EmeraldTwirl($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new FlameRings($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new RainCloud($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new WitchCurse($this), 3);

		$this->getScheduler()->scheduleRepeatingTask(new Flames($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new Snow($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new Heart($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new Smoke($this), 3);

		$this->getScheduler()->scheduleRepeatingTask(new Cooldown($this), 20);

		$this->getScheduler()->scheduleRepeatingTask(new Youtube($this), 3);
		$this->getScheduler()->scheduleRepeatingTask(new Frog($this), 3);

		$this->loadPlugins();
		$this->loadFormClass();
		
		$configPath = $this->getDataFolder()."config.yml";
        $this->saveDefaultConfig();
		$this->config = new Config($configPath, Config::YAML);
		$this->config->getAll();
        $version = $this->config->get("Version");
        $this->pluginVersion = $this->getDescription()->getVersion();
        if($version < "2.1"){
            $this->getLogger()->warning("You have updated CosmeticMenu to v".$this->pluginVersion." but have a config from v$version! Please delete your old config for new features to be enabled and to prevent unwanted errors!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }

		if($this->config->getNested("Cosmetic.Enabled")){
			$this->cosmeticItemSupport = true;
			$this->cosmeticName = (str_replace("&", "§", $this->config->getNested("Cosmetic.Name")));
            $this->cosmeticDes = [str_replace("&", "§", $this->config->getNested("Cosmetic.Des"))];
			$this->cosmeticItemType = $this->config->getNested("Cosmetic.Item");
            $this->cosmeticForceSlot = $this->config->getNested("Cosmetic.Force-Slot");
        } else{
            $this->cosmeticItemSupport = false;
            $this->getLogger()->info("The Cosmetic Item is disabled in the config.");
        }

		if($this->config->getNested("Command")){
			$this->cosmeticCommandSupport = true;
		} else {
			$this->cosmeticCommandSupport = false;
            $this->getLogger()->info("The Cosmetic Command is disabled in the config.");
		}
	}

	private function loadFormClass() : void {
		$this->forms = new MainForm($this);
		$this->gadgets = new GadgetForm($this);
		$this->particles = new ParticleForm($this);
		$this->morphs = new MorphForm($this);
		$this->trails = new TrailForm($this);
		$this->suits = new SuitForm($this);
    }
	
	private function loadPlugins() : void {

	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()) {
			case "cosmetics":
				if($sender->hasPermission("cosmetic.cmd")){
					if($this->cosmeticCommandSupport){
						$this->getForms()->menuForm($sender);
					}
				} else {
					$sender->sendMessage("You don't have permission to use this command.");
				}
            break;
        }
        return true;
    }

	function getMain() : Main {
        return $this;
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
	function getSuits() : SuitForm {
        return $this->suits;
    }

}