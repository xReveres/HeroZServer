<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class useTrainingStorage{
    public function __request($player){
        if($player->character->current_training_storage <= 0)
            return Core::setError('');
            
        $amount = intval(getField('amount', FIELD_NUM));
        $amount = min($amount, $player->character->current_training_storage);
        $premium_cost = min($amount * Config::get('constants.training_storage_cost'), Config::get('constants.training_storage_cost_maximum'));
        if($player->getPremium() < $premium_cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        $player->givePremium(-$premium_cost);
        $player->character->training_count += $amount;
        $player->character->current_training_storage = 0;
        
        Core::req()->data = [
            'user'=>$player->user,
            'character'=>$player->character
        ];
    }
}