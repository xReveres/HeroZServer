<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Messages extends Record implements JsonSerializable {
    protected static $_TABLE = 'messages';
    
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_from_id' => 0,
        'character_to_ids' => '' ,
        'subject' => '' ,
        'message' => '' ,
        'flag' => '' ,
        'flag_value' => '' ,
        'ts_creation' => 0,
        'readed' => false
    ];
}