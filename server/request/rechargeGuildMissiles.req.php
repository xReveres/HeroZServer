<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\GuildLogType;

class rechargeGuildMissiles{
    
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        
        $amount = abs(intval(getField('amount', FIELD_NUM)));
        
        $price = Config::get('constants.guild_missile_premium_currency_amount') * $amount;
        
        if($player->guild->getPremium() < $price)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        //TODO: dodatkowo sprawdzic czy nie jest juz bitwa prowadzona
        if($player->guild->missiles + $amount > 100)
            return Core::setError('');
        $player->guild->givePremium(-$price);
        $player->guild->missiles += $amount;
        
        $player->getGuild()->addLog($player, GuildLogType::MissilesRecharged, $amount);
        
        Core::req()->data = array(
            'character'=>[],
            'guild'=>$player->guild
        );
    }
}