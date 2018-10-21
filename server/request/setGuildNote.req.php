<?php
namespace Request;

use Srv\Core;
use Cls\Utils\GuildLogType;

class setGuildNote{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errSetNoteNoPermission');
        
        $note = getField('note');
        $note = Core::validMSG($note);
        
        $player->guild->note = $note;
        
        $player->guild->addLog($player, GuildLogType::NoteChanged);
        
        Core::req()->data = array(
            'guild'=>$player->guild
        );
    }
}