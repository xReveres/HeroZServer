<?php
namespace Request;

use Srv\Core;

class setGuildAcceptMembers{
    
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank != 1)
            return Core::setError('errPermission');
        
        $val = getField('value', FIELD_BOOL)=='true';
        $player->guild->accept_members = $val;
        
        Core::req()->data = array(
            'character'=>[],
            'guild'=>$player->guild
        );
        
    }
}