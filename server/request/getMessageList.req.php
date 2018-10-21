<?php
namespace Request;

use Srv\Core;
use Schema\Messages;
use Schema\MessageCharacter;

class getMessageList{
    
    public function __request($player){
    	$load_received = getField('load_received', FIELD_BOOL)=='true';
    	$load_sent = getField('load_sent', FIELD_BOOL)=='true';
    	if($load_received)
        	$messages = Messages::findAll(function($q) use($player){ $q->where('character_to_ids','LIKE',"%;{$player->character->id};%"); });
        else if($load_sent)
        	$messages = Messages::findAll(function($q) use($player){ $q->where('character_from_id',$player->character->id)->where('flag',''); });
        
        $charinfo = MessageCharacter::getFromList($messages);
        
        $readed = [];
		foreach($messages as &$msg){
			if($msg->readed)
				$readed[] = $msg->id;
			unset($msg->message);
		}
		
		Core::req()->data = array(
			"character" => $player->character,
			"messages" => $messages,
			"messages_character_info" => $charinfo,
			"messages_ignored_character_info" => array(),
			"messages_read" => $readed
		);
		if($load_received){
			Core::req()->data['new_messages'] = (count($messages) - count($readed));
			Core::req()->data['messages_received_count'] = count($messages);
		}
		if($load_sent)
			Core::req()->data['messages_sent_count'] = count($messages);
    }
}