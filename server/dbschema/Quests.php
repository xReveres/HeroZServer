<?php
namespace Schema;

use Srv\Record;
use Cls\Utils;
use JsonSerializable;

class Quests extends Record implements JsonSerializable{
    protected static $_TABLE = 'quests';

    public static function rewards($coins=0, $xp=0, $honor=0, $premium=0, $statPoints=0, $item=0){
        return Utils::rewards($coins, $xp, $honor, $premium, $statPoints, $item);
    }
    
    public function haveItem(){
        return json_decode($this->rewards)['item'] > 0;
    }
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    /*public function remove(){
        //if($this->haveItem())
            //TODO: usuwanie itemow
    }*/

    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'identifier' => '',
        'type' => 1,
        'stage' => 1,
        'level' => 1,
        'status' => 1,
        'duration_type' => 1,
        'duration_raw' => 0,
        'duration' => 0,
        'ts_complete' => 0,
        'energy_cost' => 0,
        'fight_difficulty' => 0,
        'fight_npc_identifier' => '',
        'fight_battle_id' => 0,
        'used_resources' => 0,
        'rewards' => '',
    ];
}