<?php
namespace Schema;

use Srv\Config;
use Srv\Record;
use ReflectionObject;
use ReflectionProperty;
use JsonSerializable;

class Character extends Record implements JsonSerializable{
    protected static $_TABLE = 'character';
    
    public $online_status = 2; // 1-online 2-offline
    public $active_quest_id = 0;
    public $active_duel_id = 0;
    public $active_work_id = 0;
    public $active_training_id = 0;
    public $max_free_shop_refreshes = 1;
    public $game_currency_donation = 0;
    public $premium_currency_donation = 0;
    public $stat_total_stamina = 0;
    public $stat_total_strength = 0;
    public $stat_total_critical_rating = 0;
    public $stat_total_dodge_rating = 0;
    public $stat_total = 0;
    public $stat_weapon_damage = 0;
    public $quest_pool = '';
    public $duel_stamina_cost = 0;
    public $finished_guild_battle_attack_id = 0;
    public $finished_guild_battle_defense_id = 0;
    public $current_slotmachine_spin = 0;
    
    public function afterLoad(){
        $this->game_currency_donation = $this->guild_donated_game_currency;
        $this->premium_currency_donation = $this->guild_donated_premium_currency;
        $this->duel_stamina_cost = Config::get('constants.duel_stamina_cost');
    }
    
    public function jsonSerialize() {
        return array_merge($this->getData(), get_public_vars($this));
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'user_id' => 0,
        'name' => '' ,
        'gender' => 'm' ,
        'game_currency' => 0,
        'xp' => 0,
        'level' => 1,
        'description' => '' ,
        'note' => '' ,
        'ts_last_action' => 0,
        'score_honor' => 10,
        'score_level' => 10,
        'stat_points_available' => 0,
        'stat_base_stamina' => 10,
        'stat_base_strength' => 10,
        'stat_base_critical_rating' => 10,
        'stat_base_dodge_rating' => 10,
        'stat_bought_stamina' => 0,
        'stat_bought_strength' => 0,
        'stat_bought_critical_rating' => 0,
        'stat_bought_dodge_rating' => 0,
        'active_quest_booster_id' => '' ,
        'ts_active_quest_boost_expires' => 0,
        'active_stats_booster_id' => '' ,
        'ts_active_stats_boost_expires' => 0,
        'active_work_booster_id' => '' ,
        'ts_active_work_boost_expires' => 0,
        'ts_active_sense_boost_expires' => 0,
        'active_league_booster_id' => 0,
        'ts_active_league_boost_expires' => 0,
        'ts_active_multitasking_boost_expires' => 0,
        'max_quest_stage' => 1,
        'current_quest_stage' => 1,
        'quest_energy' => 100,
        'max_quest_energy' => 100,
        'ts_last_quest_energy_refill' => 0,
        'quest_energy_refill_amount_today' => 0,
        'quest_reward_training_sessions_rewarded_today' => 0,
        'honor' => 100,
        'ts_last_duel' => 0,
        'duel_stamina' => 100,
        'max_duel_stamina' => 100,
        'ts_last_duel_stamina_change' => 0,
        'ts_last_duel_enemies_refresh' => 0,
        'current_work_offer_id' => 'work1' ,
        'stat_trained_stamina' => 0,
        'stat_trained_strength' => 0,
        'stat_trained_critical_rating' => 0,
        'stat_trained_dodge_rating' => 0,
        'training_progress_value_stamina' => 0,
        'training_progress_value_strength' => 0,
        'training_progress_value_critical_rating' => 0,
        'training_progress_value_dodge_rating' => 0,
        'training_progress_end_stamina' => 3,
        'training_progress_end_strength' => 3,
        'training_progress_end_critical_rating' => 3,
        'training_progress_end_dodge_rating' => 3,
        'ts_last_training' => 0,
        'training_count' => 10,
        'max_training_count' => 10,
        'active_worldboss_attack_id' => 0,
        'active_dungeon_quest_id' => 0,
        'ts_last_dungeon_quest_fail' => 0,
        'max_dungeon_index' => 0,
        'appearance_skin_color' => 0,
        'appearance_hair_color' => 0,
        'appearance_hair_type' => 0,
        'appearance_head_type' => 0,
        'appearance_eyes_type' => 0,
        'appearance_eyebrows_type' => 0,
        'appearance_nose_type' => 0,
        'appearance_mouth_type' => 0,
        'appearance_facial_hair_type' => 0,
        'appearance_decoration_type' => 1,
        'show_mask' => true,
        'tutorial_flags' => '' ,
        'guild_id' => 0,
        'guild_rank' => 0,
        'ts_guild_joined' => 0,
        'finished_guild_battle_attack_id' => 0,
        'finished_guild_battle_defense_id' => 0,
        'finished_guild_dungeon_battle_id' => 0,
        'guild_donated_game_currency' => 0,
        'guild_donated_premium_currency' => 0,
        'worldboss_event_id' => 0,
        'worldboss_event_attack_count' => 0,
        'ts_last_wash_item' => 0,
        'ts_last_daily_login_bonus' => 0,
        'daily_login_bonus_day' => 1,
        'pending_tournament_rewards' => 0,
        'ts_last_shop_refresh' => 0,
        'shop_refreshes' => 0,
        'event_quest_id' => 0,
        'friend_data' => '' ,
        'pending_resource_requests' => 0,
        'unused_resources' => '{"1":4,"2":1}' ,
        'used_resources' => 0,
        'league_points' => 0,
        'league_group_id' => 0,
        'active_league_fight_id' => 0,
        'ts_last_league_fight' => 0,
        'league_fight_count' => 0,
        'league_opponents' => '' ,
        'ts_last_league_opponents_refresh' => 0,
        'league_stamina' => 20,
        'max_league_stamina' => 20,
        'ts_last_league_stamina_change' => 0,
        'league_stamina_cost' => 20,
        'herobook_objectives_renewed_today' => 0,
        'slotmachine_spin_count' => 0,
        'ts_last_slotmachine_refill' => 0,
        'new_user_voucher_ids' => '' ,
        'current_energy_storage' => 0,
        'current_training_storage' => 0
    ];
}