<?php

namespace tim03we\simplemsg;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use tim03we\simplemsg\Listener\ChatListener;
use pocketmine\Server;
use tim03we\simplemsg\commands\TellCommand;

class Main extends PluginBase implements Listener {

    public function onEnable()
    {
        $this->saveResource("settings.yml");
        Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getCommandMap()->register("tell", new TellCommand($this));
        $this->getLogger()->info("Plugin was enabled!");
    }

    public function onDisable()
    {
        $this->getLogger()->info("Plugin was disabled!");
    }
}