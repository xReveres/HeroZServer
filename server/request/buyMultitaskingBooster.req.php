<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class buyMultitaskingBooster{
    
    public function __request($player){
        if($player->getLVL() < Config::get('constants.booster_multitasking_unlock_level'))
            return Core::setError('');
        
        $free_boost = getField('free_booster', FIELD_BOOL)=='true';
        
        if($free_boost && !$player->getTutorialFlag('free_multitasking_booster_used')){
            //Free
            $player->character->ts_active_multitasking_boost_expires = time() + Config::get('constants.multitasking_free_rent_time_amount');
            $player->setTutorialFlag('free_multitasking_booster_used');
        }else{
            //Premium
            $cost = Config::get('constants.multitasking_rent_premium_amount');
            if($player->getPremium() < $cost)
                return Core::setError('errRemovePremiumCurrencyNotEnough');
            $player->givePremium(-$cost);
            $player->character->ts_active_multitasking_boost_expires = time() + Config::get('constants.multitasking_rent_time_amount');
        }
        
        Core::req()->data = [
            'character'=>$player->character
        ];
    }
}