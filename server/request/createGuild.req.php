<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Guild;

class createGuild{
    
    public function __request($player){
    	if($player->character->guild_id != 0)
            Core::setError('errCharacterInGuild');
    	
        $name = getField('name', FIELD_ALNUM);
        $name = trim(strip_tags($name));
        $description = getField('description');
        $description = Core::validMSG($description);
        $accept_members = getField('accept_members')=='true';
        
        if(!$name || strlen($name) < Config::get('constants.guild_name_length_min') || strlen($name) > Config::get('constants.guild_name_length_max'))
			return Core::setError("errCreateInvalidName");
		
		if(ctype_digit($name))
			return Core::setError("errCreateProfanityName");
		
		$cost = Config::get('constants.guild_creation_cost_game_currency');
		if($player->getMoney() < $cost)
            return Core::setError('errRemoveGameCurrencyNotEnough');
        
        $checkGuild = Guild::exists(function($q)use($name){ $q->where('name',$name); });
        if($checkGuild)
            return Core::setError('errCreateNameAlreadyExists');
            
        $guild = new Guild([
        	'name'=>$name,
        	'description'=>$description,
        	'accept_members'=>$accept_members,
        	'initiator_character_id'=>$player->character->id,
        	'leader_character_id'=>$player->character->id,
        	'ts_creation'=>time(),
        	'stat_guild_capacity'=>Config::get('constants.init_stat_guild_capacity'),
        	'stat_character_base_stats_boost'=>Config::get('constants.init_stat_character_base_stats_boost'),
        	'stat_quest_xp_reward_boost'=>Config::get('constants.init_stat_quest_xp_reward_boost'),
        	'stat_quest_game_currency_reward_boost'=>Config::get('constants.init_stat_quest_game_currency_reward_boost')
        ]);
        $guild->save();

		$player->character->guild_id = $guild->id;
		$player->character->guild_rank = 1;
		$player->character->ts_guild_joined = time();
		$player->character->game_currency_donation = 0;
		$player->character->premium_currency_donation = 0;
		$player->character->guild_donated_game_currency = 0;
		$player->character->guild_donated_premium_currency = 0;
		
		$player->giveMoney(-$cost);
		
		$player->guild = $guild;
		
		Core::req()->data = [
		    'character'=>$player->character,
		    'guild'=>$player->guild,
		    'guild_members'=>$player->guild->getMembers()
		];
    }
}