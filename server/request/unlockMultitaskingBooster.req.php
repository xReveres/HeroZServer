<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class unlockMultitaskingBooster{
    public function __request($player){
        if($player->getLVL() < Config::get('constants.booster_multitasking_unlock_level'))
            return Core::setError('');
        
        $cost = Config::get('constants.multitasking_unlock_premium_amount');
        if($player->getPremium() < $cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        $player->givePremium(-$cost);
        $player->character->ts_active_multitasking_boost_expires = -1;
        
        Core::req()->data = [
            'user'=>['id'=>$player->user->id, 'premium_currency'=>$player->getPremium()],
            'character'=>$player->character
        ];
    }
}