<?php
namespace Schema;

use Srv\Core;
use Srv\Record;
use JsonSerializable;

class Guild extends Record implements JsonSerializable{
    protected static $_TABLE = 'guild';
    
    public static function find($where){
        $guild = parent::find($where);
        if(!$guild)
            return FALSE;
        $id = $guild->id;
        if(!isset(Core::$GUILDS[$id]))
            Core::$GUILDS[$id] = $guild;
        return $guild;
    }
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'ts_creation' => 0,
        'initiator_character_id' => 0,
        'leader_character_id' => 0,
        'name' => '' ,
        'description' => '' ,
        'note' => '' ,
        'forum_page' => '' ,
        'premium_currency' => 0,
        'game_currency' => 500,
        'status' => 1,
        'accept_members' => false,
        'honor' => 1000,
        'artifact_ids' => '' ,
        'missiles' => 15,
        'auto_joins' => 0,
        'battles_attacked' => 0,
        'battles_defended' => 0,
        'battles_won' => 0,
        'battles_lost' => 0,
        'artifacts_won' => 0,
        'artifacts_lost' => 0,
        'artifacts_owned_max' => 2,
        'artifacts_owned_current' => 0,
        'ts_last_artifact_released' => 0,
        'missiles_fired' => 0,
        'auto_joins_used' => 0,
        'dungeon_battles_fought' => 0,
        'dungeon_battles_won' => 0,
        'stat_points_available' => 0,
        'stat_guild_capacity' => 10,
        'stat_character_base_stats_boost' => 1,
        'stat_quest_xp_reward_boost' => 1,
        'stat_quest_game_currency_reward_boost' => 1,
        'arena_background' => 1,
        'emblem_background_shape' => 1,
        'emblem_background_color' => 2,
        'emblem_background_border_color' => 0,
        'emblem_icon_shape' => 1,
        'emblem_icon_color' => 4,
        'emblem_icon_size' => 100,
        'use_missiles_attack' => true,
        'use_missiles_defense' => true,
        'use_missiles_dungeon' => true,
        'use_auto_joins_attack' => true,
        'use_auto_joins_defense' => true,
        'use_auto_joins_dungeon' => true,
        'pending_leader_vote_id' => 0,
        'min_apply_level' => 0,
        'min_apply_honor' => 0,
        'guild_battle_tactics_attack_order' => 1,
        'guild_battle_tactics_attack_tactic' => 10,
        'guild_battle_tactics_defense_order' => 1,
        'guild_battle_tactics_defense_tactic' => 10,
        'active_training_booster_id' => '',
        'ts_active_training_boost_expires' => 0,
        'active_quest_booster_id' => '',
        'ts_active_quest_boost_expires' => 0,
        'active_duel_booster_id' => '',
        'ts_active_duel_boost_expires' => 0
    ];
}