<?php

namespace ItsToxic;

use ItsToxic\entity\Fireball;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\world\World;

class ThrowableFireball extends PluginBase implements Listener {

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$entityFactory = EntityFactory::getInstance();

		$entityFactory->register(Fireball::class, function(World $world, CompoundTag $nbt) :Fireball{
			return new Fireball(EntityDataHelper::parseLocation($nbt, $world), null);
		}, ['Fireball']);
    }
}