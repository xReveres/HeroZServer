<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class upgradeAmmoBelt{
    public function __request($player){
        if($player->getLVL() < Config::get('constants.ammo_belt_min_required_level'))
            return Core::setError('errTooLowLevel');
        $slot = 0;
        for($i = 1; $i <= 4; $i++){
            if($player->inventory->{"missiles{$i}_item_id"} == -1){
                $slot = $i;
                break;
            }
        }
        if($slot == 0)
            return Core::setError('');
        $cost = Config::get("constants.ammo_belt_slot{$slot}_unlock_premium_currency_amount");
        if($player->getPremium() < $cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
        
        $player->givePremium(-$cost);    
        $player->inventory->{"missiles{$slot}_item_id"} = 0;
            
        Core::req()->data = [
            'user'=>$player->user,
            'character'=>[],
            'inventory'=>$player->inventory
        ];
    }
}