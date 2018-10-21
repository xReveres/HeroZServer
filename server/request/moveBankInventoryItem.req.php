<?php
namespace Request;

use Srv\Core;

class moveBankInventoryItem{
    
    public function __request($player){
        $bank_index = intval(getField("bank_index", FIELD_NUM));
		$itemID = intval(getField("item_id", FIELD_NUM));
		$bank_slot_index = intval(getField("target_slot_index", FIELD_NUM));
			
		if($bank_slot_index < 0 || $bank_slot_index > 17 ||$bank_index < 0 || $bank_index > 4 || $bank_index > $player->bankinv->max_bank_index)
            return Core::setError('errAddItemFromInventoryInvalidTargetSlot');
            
		$bank_slot_index = $bank_slot_index+1+($bank_index*18);
		
		$target_item = $player->getItemById($itemID);
		
		$bank_source_slot = $player->bankinv->getSlotByItemId($itemID);
		if($bank_source_slot == null || $target_item == null)
		    return Core::setError('errMoveItemFromInventoryInvalidTargetSlot');
		
		$bank_target_slot = "bank_item{$bank_slot_index}_id";
		
		$source_item = 0;
		if($player->getItemFromBankSlot($bank_target_slot) != null)
		    $source_item = $player->getItemFromBankSlot($bank_target_slot)->id;

        $player->bankinv->{$bank_source_slot} = 0;
        $player->bankinv->{$bank_target_slot} = $target_item->id;
		
		Core::req()->data = array(
		    'bank_inventory'=>['id'=>$player->bankinv->id, $bank_source_slot=>$source_item, $bank_target_slot=>$target_item->id]
		);
    }
}