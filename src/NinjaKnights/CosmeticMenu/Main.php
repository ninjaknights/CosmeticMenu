<?php

namespace NinjaKnights\CosmeticMenu;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use NinjaKnights\CosmeticMenu\forms\GadgetForm;
use NinjaKnights\CosmeticMenu\forms\MainForm;
use NinjaKnights\CosmeticMenu\forms\MorphForm;
use NinjaKnights\CosmeticMenu\forms\ParticleForm;
use NinjaKnights\CosmeticMenu\forms\SuitForm;
use NinjaKnights\CosmeticMenu\forms\HatForm;
use NinjaKnights\CosmeticMenu\forms\TrailForm;

use NinjaKnights\CosmeticMenu\EventListener;
use NinjaKnights\CosmeticMenu\Cooldown;
use NinjaKnights\CosmeticMenu\util\saveRes;
use NinjaKnights\CosmeticMenu\skin\setSkin;
use NinjaKnights\CosmeticMenu\skin\saveSkin;
use NinjaKnights\CosmeticMenu\skin\resetSkin;

use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\GadgetsEvents;
use NinjaKnights\CosmeticMenu\cosmetics\Gadgets\TNTLauncher;

use NinjaKnights\CosmeticMenu\cosmetics\Particles\BlizzardAura;
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
	public $particle8 = array("Emerald Twril");

	public $trail1 = array("Flame Trail");
	public $trail2 = array("Snow Trail");
	public $trail3 = array("Heart Trail");
	public $trail4 = array("Smoke Trail ");

	public $suit1 = array("YouTube Suit");
	public $suit2 = array("Frog Suit");

	public $hat1 = array("TV Hat");
	public $hat2 = array("Melon Hat");

	private $setskin;
	private $saveskin;
	private $resetskin;

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this,$this);

		$this->loadEvents();
		$this->loadTasks();
		$this->loadFormClass();
		$this->loadSkinClass();

		$saveRes = new saveRes($this);
		$saveRes->saveRes();

		$configPath = $this->getDataFolder()."config.yml";
		$this->saveDefaultConfig();
		$this->config = new Config($configPath, Config::YAML);
		$this->config->getAll();
		$version = $this->config->get("Version");
		$pluginVersion = $this->getDescription()->getVersion();
		if($version < $pluginVersion){
			$this->getLogger()->warning("You have updated CosmeticMenu to v$pluginVersion but your config is from v$version! Please delete your old config for new features to be enabled and to prevent errors!");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}

		if($this->config->getNested("Cosmetic.Enable")){
			$this->cosmeticItemSupport = true;
			$this->cosmeticName = (str_replace("&", "§", $this->config->getNested("Cosmetic.Name")));
			$this->cosmeticFormContent = (str_replace("&", "§", $this->config->getNested("Cosmetic.Form-Content")));
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

		$gadgetPath = $this->getDataFolder()."gadgets.yml";
		$this->gadgetconfig = new Config($gadgetPath, Config::YAML);
		$this->gadgetconfig->getAll();
		if($this->gadgetconfig->getNested("Gadgets.Enable")){
			$this->gadgetSupport = true;
			$this->gadgetFormContent = $this->gadgetconfig->getNested("Gadgets.Form-Content");
			if($this->tntlauncher = $this->gadgetconfig->getNested("TNT-Launcher.Enable")){
				$this->tntlauncher = true;
			}
			if($this->lightningstick = $this->gadgetconfig->getNested("Lightning-Stick.Enable")){
				$this->lightningstick = true;
			}
			if($this->leaper = $this->gadgetconfig->getNested("Leaper.Enable")){
				$this->leaper = true;
			}
		} else {
			$this->gadgetSupport = false;
		}

		$particlePath = $this->getDataFolder()."particles.yml";
		$this->particleconfig = new Config($particlePath, Config::YAML);
		$this->particleconfig->getAll();
		if($this->particleconfig->getNested("Particles.Enable")){
			$this->particleSupport = true;
			$this->particleFormContent = $this->particleconfig->getNested("Particles.Form-Content");
			if($this->raincloud = $this->particleconfig->getNested("Rain-Cloud.Enable")){
				$this->raincloud = true;
			}
			if($this->flamerings = $this->particleconfig->getNested("Flame-Rings.Enable")){
				$this->flamerings = true;
			}
			if($this->blizzardaura = $this->particleconfig->getNested("Blizzard-Aura.Enable")){
				$this->blizzardaura = true;
			}
			if($this->cupidslove = $this->particleconfig->getNested("Cupids-Love.Enable")){
				$this->cupidslove = true;
			}
			if($this->bullethelix = $this->particleconfig->getNested("Bullet-Helix.Enable")){
				$this->bullethelix = true;
			}
			if($this->conduitaura = $this->particleconfig->getNested("Conduit-Aura.Enable")){
				$this->conduitaura = true;
			}
			if($this->witchcurse = $this->particleconfig->getNested("Witch-Curse.Enable")){
				$this->witchcurse = true;
			}
			if($this->emeraldtwirl = $this->particleconfig->getNested("Emerald-Twirl.Enable")){
				$this->emeraldtwirl = true;
			}
		} else {
			$this->particleSupport = false;
		}

		$suitPath = $this->getDataFolder()."suits.yml";
		$this->suitconfig = new Config($suitPath, Config::YAML);
		$this->suitconfig->getAll();
		if($this->suitconfig->getNested("Suits.Enable")){
			$this->suitSupport = true;
			$this->suitFormContent = $this->suitconfig->getNested("Suits.Form-Content");
			if($this->youtubesuit = $this->suitconfig->getNested("Youtube-Suit.Enable")){
				$this->youtubesuit = true;
			}
			if($this->frogsuit = $this->suitconfig->getNested("Frog-Suit.Enable")){
				$this->frogsuit = true;
			}
		} else {
			$this->suitSupport = false;
		}

		$hatPath = $this->getDataFolder()."hats.yml";
		$this->hatconfig = new Config($hatPath, Config::YAML);
		$this->hatconfig->getAll();
		if($this->hatconfig->getNested("Hats.Enable")){
			$this->hatSupport = true;
			$this->hatFormContent = $this->hatconfig->getNested("Hats.Form-Content");
			if($this->tvhat = $this->hatconfig->getNested("TV-Hat.Enable")){
				$this->tvhat = true;
			}
			if($this->melonhat = $this->hatconfig->getNested("Melon-Hat.Enable")){
				$this->melonhat = true;
			}
		} else {
			$this->hatSupport = false;
		}

		$trailPath = $this->getDataFolder()."trails.yml";
		$this->trailconfig = new Config($trailPath, Config::YAML);
		$this->trailconfig->getAll();
		if($this->trailconfig->getNested("Trails.Enable")){
			$this->trailSupport = true;
			$this->trailFormContent = $this->trailconfig->getNested("Trails.Form-Content");
			if($this->flametrail = $this->trailconfig->getNested("Flame-Trail.Enable")){
				$this->flametrail = true;
			}
			if($this->snowtrail = $this->trailconfig->getNested("Snow-Trail.Enable")){
				$this->snowtrail = true;
			}
			if($this->hearttrail = $this->trailconfig->getNested("Heart-Trail.Enable")){
				$this->hearttrail = true;
			}
			if($this->smoketrail = $this->trailconfig->getNested("Smoke-Trail.Enable")){
				$this->smoketrail = true;
			}

		} else {
			$this->trailSupport = false;
		}

		$morphPath = $this->getDataFolder()."morphs.yml";
		$this->morphconfig = new Config($morphPath, Config::YAML);
		$this->morphconfig->getAll();
		if($this->morphconfig->getNested("Morphs.Enable")){
			$this->morphSupport = true;
			$this->morphFormContent = $this->morphconfig->getNested("Morphs.Form-Content");
			if($this->zombie = $this->morphconfig->getNested("Zombie.Enable")){
				$this->zombie = true;
			}
		} else {
			$this->morphSupport = false;
		}
		
	}

	private function loadFormClass() : void {
		$this->forms = new MainForm($this);
		$this->gadgets = new GadgetForm($this);
		$this->particles = new ParticleForm($this);
		$this->morphs = new MorphForm($this);
		$this->trails = new TrailForm($this);
		$this->suits = new SuitForm($this);
		$this->hats = new HatForm($this);
	}

	private function loadSkinClass() : void {
		$this->setskin = new setSkin($this);
		$this->saveskin = new saveSkin($this);
		$this->resetskin = new resetSkin($this);
	}

	private function loadEvents() : void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new GadgetsEvents($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new TNTLauncher($this), $this);
	}

	private function loadTasks() : void {
		$this->getScheduler()->scheduleRepeatingTask(new BlizzardAura($this), 3);
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

	function getForms() : MainForm {
		return $this->forms;
	}
	function getGadgetForm() : GadgetForm {
		return $this->gadgets;
	}
	function getParticleForm() : ParticleForm {
		return $this->particles;
	}
	function getMorphForm() : MorphForm {
		return $this->morphs;
	}
	function getTrailForm() : TrailForm {
		return $this->trails;
	}
	function getSuitForm() : SuitForm {
		return $this->suits;
	}
	function getHatForm() : HatForm {
		return $this->hats;
	}

	function setSkin(): setSkin {
        return $this->setskin;
	}
	function saveSkin(): saveSkin {
        return $this->saveskin;
	}
	function resetSkin(): resetSkin {
        return $this->resetskin;
	}

}