<?php
namespace Request;

use Srv\Core;

class moveAmmoBeltItem{
    public function __request($player){
        $equip = getField('equip', FIELD_BOOL)=='true';
        $item_id = intval(getField('item_id',FIELD_NUM));
        $target_slot = intval(getField('target_slot',FIELD_NUM));
        
        if($equip)
            $this->equipMissile($player, $item_id, $target_slot);
        else
            $this->dequipMissile($player, $item_id, $target_slot);
    }
    
    private function equipMissile($player, $item_id, $target_slot){
        $source_slotname = $player->inventory->getSlotByItemId($item_id);
        $target_slotname = "missiles{$target_slot}_item_id";
        
        $source_item = $player->getItemById($item_id);
        if($source_item == null)
            return Core::setError('noItem');
        
        if($player->getItemFromSlot($target_slotname) == -1)
            return Core::setError('');
        
        $target_item = $player->getItemFromSlot($target_slotname);
        if($target_item != null)
            return Core::setError('');
        
        if($player->getItemFromSlot('missiles_item_id') == null)
            $target_slotname = 'missiles_item_id';
        
        $player->setItemInInventory($target_item, $source_slotname);
        $player->setItemInInventory($source_item, $target_slotname);
        
        Core::req()->data = [
            'character'=>[],
            'inventory'=>[
                $source_slotname=>$player->inventory->{$source_slotname},
                $target_slotname=>$player->inventory->{$target_slotname}
            ]
        ];
    }
    
    private function dequipMissile($player, $item_id, $target_slot){
        $source_slotname = $player->inventory->getSlotByItemId($item_id);
        $target_slotname = "bag_item".($target_slot-8)."_id";
        
        $source_item = $player->getItemById($item_id);
        if($source_item == null)
            return Core::setError('noItem');
            
        if($player->getItemFromSlot($target_slotname) != null)
            $target_slotname = $player->findEmptyInventorySlot();
        if($target_slotname == null)
            return Core::setError('errInventoryNoEmptySlot');
        
        $player->setItemInInventory(null, $source_slotname);
        $player->setItemInInventory($source_item, $target_slotname);
        
        Core::req()->data = [
            'character'=>[],
            'inventory'=>[
                $source_slotname=>$player->inventory->{$source_slotname},
                $target_slotname=>$player->inventory->{$target_slotname}
            ]
        ];
    }
}