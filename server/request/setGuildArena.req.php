<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\GuildLogType;

class setGuildArena{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
            
        if($player->character->guild_rank == 3)
            return Core::setError('errInvalidPermissions');
            
        $background = abs(intval(getField('background', FIELD_NUM)));
        
        $bg_settings = Config::get('constants.guild_arena_backgrounds');
        
        if(!isset($bg_settings[$background]))
            Core::setError('errInvalidBackground');
            
        $tax_gold = $bg_settings[$background]['game_currency_cost'];
        $tax_prem = $bg_settings[$background]['premium_currency_cost'];
        if($player->guild->getMoney() < $tax_gold)
            Core::setError('errRemoveGameCurrencyNotEnough');
        if($player->guild->getPremium() < $tax_prem)
            Core::setError('errRemovePremiumCurrencyNotEnough');
        
        $player->guild->giveMoney(-$tax_gold);
        $player->guild->givePremium(-$tax_prem);
        $player->guild->arena_background = $background;

        $player->guild->addLog($player, GuildLogType::ArenaChanged);
        
        Core::req()->data = [
            'guild'=>$player->guild
        ];
    }
}