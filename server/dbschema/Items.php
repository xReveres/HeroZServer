<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;
use Srv\Config;

class Items extends Record implements JsonSerializable{
    protected static $_TABLE = 'items';
    
    
    public function getMissileDamage(){
        $_loc2_ = Config::get("constants.item_missile_damage_factor");
        return round($_loc2_ * $this->item_level);
    }
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'identifier' => '',
        'type' => 0,
        'quality' => 0,
        'required_level' => 0,
        'charges' => 0,
        'item_level' => 0,
        'ts_availability_start' => 0,
        'ts_availability_end' => 0,
        'premium_item' => false,
        'buy_price' => 0,
        'sell_price' => 0,
        'stat_stamina' => 0,
        'stat_strength' => 0,
        'stat_critical_rating' => 0,
        'stat_dodge_rating' => 0,
        'stat_weapon_damage' => 0,
    ];
}