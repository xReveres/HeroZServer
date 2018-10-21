<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\GuildLogType;

class rechargeGuildAutoJoins{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        
        $package = intval(getField('package', FIELD_NUM));
        
        $price = Config::get("constants.guild_auto_joins_premium_currency_amount_package{$package}");
        $amount = Config::get("constants.guild_auto_joins_amount_package{$package}");
        
        if($player->guild->getPremium() < $price)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        //dodatkowo sprawdzic czy nie jest juz bitwa prowadzona
        if($player->guild->auto_joins + $amount > 100)
            return Core::setError('');
        $player->guild->givePremium(-$price);
        $player->guild->auto_joins += $amount;
        
        $player->guild->addLog($player, GuildLogType::AutoJoinsRecharged, $amount);
        
        Core::req()->data = array(
            'character'=>array(),
            'guild'=>$player->guild
        );
    }
}