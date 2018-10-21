<?php
namespace Request;

use Srv\Core;
use Cls\Utils\Item;

class moveInventoryItem{
    
    public function __request($player){
        $target_slot = intval(getField('target_slot', FIELD_NUM));
        $item_id = intval(getField('item_id', FIELD_NUM));
        $action_type = intval(getField('action_type', FIELD_NUM));
        
        $source_item = $player->getItemById($item_id);
        if($source_item == null)
			return Core::setError("errNullItem");
		$source_slotname = $player->inventory->getSlotByItemId($item_id);
			
		switch($action_type){
		    case 0:{ //MoveItem
		        if($target_slot < 8 || $target_slot > 26)
                    return Core::setError('errInvSlot');
                $target_slotname = "bag_item".($target_slot-8)."_id";
                $target_item = $player->getItemFromSlot($target_slotname);
		        break;
		    }
            case 1: break; //BuyItem
            case 2: break; //SellItem
            case 3:{ //EquipItem
                if($target_slot < 1 || $target_slot > 8)
                    return Core::setError("errSetSlot");
                $target_slotname = Item::$TYPE[$source_item->type].'_item_id';
                $target_item = $player->getItemFromSlot($target_slotname);
                break;
            }
            case 4:{ //UnequipItem
                if($target_slot < 8 || $target_slot > 26)
                    return Core::setError('errInvSlot');
                $target_slotname = "bag_item".($target_slot-8)."_id";
                $target_item = $player->getItemFromSlot($target_slotname);
                if($target_item != null && $target_item->type != $source_item->type){ //zamiana slotow
                    $target_slotname = $player->findEmptyInventorySlot();
                    if($target_slotname == null)
                        return Core::setError('errInventoryNoEmptySlot');
                    $target_item = null;
                }
            }
            case 5: break; //NewItems
		}
		
		$player->setItemInInventory($target_item, $source_slotname);
        $player->setItemInInventory($source_item, $target_slotname);
        
        $player->calculateStats();
        Core::req()->data = array(
            'character'=>$player->character,
            'inventory'=>[
                'id'=>$player->inventory->id,
                $source_slotname=> $player->inventory->{$source_slotname},
                $target_slotname=>$player->inventory->{$target_slotname}
            ]
        );
    }
}