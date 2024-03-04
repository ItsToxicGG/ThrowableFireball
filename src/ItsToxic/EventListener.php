<?php

namespace ItsToxic;

use ItsToxic\entity\Fireball;
use pocketmine\entity\Location;
use pocketmine\entity\projectile\Snowball;
use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\block\BlockTypeIds;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\ItemTypeIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\block\Block;
use pocketmine\world\sound\BlazeShootSound;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\world\World;

class EventListener implements Listener {


    /**
     * On use item
     */
    public function onItemUse(PlayerItemUseEvent $event){
        $item = $event->getItem();
        $player = $event->getPlayer();
        switch ($item->getTypeId()){
            case ItemTypeIds::FIRE_CHARGE:
                $this->spawnFireball($player->getLocation()->add(0, $player->getEyeHeight(), 0), $player);
                $player->getWorld()->addSound($player->getLocation(), new BlazeShootSound());
                $item->setCount($item->getCount() - 1);
                $player->getInventory()->setItemInHand($item);
            break;
        }
    }

    /**
     * Summon fireball
     */
    public function spawnFireball(Vector3 $pos, Player $player){
        $location = Location::fromObject($pos, $player->getWorld(), ($player->getLocation()->getYaw() > 180 ? 360 : 0) - $player->getLocation()->getYaw(), -$player->getLocation()->getPitch());
        $fireball = new Fireball($location, $player);
        $fireball->setMotion($player->getDirectionVector()->normalize()->multiply(2.0));
        $fireball->spawnToAll();
    }

}