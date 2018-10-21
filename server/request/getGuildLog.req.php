<?php
namespace Request;

use Srv\Core;

class getGuildLog{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        $init_request = getField('init_request',FIELD_BOOL)=='true';
		
		if($init_request)
		    $logs = $player->guild->getLogs($player);
	    else{
	        $logs = $player->guild->getLogs($player, $player->ts_before_action);
	        Core::req()->data['new_guild_log_entries'] = count($logs);
	    }
		
		Core::req()->data['guild_log'] = $logs;
    }
}