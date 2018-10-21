<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class SlotMachines extends Record implements JsonSerializable{
    protected static $_TABLE = 'slotmachines';
    
    public function jsonSerialize() {
        $data = $this->getData();
        array_unset($data, ['id','character_id','timestamp']);
        return $data;
    }
    
    protected static $_FIELDS = [
        'id'=>0,
        'character_id'=>0,
        'slotmachine_reward_quality'=>0,
        'slotmachine_slot1'=>0,
        'slotmachine_slot2'=>0,
        'slotmachine_slot3'=>0,
        'reward'=>'',
        'timestamp'=>0
    ];
}