<?php
namespace Request;

use Srv\Core;

class setCharacterAppearanceFlag{
    
    public function __request($player){
        $flag = getField('flag');
        $value = getField('value', FIELD_BOOL)=='true'?true:false;
        
        if($flag != 'show_mask')
            Core::setError('');
            
        $player->character->{$flag} = $value;
        
        Core::req()->data = array(
            'user'=>[],
            'character'=>$player->character
        );
    }
}