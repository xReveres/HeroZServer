<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Duel extends Record implements JsonSerializable{
    protected static $_TABLE = 'duel';
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'battle_id' => 0,
        'ts_creation' => 0,
        'character_a_id' => 0,
        'character_b_id' => 0,
        'character_a_status' => 1,
        'character_b_status' => 1,
        'character_a_rewards' => '',
        'character_b_rewards' => '',
    ];
}