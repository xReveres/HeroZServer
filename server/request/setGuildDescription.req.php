<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;

class setGuildDescription{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errSetDescriptionNoPermission');
        
        $description = getField('description');
        $description = Core::validMSG($description);
        $forum_page = getField('forum_page');
        
        $player->guild->description = $description;
        //$player->getGuild()->setData('forum_page', $forum_page);
        
        $player->guild->addLog($player, GuildLogType::DescriptionChanged);
        
        Core::req()->data = array(
            'guild'=>$player->guild
        );
    }
}