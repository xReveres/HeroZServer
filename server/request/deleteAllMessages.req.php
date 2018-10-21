<?php
namespace Request;

use Schema\Messages;

class deleteAllMessages{
    public function __request($player){
        Messages::delete(function($q)use($player){
            $q->where('character_to_ids','LIKE',"%;{$player->character->id};%");
        });
    }
}