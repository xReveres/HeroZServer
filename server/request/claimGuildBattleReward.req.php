<?php
namespace Request;

use Srv\Core;
use Schema\GuildBattleRewards;

class claimGuildBattleReward{
    public function __request($player){
        $battleid = intval(getField('guild_battle_id', FIELD_NUM));
        
        $reward = GuildBattleRewards::find(function($q)use($battleid,$player){ $q->where('guild_battle_id',$battleid)->where('character_id',$player->character->id); });
        if(!$reward)
            return Core::setError('');
        
        $player->giveMoney($reward->game_currency);
        //TODO: dac item jezeli istnieje | moze byc error: errInventoryNoEmptySlot
        $reward->remove();
        
        Core::req()->data = [
            'character'=>$player->character
        ];
    }
}