<?php
namespace Request;

use Srv\Core;
use Cls\Guild;

class getGuild{
    public function __request($player){
        $guild_id = intval(getField('guild_id',FIELD_NUM));
        
        $guild = Guild::find(function($q)use($guild_id){ $q->where('id',$guild_id); });
        
        if(!$guild)
            return Core::setError('errNoSuchGuild');
        
        Core::req()->data = array(
            "requested_guild" => $guild,
            "requested_guild_members" => $guild->getMembers()
        );
    }
}