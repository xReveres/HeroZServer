<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;

class donateToGuild{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        
        $game_curr = intval(getField('game_currency_amount', FIELD_NUM));
        $premium_curr = intval(getField('premium_currency_amount', FIELD_NUM));
        
        if($game_curr < 0 || $premium_curr < 0)
			return Core::setError('');
        
        if($player->getMoney() < $game_curr)
            return Core::setError('errRemoveGameCurrencyNotEnough');
            
        if($player->getPremium() < $premium_curr)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
        $player->guild->giveMoney($game_curr);
        $player->guild->givePremium($premium_curr);
        $player->character->guild_donated_game_currency += $game_curr;
        $player->character->guild_donated_premium_currency += $premium_curr;
        $player->giveMoney(-$game_curr);
        $player->givePremium(-$premium_curr);
        
        $player->guild->addLog($player, GuildLogType::MemberDonated, $game_curr, $premium_curr);
        
        Core::req()->data = [
            'character'=>$player->character,
            'guild'=>$player->guild
        ];
    }
}