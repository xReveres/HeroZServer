<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;

class kickGuildMember{
    
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errKickMemberNoPermission');
        
        $character_id = intval(getField('character_id',FIELD_NUM));
        $member = $player->guild->getMemberByCharacterId($character_id);
        
        if($member == null)
            return Core::setError('');
        
        if($member->player->character->guild_id != $player->character->guild_id)
			return Core::setError("errKickMemberInvalidGuild");
		
		if($member->player->character->guild_id == 0)
			return Core::setError("errCharacterNoGuild");
		
		if($member->player->character->guild_rank < $player->character->guild_rank)
			return Core::setError("errKickMemberNotKickable");
        
        $member->player->character->guild_id = 0;
        $member->player->character->guild_rank = 0;
        $player->guild->removeMember($member);
        $player->guild->addLog($player, GuildLogType::MemberKicked, $member->player->character->id, $member->player->character->name);
        
        Core::req()->data = array(
            'character'=>$player->character,
        );
    }
}