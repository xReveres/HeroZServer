<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;
use Schema\GuildLogs;
use Schema\GuildMessages;

class leaveGuild{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
            
        $player->guild->addLog($player, GuildLogType::MemberLeft);
        $player->guild->removeMember($player->character->id);
        
        $membersCount = $player->guild->countMembers();
        if($player->character->guild_rank == 1 && $membersCount > 1){
            $members = $player->guild->getMembers();
            function cmp($a, $b)
            {
                if ($a->player->character->ts_last_action == $b->player->character->ts_last_action)
                    return 0;
                return ($a->player->character->ts_last_action < $b->player->character->ts_last_action) ? -1 : 1;
            }
            usort($members, "cmp");
            $members[0]->player->character->guild_rank = 1;
        }else if($player->character->guild_rank == 1 && $membersCount <= 1){
            GuildLogs::delete(function($q)use($player){ $q->where('guild_id',$player->guild->id); });
            GuildMessages::delete(function($q)use($player){ $q->where('guild_id',$player->guild->id); });
            $player->guild->status = 2;
            $player->guild = null;
        }
            
        $player->character->guild_id = 0;
        $player->character->guild_rank = 0;
        
        Core::req()->data = array(
            'character'=>$player->character
        );
    }
}