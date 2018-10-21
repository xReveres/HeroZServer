<?php
namespace Request;

use Srv\Core;
use Cls\Utils\Item;

class useInventoryItem{
    public function __request($player){
        $itemid = intval(getField('item_id',FIELD_NUM));
        if(!$itemid)
            return Core::setError('errInvItem');
        $item = $player->getItemById($itemid);
        $itemslotname = $player->inventory->getSlotByItemId($item->id);
        if(!$item)
            return Core::setError('errInvItem');
        if(!in_array($item->type, Item::$USABLE))
            return Core::setError('errNotUsable');

        switch(Item::$TYPE[$item->type]){
            case 'reskill':{
                $strength = intval(getField('strength',FIELD_NUM));
                $stamina = intval(getField('stamina',FIELD_NUM));
                $critical_rating = intval(getField('critical_rating',FIELD_NUM));
                $dodge_rating = intval(getField('dodge_rating',FIELD_NUM));
                $totalReskill = $strength + $stamina + $critical_rating + $dodge_rating;
                $totalCharacter = $player->character->stat_points_available + $player->character->stat_base_strength + $player->character->stat_base_stamina + $player->character->stat_base_critical_rating + $player->character->stat_base_dodge_rating;
                $freeStats = $totalCharacter - $totalReskill;
                if($freeStats < 0)
                    return Core::setError('errItsWrongBybe');
                $player->character->stat_points_available = $freeStats;
                $player->character->stat_base_strength = $strength;
                $player->character->stat_base_stamina = $stamina;
                $player->character->stat_base_critical_rating = $critical_rating;
                $player->character->stat_base_dodge_rating = $dodge_rating;
                $player->calculateStats();
                //
                $item->remove();
                Core::req()->data = [
                    'character'=>$player->character,
                    'inventory'=>['id'=>$player->inventory->id, $itemslotname=>0]
                ];
                break;
            }
            //TODO:...
        }
    }
}