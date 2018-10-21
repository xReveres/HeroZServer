<?php
namespace Request;

use Srv\Core;
use Schema\Messages;
use Schema\MessageCharacter;

class sendMessage{
    public function __request($player){
        $targetName = getField('to', FIELD_ALNUM);
        $subject = getField('subject');
        $message = getField('message');
        
        $subject = Core::validMSG($subject, "[***]");
        $message = Core::validMSG($message, "[***]");
        
        $subject = trim(preg_replace("/[^a-zA-Z0-9 ]+/", "", $subject));
        $message = trim($message);

        if(strlen($subject) == 0 || strlen($message) == 0)
			return Core::setError('');
		
		if(is_numeric($targetName))
			return Core::setError("errSendMessageInvalidRecipient");
		
		$target = MessageCharacter::find(function($q)use($targetName){ $q->where('name',$targetName); });
		if(!$target)
			return Core::setError("errSendMessageInvalidRecipient_{$targetName}");
		
		if($target->id == $player->character->id)
			return Core::setError("errCreatePersonalMessageSelfRecipient");
		
		$msg = new Messages([
			'character_from_id'=>$player->character->id,
			'character_to_ids'=>";{$target->id};",
			'subject'=>$subject,
			'message'=>$message,
			'ts_creation'=>time()
		]);
		$msg->save();
		
		Core::req()->data = array(
		    'character'=>[],
			"message" => $msg,
			"messages_character_info" => $target
		);
    }
}