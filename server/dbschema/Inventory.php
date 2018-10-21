<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class Inventory extends Record implements JsonSerializable{
    protected static $_TABLE = 'inventory';
    
    
    public function getSlotByItemId($id){
        $id = intval($id);
		foreach($this->getData() as $iKey => $iVal){
			if($iKey == "id" || $iKey == "character_id")
				continue;
			if($iVal == $id)
				return $iKey;
		}
		return null;
    }
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'mask_item_id' => 0,
        'cape_item_id' => 0,
        'suit_item_id' => 0,
        'belt_item_id' => 0,
        'boots_item_id' => 0,
        'weapon_item_id' => 0,
        'gadget_item_id' => 0,
        'missiles_item_id' => 0,
        'missiles1_item_id' => -1,
        'missiles2_item_id' => -1,
        'missiles3_item_id' => -1,
        'missiles4_item_id' => -1,
        'sidekick_id' => 0,
        'bag_item1_id' => 0,
        'bag_item2_id' => 0,
        'bag_item3_id' => 0,
        'bag_item4_id' => 0,
        'bag_item5_id' => 0,
        'bag_item6_id' => 0,
        'bag_item7_id' => 0,
        'bag_item8_id' => 0,
        'bag_item9_id' => 0,
        'bag_item10_id' => 0,
        'bag_item11_id' => 0,
        'bag_item12_id' => 0,
        'bag_item13_id' => 0,
        'bag_item14_id' => 0,
        'bag_item15_id' => 0,
        'bag_item16_id' => 0,
        'bag_item17_id' => 0,
        'bag_item18_id' => 0,
        'shop_item1_id' => 0,
        'shop_item2_id' => 0,
        'shop_item3_id' => 0,
        'shop_item4_id' => 0,
        'shop_item5_id' => 0,
        'shop_item6_id' => 0,
        'shop_item7_id' => 0,
        'shop_item8_id' => 0,
        'shop_item9_id' => 0,
        'shop2_item1_id' => 0,
        'shop2_item2_id' => 0,
        'shop2_item3_id' => 0,
        'shop2_item4_id' => 0,
        'shop2_item5_id' => 0,
        'shop2_item6_id' => 0,
        'shop2_item7_id' => 0,
        'shop2_item8_id' => 0,
        'shop2_item9_id' => 0,
        'item_set_data' => '' ,
        'sidekick_data' => ''
    ];
}