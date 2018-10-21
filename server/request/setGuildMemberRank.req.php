<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;

class setGuildMemberRank{
    
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank != 1)
            return Core::setError('errSetMemberRankNoPermission');
        
        $rank = intval(getField("rank",FIELD_NUM));
		$targetID = intval(getField("character_id",FIELD_NUM));
		
		if($rank < 1 || $rank > 3)
		    return Core::setError('errSetMemberRankNotPossible');
		
		//$targetPlayer = Player::getCharacterBy('id=?', array($targetID));
		$member = $player->guild->getMemberByCharacterId($targetID);
		
		if($member->player->character->guild_id != $player->character->guild_id)
			return Core::setError("errKickMemberInvalidGuild");
		
		$member->player->character->guild_rank = $rank;
		
		if($member == null)
		    return Core::setError('errSetMemberRankInvalidGuild');
		   
	    if($rank == 1)
	    	$player->character->guild_rank = 3;
	    	
	    $player->guild->addLog($player, GuildLogType::MemberNewRank, $member->player->character->id, $member->player->character->name, $rank);
	    
	    Core::req()->data = array(
	        'character'=>$player->character,
	        'guild'=>$player->guild,
	        'guild_members'=>$player->guild->getMembers()
	    );
    }
}