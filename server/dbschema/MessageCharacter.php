<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class MessageCharacter extends Record implements JsonSerializable{
    protected static $_TABLE = 'character';
    
    public $online_status = 2; //1-Online 2-Offline
    
    public static function getFromList($messages){
        $character_ids = [];
        foreach($messages as $msg){
            $character_ids[] = $msg->character_from_id;
            $character_ids = array_merge($character_ids, explode(';', $msg->character_to_ids));
        }
        if(empty($character_ids))
            return [];
        $character_ids = array_unique($character_ids);
        $character_ids = array_filter($character_ids, function($a){ return $a; });
        $character_ids = array_slice($character_ids, 0);
        if(empty($character_ids))
            return [];
        $characters = [];
        $chs = static::findAll(function($q)use($character_ids){ $q->where('id','IN',$character_ids); });
        foreach($chs as $ch)
            $characters[$ch->id] = $ch;
        return $characters;
    }
    
    public function afterLoad(){
        $this->online_status = time() < $this->ts_last_action + 60? 1 : 2;
    }
    
    public function jsonSerialize(){
        return array_merge($this->getData(), get_public_vars($this));
    }
    
    protected static $_FIELDS = [
        'id'=>0,
        'name'=>'',
        'gender'=>'-',
        'ts_last_action'=>0
    ];
}