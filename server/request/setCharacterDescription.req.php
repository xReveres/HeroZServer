<?php
namespace Request;

use Srv\Core;

class setCharacterDescription{
    
    public function __request($player){
        $desc = getField('description');
        $note = getField('note');
        
        $desc = Core::validMSG($desc, "[***]", true);
        $note = core::validMSG($note, "[***]", true);
            
        $player->character->description = $desc;
        $player->character->note = $note;
        
        Core::req()->data = array(
            'user'=>[],
            'character'=>$player->character
        );
    }
}