<?php
namespace Request;

use Srv\Core;
use Schema\Messages;
use Schema\MessageCharacter;

class getMessage{
    public function __request($player){
        $msgid = intval(getField('message_id', FIELD_NUM));
        
        if($msgid<=0)
            return Core::setError('');
        
        $msg = Messages::find(function($q)use($msgid){ $q->where('id',$msgid); });
        
        if($msg->character_from_id != $player->character->id)
            $msg->readed = true;
        
        Core::req()->data = array(
			"user" => [],
			"character" => [],
			"message" => $msg
		);
    }
}