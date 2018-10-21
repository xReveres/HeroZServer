<?php
namespace Request;

use Srv\Core;

class sellBankInventoryItem{
    
    public function __request($player){
        $itemID = intval(getField('item_id', FIELD_NUM));
        
        $item = $player->getItemById($itemID);
        
        $bank_source_slot = $player->bankinv->getSlotByItemId($itemID);
		if($item == null || $bank_source_slot == null)
		    Core::setError('errInventoryInvalidItem');
		    
		$player->giveMoney($item->sell_price);
		
		$player->bankinv->{$bank_source_slot} = 0;
		$item->remove();
		
		Core::req()->data = array(
		    'user'=>[],
		    'character'=>$player->character,
		    'bank_inventory'=>['id'=>$player->bankinv->id, $bank_source_slot=>0]
		);
    }
}