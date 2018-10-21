<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\GuildLogType;

class setGuildEmblem{
    public function __request($player){
		if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank != 1)
			return Core::setError("errEmblemGuildNoPermission");
        
        $icon_color = intval(getField("icon_color", FIELD_NUM));
		$icon_shape = intval(getField("icon_shape", FIELD_NUM));
		$icon_size = intval(getField("icon_size", FIELD_NUM));
		$bg_border_color = intval(getField("background_border_color", FIELD_NUM));
		$background_shape = intval(getField("background_shape", FIELD_NUM));
		$background_color = intval(getField("background_color", FIELD_NUM));
		
		$guild_emblem_colors = Config::get('constants.guild_emblem_colors');
		$guild_emblem_backgrounds = Config::get('constants.guild_emblem_backgrounds');
		$guild_emblem_icons = Config::get('constants.guild_emblem_icons');
		
		if(!isset($guild_emblem_colors[$icon_color]) || !isset($guild_emblem_colors[$bg_border_color]) || !isset($guild_emblem_colors[$background_color]) || 
		    !isset($guild_emblem_backgrounds[$background_shape]) || !isset($guild_emblem_icons[$icon_shape]) ||
		    $icon_size < 50 || $icon_size > 150)
		    return Core::setError('guildException');
		    
		$tax_gold = 0;
		$tax_prem = 0;
	    if($player->guild->emblem_background_shape != $background_shape){
	        $tax_gold += $guild_emblem_backgrounds[$background_shape]['game_currency_cost'];
	        $tax_prem += $guild_emblem_backgrounds[$background_shape]['premium_currency_cost'];
	    }
	    
	    if($player->guild->emblem_icon_shape != $icon_shape){
	        $tax_gold += $guild_emblem_icons[$icon_shape]['game_currency_cost'];
	        $tax_prem += $guild_emblem_icons[$icon_shape]['premium_currency_cost'];
	    }
	    
	    if($player->guild->getMoney() < $tax_gold)
	        return Core::setError('errRemoveGameCurrencyNotEnough');
	    if($player->guild->getPremium() < $tax_prem)
	        return Core::setError('errRemovePremiumCurrencyNotEnough');
	        
	    $player->guild->emblem_background_shape = $background_shape;
	    $player->guild->emblem_icon_shape = $icon_shape;
	    $player->guild->emblem_background_color = $background_color;
	    $player->guild->emblem_background_border_color = $bg_border_color;
	    $player->guild->emblem_icon_shape = $icon_shape;
	    $player->guild->emblem_icon_color = $icon_color;
	    $player->guild->emblem_icon_size = $icon_size;
	    $player->guild->giveMoney(-$tax_gold);
	    $player->guild->givePremium(-$tax_prem);
	    
	    $player->guild->addLog($player, GuildLogType::EmblemChanged);
	    
	    Core::req()->data = [
	        'guild'=>$player->guild,
	    ];
    }
}
?>