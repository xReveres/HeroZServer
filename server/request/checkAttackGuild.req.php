<?php
namespace Request;

use Srv\Core;
use Cls\Guild;

class checkAttackGuild{
    public $targetGuild = null;
    
    public function __request($player, $guild_id=false){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errCreateNoPermission');
        
        $guild_id = intval(getField('guild_id', FIELD_NUM, $guild_id));
        
        if($player->character->guild_id == $guild_id)
            return Core::setError('errCreateAlreadyFought');
        
        $targetGuild = Guild::find(function($q)use($guild_id){ $q->where('id',$guild_id); });
        $targetGuild->loadGuild();
        $this->targetGuild = $targetGuild;
        if(!$targetGuild)
            return Core::setError('errCreateInvalidGuild');
        if($targetGuild->pending_guild_battle_defense_id)
            return Core::setError('errCreateAlreadyAttacked');
        if($targetGuild->pending_guild_battle_attack_id == $player->guild->id)
            return Core::setError('errCreateAttackingUs');
        if($targetGuild->pending_guild_battle_attack_id)
            return Core::setError('errCreateAlreadyAttacking');
        
        //Core::setError('errCreateNoHonorTooStrong');
        //'Twoja drużyna jest zbyt mocna żeby zaatakować tę drużynę'
        //Core::setError('errCreateNotYetAvailable');
        //'Twoja drużyna brała już dziś udział w walce. Żeby zaatakować tę drużynę wybierz termin od jutra'
            
        Core::req()->data = array();
    }
}