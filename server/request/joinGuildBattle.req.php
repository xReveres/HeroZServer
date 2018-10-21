<?php
namespace Request;

use Srv\Core;
use Schema\GuildBattleRewards;
use Cls\Utils\GuildLogType;

class joinGuildBattle{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
            
        $attack = getField('attack',FIELD_BOOL)=='true';
        
        if( !(($attack && $player->guild->pending_guild_battle_attack_id != 0) || (!$attack && $player->guild->pending_guild_battle_defense_id != 0)) )
            return Core::setError('errInvalidStateToPendingBattle');
        
        $pending = $attack?$player->guild->getPendingAttack():$player->guild->getPendingDefense();
        //if( !(($attack && $pending->playerHasAcceptedAttack($player)) || (!$attack && $pending->playerHasAcceptedDefense($player))))
        //    return Core::setError('errAddCharacterIdAlreadyJoined');
        if(GuildBattleRewards::find(function($q)use($pending,$player){ $q->where('guild_battle_id',$pending->battle->id)->where('character_id',$player->character->id); }))
            return Core::setError('errJoinGuildBattleAlreadyFought');
        
        if($attack){
            if(!$pending->battle->addPlayerToBattleAttack($player))
                return Core::setError('errAddCharacterIdAlreadyJoined');
            $player->guild->addLog($player, GuildLogType::GuildBattle_JoinedAttack);
        }else{
            if(!$pending->battle->addPlayerToBattleDefense($player))
                return Core::setError('errAddCharacterIdAlreadyJoined');
            $player->guild->addLog($player, GuildLogType::GuildBattle_JoinedDefense);
        }
        
        $type = 'pending_guild_battle_'.($attack?'attack':'defense');
        Core::req()->data = array(
            $type=>$attack?$pending->battle->getDataForAttacker():$pending->battle->getDataForDefender()
        );
        
        //Blokada zaraz po przyłączeniu się do drużyny
        //Core::setError('errAddCharacterNoPermission');
        
        //Gdy drużyna zostanie usunięta, a chcemy obraniać
        //Core::setError('errAddCharacterInvalidGuild');
        
        //Ta walka drużynowa została już odbyta
        //Core::setError('errJoinGuildBattleInvalidGuildBattle');
        
        //Nie jesteś członkiem drużyny
        //Core::setError('errCharacterNoGuild');
        
        //Nie możesz wziąć udziału, ponieważ brałeś już w innej
        //Core::setError('errJoinGuildBattleAlreadyFought');
    }
}