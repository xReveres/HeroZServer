<?php
namespace Request;

use Srv\Core;

class addInventoryItemToBank{
    
    public function __request($player){
        $bank_index = intval(getField('bank_index', FIELD_NUM)); //slot banku
        $bank_slot = intval(getField('target_slot_index', FIELD_NUM)); //index miejsca w banku
        $item_id = intval(getField('item_id', FIELD_NUM));
        
        if($bank_slot < 0 || $bank_slot > 17 ||$bank_index < 0 || $bank_index > 4 || $bank_index > $player->bankinv->max_bank_index)
            return Core::setError('errAddItemFromInventoryInvalidTargetSlot');
        
        $bank_slot = $bank_slot+1+($bank_index*18);
        
        $item = $player->getItemById($item_id);
        if($item == null)
            return Core::setError('errInventoryInvalidItem');

        $bank_slot_name = "bank_item{$bank_slot}_id";
        if($player->bankinv->{$bank_slot_name} != 0){
            $bank_slot_name = $player->bankinv->findEmptySlot();
            if($bank_slot_name == null)
                return Core::setError('errAddItemFromInventoryInvalidTargetSlot');
        }
            
        $inv_slot = $player->inventory->getSlotByItemId($item->id);
        $player->inventory->{$inv_slot} = 0;
        $player->bankinv->{$bank_slot_name} = $item->id;
        
        Core::req()->data = array(
            'inventory'=>['id'=>$player->inventory->id, $inv_slot=>0],
            'bank_inventory'=>['id'=>$player->bankinv->id, $bank_slot_name=>$item->id]
        );
    }
}