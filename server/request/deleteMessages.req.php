<?php
namespace Request;

use Schema\Messages;

class deleteMessages{
    public function __request($player){
        $msgID = getField("message_ids");
		if(stripos($msgID, ';') !== false)
			$msgIDS = explode(";", $msgID);
		else
			$msgIDS[] = intval($msgID);
		
		Messages::delete(function($q)use($player,$msgIDS){
			$q->where('id','IN',$msgIDS);
			$q->where('character_to_ids','LIKE',"%;{$player->character->id};%");
		});
    }
}