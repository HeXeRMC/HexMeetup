<?php

namespace Hex;

use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $world = $this->getConfig()->get("World");
        $this->getServer()->loadLevel("$world");
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args) : bool{
		switch($cmd->getName()){
                case "meetup":
                    if($sender instanceof Player){
        
         $world = $this->getConfig()->get("World");
         $bcmsg = $this->getConfig()->get("BroadcastMsg");
         $level = $sender->getServer()->getLevelByName($world);
         $this->targetLevel = $level;
         $this->getServer()->broadcastMessage("§e" . $sender->getName() . " " . $bcmsg);
         $sender->teleport($this->targetLevel->getSpawnLocation());
          }
					break;
       }
		return true;
    }

    /**
     * @param EntityLevelChangeEvent $event
     * @priority MONITOR
     */
     # @hexyy plugin edit credits
    public function onLevelChange(EntityLevelChangeEvent $event): void {
        $world = $this->getConfig()->get("World");
        if(in_array($event->getTarget()->getFolderName(), [$world])) {
            $player = $event->getEntity();
            $joinmsg = $this->getConfig()->get("PlayerJoinMsg");
            $joinsubtitle = $this->getConfig()->get("JoinSubtitle");
            $jointitle = $this->getConfig()->get("JoinTitle");
            if($player instanceof Player) {
                $player->getInventory()->clearAll();
                $player->getArmorInventory()->clearAll();
                $player->getCursorInventory()->clearAll();
                $player->setHealth(20);
                $player->removeAllEffects();

                $inv = $player->getArmorInventory();
                $inv->setHelmet(ItemFactory::get(Item::DIAMOND_HELMET));
                $inv->setChestplate(ItemFactory::get(Item::DIAMOND_CHESTPLATE));
                $inv->setLeggings(ItemFactory::get(Item::DIAMOND_LEGGINGS));
                $inv->setBoots(ItemFactory::get(Item::DIAMOND_BOOTS));

                $player->getInventory()->addItem(ItemFactory::get(Item::DIAMOND_SWORD));
                $player->getInventory()->addItem(ItemFactory::get(Item::GOLDEN_APPLE, 0, 16));
				$player->getInventory()->addItem(ItemFactory::get(332, 0, 16));
				$player->getInventory()->addItem(ItemFactory::get(279, 0, 1));
				$player->getInventory()->addItem(ItemFactory::get(278, 0, 1));
				$player->getInventory()->addItem(ItemFactory::get(30, 0, 16));
				$player->getInventory()->addItem(ItemFactory::get(4, 0, 64));
				$player->getInventory()->addItem(ItemFactory::get(5, 0, 64));
				$player->sendMessage($joinmsg);
				$player->sendPopup("$joinsubtitle");
				$player->addTitle($jointitle);

            }
        }
    }
}
