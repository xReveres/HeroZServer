<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class useEnergyStorage{
    public function __request($player){
        if($player->character->current_energy_storage <= 0)
            return Core::setError('');
        
        $amount = intval(getField('amount', FIELD_NUM));
        $amount = min($amount, $player->character->current_energy_storage);
        if($player->character->current_energy_storage <= 50)
            $premium_cost = Config::get('constants.energy_storage_cost_50');
        else
            $premium_cost = Config::get('constants.energy_storage_cost_100');
            
        if($player->getPremium() < $premium_cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        $player->givePremium(-$premium_cost);
        $player->character->quest_energy += $amount;
        $player->character->current_energy_storage = 0;
        
        Core::req()->data = [
            'user'=>$player->user,
            'character'=>$player->character
        ];
    }
}