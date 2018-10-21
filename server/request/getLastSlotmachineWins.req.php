<?php
namespace Request;

use Srv\Core;

class getLastSlotmachineWins{
    public function __request($player){
        Core::req()->data = [
            'messages'=>[
                json_encode([
                    'character_gender'=>'m',
                    'character_level'=>33,
                    'character_name'=>'test',
                    'character_id'=>33,
                    'type'=>405,
                    'value1'=>12323,
                    'timestamp'=>time()
                ])
            ]
        ];
    }
}