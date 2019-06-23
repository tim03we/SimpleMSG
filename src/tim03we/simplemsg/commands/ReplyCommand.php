<?php

namespace tim03we\simplemsg\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use tim03we\simplemsg\Main;

class ReplyCommand extends Command
{

    public function __construct(Main $plugin)
    {
        parent::__construct("reply", "Reply the last Private Message", "/reply <message>", ["r"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return false;
        }
        if(!$sender instanceof Player) {
            return $sender->sendMessage("Run this command InGame!");
        }
        if(empty($args[0])) {
            $sender->sendMessage($this->getUsage());
            return true;
        }
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $name = strtolower($args[0]);
        $sName = $sender->getName();
        if(empty($this->plugin->last[$sender->getName()])) {
            return $sender->sendMessage($settings->get("No-Reply"));
        }
        if (Server::getInstance()->getPlayer($this->plugin->last[$sender->getName()]) == null) {
            $sender->sendMessage($settings->get("NotFound"));
        } else {
            $player = Server::getInstance()->getPlayer($this->plugin->last[$sender->getName()])->getName();
            $msg = implode(" ", $args);
            $sender->sendMessage($this->convert($settings->get("Message"), $player, $sName, $msg));
            Server::getInstance()->getPlayer($this->plugin->last[$sender->getName()])->sendMessage($this->convert($settings->get("Message"), $player, $sName, $msg));
        }
        return false;
    }


    public function convert(string $string, $player, $sName, $msg): string
    {
        $string = str_replace("{from}", $sName, $string);
        $string = str_replace("{to}", $player, $string);
        $string = str_replace("{msg}", $msg, $string);
        return $string;
    }
}