<?php

namespace MaxIDStarkTeam\MagicTouchStick;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\{Command, CommandSender};
use pocketmine\item\Item;
use ppcketmine\block\Block;
use pocketmine\inventory\Inventory;
use pocketmine\event\player\PlayerInteractEvent;

class Loader extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("MagicTouchStickStick Enabled");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		switch($cmd->getName()){
			case "mstick":
			if($sender instanceof Player){
				if($sender->hasPermission("magic.stick")){
					$item = Item::get(Item::STICK)->setCustomName("§eMagic Stick")->setLore(['Touch Block to get that Block', 'Give Stick (OP Only) use /mstick']);
					$sender->getInventory()->addItem($item);
					$sender->sendMessage("§a Magic Stuck has been added successfully! ");
				} else {
					$sender->sendMessage("§cYou don't have permission to use this Command!");
					return true;
				}
			} else {
				$sender->sendMessage("Use This Command In-Game!");
                                return true;
			}
			break;
		}
		return true;
	}
	
	public function onTouch(PlayerInteractEvent $ev){
		$sender = $ev->getPlayer();
		$item = $ev->getItem();
		if($item->getId() === 280 && $item->getCustomName() === "§eMagic Stick" && $ev->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK && $sender->isOp()){
		 $block = $ev->getBlock();
		 $id = $block->getId();
		 $damage = $block->getDamage();
		 $sender->getInventory()->addItem(Item::get($id, $damage, 64));
		}
	}
}
