<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class GuildLogs extends Record implements JsonSerializable{
    protected static $_TABLE = 'guild_logs';
    
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'guild_id' => 0,
        'character_id' => 0,
        'character_name' => '',
        'type' => 0,
        'value1' => '',
        'value2' => '',
        'value3' => '',
        'timestamp' => 0,
    ];
}