<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Training extends Record implements JsonSerializable{
    
    protected static $_TABLE = 'training';
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'status' => 1,
        'stat_type' => 0,
        'ts_creation' => 0,
        'ts_complete' => 0,
        'iterations' => 0,
        'used_resources' => 0
    ];
}