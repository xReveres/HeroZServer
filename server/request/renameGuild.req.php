<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils\GuildLogType;
use Schema\Guild;

class renameGuild{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank != 1)
            return Core::setError('errRenameGuildNoPermission');
        
        $name = getField('name', FIELD_ALNUM);
        $name = trim(strip_tags($name));
        
        if(!$name || strlen($name) < Config::get('constants.guild_name_length_min') || strlen($name) > Config::get('constants.guild_name_length_max'))
			return Core::setError("errCreateInvalidName");
        
        if($player->guild->name == $name)
            return Core::setError('errRenameSameName');
        
        $cost = Config::get('constants.guild_rename_premium_currency_amount');
        if($player->guild->getPremium() < $cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
            
		$guild = Guild::exists(function($q)use($name){ $q->where('name',$name); });
		if($guild)
		    return Core::setError("errRenameNameAlreadyExists");
        
        $player->guild->givePremium(-$cost);
        $player->guild->name = $name;
        
        $player->guild->addLog($player, GuildLogType::NameChanged, $name);
        Core::req()->data = [
            'guild'=>$player->guild
        ];
    }
}