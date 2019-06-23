<?php

namespace tim03we\simplemsg;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use tim03we\simplemsg\Listener\ChatListener;
use pocketmine\Server;
use tim03we\simplemsg\commands\TellCommand;
use tim03we\simplemsg\commands\ReplyCommand;

class Main extends PluginBase implements Listener {

    public $last = [];

    public function onEnable()
    {
        $this->saveResource("settings.yml");
        Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("tell"));
        $this->getServer()->getCommandMap()->register("tell", new TellCommand($this));
<<<<<<< HEAD
        $this->getServer()->getCommandMap()->register("reply", new ReplyCommand($this));
=======
        $this->getServer()->getCommandMap()->register("tell", new ReplyCommand($this));
>>>>>>> 9f9fda7ab9f555e21ceb85f41d08e2725b0d4dec
        $this->getLogger()->info("Plugin was enabled!");
    }

    public function onDisable()
    {
        $this->getLogger()->info("Plugin was disabled!");
    }

    /*public function onJoin(PlayerJoinEvent $event)
    {
        $this->last[$event->getPlayer()->getName()] = null;
    }*/
}