<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class buyDuelStamina{
    
    public function __request($player){
        $confirm = getField('confirm_refill', FIELD_BOOL)==='true';
        if($player->character->duel_stamina >= 20 && !$confirm)
            return Core::setError('errBuyDuelStaminaConfirm');
        if($player->character->duel_stamina >= $player->character->max_duel_stamina)
            return Core::setError('errBuyDuelStaminaAlreadyFull');

        $cost = Config::get('constants.duel_stamina_reset_premium_amount');
        if($player->getPremium() < $cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
        
        $player->givePremium(-$cost);
        $player->character->duel_stamina = $player->character->max_duel_stamina;
        $player->character->ts_last_duel_stamina_change = time();
        
        Core::req()->data = array(
            'character'=>$player->character
        );
    }
}