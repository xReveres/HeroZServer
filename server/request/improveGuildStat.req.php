<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\Guild;
use Cls\Utils\GuildLogType;

class improveGuildStat{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank > 2)
            return Core::setError('errImproveStatNoPermission');
            
        $guild_stat = intval(getField('stat_type', FIELD_NUM)) - 1;
        
        $statname = Guild::getStatById($guild_stat);
        if($statname === false)
            return Core::setError('illegalStatType');
            
        if($player->guild->{$statname} >= Config::get("constants.max_{$statname}"))
            return Core::setError('');
        
        $building_cost = Config::get("constants.guild_{$statname}_costs")[$player->guild->{$statname}+1];
		if($player->guild->getMoney() < $building_cost["game_currency_cost"])
			return Core::setError("errRemoveGameCurrencyNotEnough");
			
		if($player->guild->getPremium() < $building_cost["premium_currency_cost"])
			return Core::setError("errRemovePremiumCurrencyNotEnough");
			
		$player->guild->giveMoney(-$building_cost["game_currency_cost"]);
		$player->guild->givePremium(-$building_cost["premium_currency_cost"]);
		$player->guild->{$statname}++;
		
		$player->guild->addLog($player, GuildLogType::GuildStatChanged, $guild_stat, $player->guild->{$statname});

        Core::req()->data = [
            'guild'=>$player->guild
        ];
		if($guild_stat == 1){//Booster na doświadczenia podstawowe
		    $player->calculateStats();
		    Core::req()->data['character'] = $player->character;
		}
    }
}