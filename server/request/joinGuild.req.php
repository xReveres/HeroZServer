<?php
namespace Request;

use Srv\Core;
use Schema\GuildInvites;
use Cls\Guild;
use Cls\Utils\GuildLogType;
use Cls\GuildMember;
use Srv\DB;

class joinGuild{
    public function __request($player){
        if($player->character->guild_id != 0)
            return Core::setError('errJoinGuildAlreadyInGuild');
            
        $guild_id = intval(getField('guild_id', FIELD_NUM));    
        
        if($player->character->guild_id == $guild_id)
            return Core::setError('errJoinGuildAlreadyMember');
        
		$invite = GuildInvites::find(function($q)use($guild_id){ $q->where('guild_id',$guild_id)->orderBy('ts_creation','DESC'); });
		
		if(!$invite || (time() - $invite->ts_creation) >= 259200)
			return Core::setError("errJoinGuildInvalidInvitation");
		
		$guild = Guild::find(function($q)use($guild_id){ $q->where('id',$guild_id); });
		$guild->loadGuild();
        if(!$guild || $guild->status == 2)
            return Core::setError('errJoinGuildDeleted');

        if($guild->countMembers() >= $guild->stat_guild_capacity)
            return Core::setError('errJoinGuildAlreadyFull');
        
        $player->character->guild_id = $guild->id;
        $player->character->guild_rank = 3;
        $player->character->guild_donated_game_currency = 0;
        $player->character->guild_donated_game_currency = 0;
        $player->character->game_currency_donation = 0;
        $player->character->premium_currency_donation = 0;
        $player->character->ts_guild_joined = time();
        $player->guild = $guild;
        $player->guild->addMember(new GuildMember($player));
        $player->guild->addLog($player, GuildLogType::MemberJoined);
        $player->calculateStats();
        
        $invite->remove();
        
        Core::req()->data = array(
            'character'=>$player->character,
            'guild'=>$player->guild,
            'guild_members'=>$player->guild->getMembers()
        );
        if(($pendingAttack = $player->guild->getPendingAttack()) != NULL){
        	Core::req()->data['pending_guild_battle_attack'] = $pendingAttack->battle->getDataForAttacker();
        	Core::req()->data['guild_battle_guilds'][] = $pendingAttack->gDefender;
        }
        if(($pendingDefense = $player->guild->getPendingDefense()) != NULL){
        	Core::req()->data['pending_guild_battle_defense'] = $pendingDefense->battle->getDataForDefender();
        	Core::req()->data['guild_battle_guilds'][] = $pendingDefense->gAttacker;
        }
    }
}