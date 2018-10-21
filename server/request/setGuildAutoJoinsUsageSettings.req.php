<?php
namespace Request;

use Srv\Core;

class setGuildAutoJoinsUsageSettings{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errNoPermission');
            
        $attack = getField('attack', FIELD_BOOL)=="true";
        $dungeon = getField('dungeon', FIELD_BOOL)=="true";
        $defense = getField('defense', FIELD_BOOL)=="true";
        
        $player->guild->use_auto_joins_attack = $attack;
        $player->guild->use_auto_joins_dungeon = $dungeon;
        $player->guild->use_auto_joins_defense = $defense;
        
        Core::req()->data = array(
            'character'=>array(),
            'guild'=>$player->guild
        );
    }
}