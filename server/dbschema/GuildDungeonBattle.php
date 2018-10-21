<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class GuildDungeonBattle extends Record{
    protected static $_TABLE = 'guild_dungeon_battle';
    
    
    
    protected static $_FIELDS = [
        'id'=>0,
        'status'=>0,
        'battle_time'=>0,
        'ts_attack'=>0,
        'guild_id'=>0,
        'ts_unlock'=>0,
        'npc_team_identifier'=>'',
        'settings'=>'',
        'character_ids'=>'',
        'joined_character_profiles'=>'',
        'npc_team_character_profiles'=>'',
        'rounds'=>'',
        'rewards'=>'',
        'initiator_character_id'=>0,
    ];
}