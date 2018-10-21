<?php
namespace Request;

use Srv\Core;

class sellInventoryItem{
    
    public function __request($player){
        $item_id = getField('item_id', FIELD_NUM);
        
        $sell_item = $player->getItemById($item_id);
        if($sell_item == null)
			Core::setError("invItemId");
    
        $slot_name = $player->inventory->getSlotByItemId($item_id);
        
        $player->giveMoney($sell_item->sell_price);
        $player->setItemInInventory(null, $slot_name);
        $sell_item->remove();
        
        Core::req()->data = array(
            'user'=>array(),
            'character'=>$player->character,
            'inventory'=>array('id'=>$player->inventory->id, $slot_name=>0)
        );
    }
}