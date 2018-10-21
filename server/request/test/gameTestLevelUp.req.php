<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class gameTestLevelUp{
    
    public function __request($player){
        $lvl = $player->getLVL()+1;
        $player->setExp(Config::get("constants.levels.$lvl.xp"));
        
        Core::req()->data = array(
            'user'=>[],
            'character'=>$player->character
        );
    }
    
}