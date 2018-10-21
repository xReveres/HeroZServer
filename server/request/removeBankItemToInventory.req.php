<?php
namespace Request;

use Srv\Core;

class removeBankItemToInventory{
    
    public function __request($player){
        $targetID = intval(getField("target_slot", FIELD_NUM));
		$itemID = intval(getField("item_id", FIELD_NUM));
		
		if($targetID < 9 || $targetID > 26)
			return Core::setError('errInventoryInvalidItem');
		$targetID -= 8;
		
		$item = $player->getItemById($itemID);
		if($item == null)
		    return Core::setError('errInventoryInvalidItem');
		    
        $bank_slot_name = $player->bankinv->getSlotByItemId($item->id);
        if($bank_slot_name == null)
            return Core::setError('errInventoryInvalidItem');
           
        $inventory_slot = "bag_item{$targetID}_id"; 
        if($player->getItemFromSlot($inventory_slot) != null)
            $inventory_slot = $player->findEmptyInventorySlot();
            
        if($inventory_slot == null)
            return Core::setError('errInventoryInvalidItem');
        
        $player->bankinv->{$bank_slot_name} = 0;
        $player->inventory->{$inventory_slot} = $item->id;
        
        Core::req()->data = array(
            'user'=>[],
            'inventory'=>['id'=>$player->inventory->id, $inventory_slot=>$item->id],
            'bank_inventory'=>['id'=>$player->bankinv->id, $bank_slot_name=>0]
        );
    }
}