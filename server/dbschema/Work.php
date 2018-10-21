<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Work extends Record  implements JsonSerializable{
    protected static $_TABLE = 'work';
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'work_offer_id' => 'work1',
        'status' => 1,
        'duration' => 0,
        'ts_complete' => 0,
        'rewards' => '',
    ];
}