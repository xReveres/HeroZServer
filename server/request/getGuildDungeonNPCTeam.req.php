<?php
namespace Request;

use Srv\Core;

class getGuildDungeonNPCTeam{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('');
        if($player->character->guild_rank == 3)
            return Core::setError('');
        if($player->guild->getPendingDungeon())
            return Core::setError('');
        
        $dungeon = $player->guild->getDungeon();
        
        $lockingCharName = $dungeon->lockDungeon($player);
        if($lockingCharName !== true)
            return Core::setError("errGetGuildDungeonNPCTeamAlreadyLocked_{$lockingCharName}");
        
        Core::req()->data = [
            'guild_dungeon_battle'=>$player->guild->getDungeon()->getBattle()
        ];
    }
}