<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;

class buyBooster{
    
    public function __request($player){
        $booster_id = getField('id');
        
        $booster = Config::get("constants.boosters.$booster_id", FALSE);
        
        if(!$booster)
			return Core::setError("errInvalidBoosterId");
			
		$types = ["quest", "stats", "work"];
		
		$cost = $booster['premium_item']?Config::get('constants.booster_large_costs_premium_currency'):Utils::boosterCost($player->getLVL(), $booster["amount"] == 10);
		
		if($booster['premium_item']){
		    if($player->getPremium() < $cost)
				return Core::setError("errRemovePremiumCurrencyNotEnough");
			$player->givePremium(-$cost);
		}else{
		    if($player->getMoney() < $cost)
				return Core::setError("errRemoveGameCurrencyNotEnough");
			$player->giveMoney(-$cost);
		}
		
		$actId = 'active_'.$types[$booster['type']-1].'_booster_id';
		$tsCol = 'ts_active_'.$types[$booster['type']-1].'_boost_expires';
		
		$addTime = time();
		if($player->character->{$tsCol} > time())
			$addTime = $player->character->{$tsCol};
		$player->character->{$tsCol} = $addTime + $booster['duration'];
		$player->character->{$actId} = $booster_id;
		
		$player->calculateStats();
		Core::req()->data = array(
            'character'=>$player->character
	    );
    }
}