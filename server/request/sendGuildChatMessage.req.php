<?php
namespace Request;

use Srv\Core;
use Schema\Character;

class sendGuildChatMessage{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
            
        $message = getField('message');
        $message = Core::validMSG($message);
        $officer_message = getField("officer_message")=='true';
        $toCharacterName = getField('character_to_name',0,FALSE);
        
        $toCharacter = false;
        if($toCharacterName && strlen($toCharacterName) > 0)
        	$toCharacter = Character::find(function($q)use($toCharacterName){ $q->where('name',$toCharacterName); })->id;
        
		$player->guild->sendMessage($player, $message, $officer_message, $toCharacter);
        
        Core::req()->data = array();
    }
}