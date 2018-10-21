<?php
namespace Request;

use Srv\Core;
use Request\checkAttackGuild;
use Cls\Guild;
use Cls\Utils;
use Schema\GuildBattle;
use Cls\Utils\GuildLogType;

class attackGuild{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errCreateNoPermission');
        
        $guild_id = intval(getField('guild_id',FIELD_NUM));
        
        $checkGuild = new checkAttackGuild();
        $ret = $checkGuild->__request($player, $guild_id);
        if($ret == -1) return;
        $targetGuild = $checkGuild->targetGuild;
        
        $time = intval(getField('time',FIELD_NUM));

        if(($time < 1 || $time > 5))
            return Core::setError('errCreateInvalidGuild');
            
        //Kasa
        $cost = Utils::guildBattleCost($player->guild->totalImprovementPercentage());
        if($player->guild->getMoney() < $cost)
            return Core::setError('errRemoveGameCurrencyNotEnough');
            
        $player->guild->giveMoney(-$cost);
        
        $battle_ts = Utils::getGuildBattleAttackTimestamp($time);
        $pendingBattle = new GuildBattle([
            'battle_time'=>$time,
            'ts_attack'=>$battle_ts,
            'guild_attacker_id'=>$player->guild->id,
            'guild_defender_id'=>$targetGuild->id,
            'attacker_character_ids'=>"[{$player->character->id}]",
            'initiator_character_id'=>$player->character->id
        ]);
        $pendingBattle->save();
        
        $player->guild->pending_guild_battle_attack_id = $pendingBattle->id;
        $targetGuild->pending_guild_battle_defense_id = $pendingBattle->id;
        
        $player->guild->addLog($player, GuildLogType::GuildBattle_Attack, $targetGuild->id, $targetGuild->name, $battle_ts);
        $targetGuild->addLog(null, GuildLogType::GuildBattle_Defense, $player->guild->id, $player->guild->name, $battle_ts);
        
        Core::req()->data = array(
            'character'=>[],
            'guild'=>$player->guild,
            'pending_guild_battle_attack'=>$pendingBattle->getDataForAttacker(),
            'guild_battle_guilds'=>[$targetGuild]
        );
    }
}