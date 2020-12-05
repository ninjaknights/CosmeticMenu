<?php

namespace NinjaKnights\CosmeticMenu\command;

use NinjaKnights\CosmeticMenu\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

class CosmeticCommand extends PluginCommand
{
    private $plugin;

    public function __construct(Main $main)
    {
        $this->plugin = $main;
        parent::__construct("cosmetic", $main);
        $this->setPermission("cosmeticmenu.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if(count($args) == 0){
            if($this->plugin->cosmeticCommandSupport){
                $this->plugin->getForms()->menuForm($sender);
            }
        }

        return true;
    }
}