<?php
namespace Request;

use Srv\Core;

class setTutorialFlags{
    
    public function __request($player){
        $flag = getField('flag');
        if(!$flag)
            return;
        
        $player->setTutorialFlag($flag);
        
        Core::req()->data = [
            'user'=>[],
            'character'=>$player->character
        ];
    }
}