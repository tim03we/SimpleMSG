<?php

namespace tim03we\simplemsg\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use tim03we\simplemsg\Main;

class TellCommand extends Command
{

    public function __construct(Main $plugin)
    {
        parent::__construct("tell", "Send a Private Message", "/tell <player> <message>", ["msg", "whisper", "w"]);
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
        } else if (empty($args[1])) {
            $sender->sendMessage($this->getUsage());
            return true;
        }
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $name = strtolower($args[0]);
        $sName = $sender->getName();
        if (Server::getInstance()->getPlayer($name) == null) {
            $sender->sendMessage($settings->get("NotFound"));
        } else {
            $player = Server::getInstance()->getPlayer($name)->getName();
            unset($args[0]);
            $msg = implode(" ", $args);
            $sender->sendMessage($this->convert($settings->get("Message"), $player, $sName, $msg));
            Server::getInstance()->getPlayer($name)->sendMessage($this->convert($settings->get("Message"), $player, $sName, $msg));
            $this->plugin->last[$sender->getName()] = Server::getInstance()->getPlayer($name)->getName();
            $this->plugin->last[Server::getInstance()->getPlayer($name)->getName()] = $sender->getName();
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