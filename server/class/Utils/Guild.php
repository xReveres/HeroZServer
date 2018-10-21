<?php
namespace Cls\Utils;

class Guild{
    
    public static $STAT_NAME = [
        'stat_guild_capacity', //*1
        'stat_character_base_stats_boost', //*1
        'stat_quest_xp_reward_boost', //*2
        'stat_quest_game_currency_reward_boost' //*2
    ];
    
    public static function getStatById($id){
        if(!isset(static::$STAT_NAME[$id]))
            return FALSE;
        return static::$STAT_NAME[$id];
    }
}