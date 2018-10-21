<?php
namespace Request;

use Srv\Core;

class unlockGuildDungeonNPCTeamSelection{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('');
        if($player->guild->getDungeon() == null)
            return Core::setError('');
        if(!$player->guild->getDungeon()->checkLockedDungeon($player))
            return Core::setError('');
            
        $player->guild->getDungeon()->unlockDungeon();
        
        Core::req()->data = [];
    }
}