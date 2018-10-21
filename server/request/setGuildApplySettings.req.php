<?php
namespace Request;

use Srv\Core;

class setGuildApplySettings{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        
        $min_lvl = intval(getField('level', FIELD_NUM));
        $min_honor = intval(getField('honor', FIELD_NUM));
        
        if($min_lvl < 0 || $min_honor < 0)
            return Core::setError('');
            
        $player->guild->min_apply_level = $min_lvl;
        $player->guild->min_apply_honor = $min_honor;
        
        Core::req()->data = array(
            'character'=>[],
            'guild'=>$player->guild
        );
    }
}