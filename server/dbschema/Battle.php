<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Battle extends Record implements JsonSerializable{
    protected static $_TABLE = 'battle';
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'ts_creation' => 0,
        'profile_a_stats' => '',
        'profile_b_stats' => '',
        'winner' => '',
        'rounds' => '',
    ];
}