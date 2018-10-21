<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class GuildMessages extends Record implements JsonSerializable{
    protected static $_TABLE = 'guild_messages';
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'guild_id' => 0,
        'character_from_id' => 0,
        'character_from_name' => '' ,
        'character_to_id' => 0,
        'is_officer' => 0,
        'is_private' => 0,
        'message' => '' ,
        'timestamp' => 0
    ];
}