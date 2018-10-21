<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class GuildBattleRewards extends Record implements JsonSerializable{
    protected static $_TABLE = 'guild_battle_rewards';
    
    public function jsonSerialize(){
        return $this->getData(['id','guild_battle_id','game_currency','item_id','status']);
    }
    
    protected static $_FIELDS = [
        'id'=>0,
        'guild_battle_id'=>0,
        'character_id'=>0,
        'game_currency'=>0,
        'item_id'=>0,
        'status'=>1,
        'type'=>0
    ];
}