<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class buyGuildBooster{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errBuyGuildBoosterNoPermission');
        
        $overrideBooster = getField('overrideBooster', FIELD_BOOL)==='true';
        $extendBooster = getField('extendBooster', FIELD_BOOL)==='true';
        $id = getField('id');
        
        $guild_boosters = Config::get('constants.guild_boosters');
        if(!isset($guild_boosters[$id]))
            return Core::setError();
        $booster = $guild_boosters[$id];
        $types = ['training','quest','duel'];
        
        if($booster['premium_item']){
            $cost = $player->guild->getGuildBoosterCostPremiumCurrency();
            if($player->guild->getPremium() < $cost)
                return Core::setError('errRemovePremiumCurrencyNotEnough');
            $player->guild->givePremium(-$cost);
        }else{
            $cost = $player->guild->getGuildBoosterCostGameCurrency();
            if($player->guild->getMoney() < $cost)
                return Core::setError('errRemoveGameCurrencyNotEnough');
            $player->guild->giveMoney(-$cost);
        }
        
        $actId = 'active_'.$types[$booster['type']-1].'_booster_id';
		$tsCol = 'ts_active_'.$types[$booster['type']-1].'_boost_expires';
		
		$player->guild->{$actId} = $id;
		$addTime = time();
		if(!$overrideBooster && $extendBooster)
		    $addTime = $player->guild->{$tsCol};
		$player->guild->{$tsCol} = $addTime + $booster['duration'];
        
        Core::req()->data['guild']=$player->guild;
        if($booster['type'] == 1)
            Core::req()->data['character']=$player->character;
    }
}