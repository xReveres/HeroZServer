<?php
namespace Request;

use Srv\Core;
use Cls\Player;
use Schema\User;

class loginUser{
    
    public function __request($player=null, $uid=false, $exssid = false){
        if(!$exssid || !$uid){
        	$email = getField('email', FIELD_EMAIL);
        	if(!User::exists(function($q)use($email){ $q->where('email',$email); }))
        		return Core::setError('errLoginNoSuchUser');
        	$pass = getField('password');
        	if(!$email || !$pass || !($player = Player::login($email, $pass)))
        		return Core::setError('errLoginInvalid');
        }else
        	if(!($player = Player::findBySSID($uid, $exssid)))
        		return Core::setError('errLoginNoSuchSessionId');
        		
        $player->user->session_id = md5(microtime());
        $player->user->last_login_ip = getclientip();
        $player->user->ts_last_login = time();
        $player->user->login_count++;
        
        $dailyLogin = $player->getDailyBonuses();
        
        Core::req()->data = array(
            "user"=>$player->user,
            "character"=>$player->character,
            "bank_inventory"=>$player->bankinv,
            "inventory"=>$player->inventory, //eq
            "items"=>$player->items, //itemy
            "quests"=>$player->quests, //questy
            //
            "advertisment_info"=>$this->advInfo(),
            "bonus_info"=>$this->bonusInfo(),
            "campaigns"=>array(),
            "collected_goals"=>array(),
            "collected_item_pattern"=>array(),
            "current_goal_values"=>array(),
            "current_item_pattern_values"=>$this->itemPatt(),
            "item_offers"=>array(),
            "league_locked"=>true,
            "league_season_end_timestamp"=>0,
            "local_notification_settings"=>$this->notif(),
            "login_count"=>$player->user->login_count,
            "missed_duels"=>0,
            "missed_league_fights"=>0,
            "new_guild_log_entries"=>0,
            "new_version"=>false,
            "reskill_enabled"=>false,
            "server_timestamp_offset"=>Core::getTimestampOffset(),
            "show_advertisment"=>false,
            "show_preroll_advertisment"=>false,
            "special_offers"=>array(),
            "tos_update_needed"=>false,
            "tournament_end_timestamp"=>0,
            "user_geo_location"=>"xX",
            "worldboss_event_character_data"=>array()
        );
        if($player->guild != null){
        	Core::req()->data['guild']= $player->guild;
        	Core::req()->data['guild_members']=$player->guild->getMembers();
        	if(count($player->guild->getBattleRewards()))
        		Core::req()->data['guild_battle_rewards'] = $player->guild->getBattleRewards();
        	if(($finishedAttack = $player->guild->getFinishedAttack()) != NULL){
        		Core::req()->data['finished_guild_battle_attack'] = $finishedAttack->battle->getDataForAttacker();
        		Core::req()->data['guild_battle_guilds'][] = $finishedAttack->gDefender;
        	}
        	if(($finishedDefense = $player->guild->getFinishedDefense()) != NULL){
        		Core::req()->data['finished_guild_battle_defense'] = $finishedDefense->battle->getDataForDefender();
        		Core::req()->data['guild_battle_guilds'][] = $finishedDefense->gAttacker;
        	}
        	if(($pendingAttack = $player->guild->getPendingAttack()) != NULL){
        		Core::req()->data['pending_guild_battle_attack'] = $pendingAttack->battle->getDataForAttacker();
        		Core::req()->data['guild_battle_guilds'][] = $pendingAttack->gDefender;
        	}
        	if(($pendingDefense = $player->guild->getPendingDefense()) != NULL){
        		Core::req()->data['pending_guild_battle_defense'] = $pendingDefense->battle->getDataForDefender();
        		Core::req()->data['guild_battle_guilds'][] = $pendingDefense->gAttacker;
        	}
        }
        if($player->character->active_work_id)
        	Core::req()->data["work"]= $player->work;
        if($player->character->active_training_id)
        	Core::req()->data["training"]= $player->training;
        //
        //Core::req()->data += array('missed_duels'=>Core::db()->query('SELECT COUNT(*) FROM '.DataBase::getTable('duel').' WHERE `character_b_status` = 1 AND `character_b_id`='.$this->player->characterID)->fetch(PDO::FETCH_NUM)[0]);
        //
        if($player->battle)
        	Core::req()->data['battle'] = $player->battle;
        if($player->character->active_duel_id)
        	Core::req()->data['duel'] = $player->duel;
        if(count($player->battles))
        	Core::req()->data['battles'] = $player->battles;
        //
        Core::req()->data['new_messages'] = $player->getUnreadedMessagesCount();
        //
        if($dailyLogin !== FALSE){
        	Core::req()->data['daily_login_bonus_rewards'] = $dailyLogin;
        	Core::req()->data['daily_login_bonus_day'] = $player->character->daily_login_bonus_day;
        }
    }
    
    private function advInfo(){
        $adv = [
			"show_advertisment"=> true,
			"show_preroll_advertisment"=> false,
			"show_left_skyscraper_advertisment"=> false,
			"show_pop_under_advertisment"=> false,
			"show_footer_billboard_advertisment"=> false,
			"advertisment_refresh_rate"=> 15,
			"mobile_interstitial_cooldown"=> 1800,
			"remaining_video_advertisment_cooldown__1"=> 0,
			"video_advertisment_blocked_time__1"=> 1800,
			"remaining_video_advertisment_cooldown__2"=> 0,
			"video_advertisment_blocked_time__2"=> 1800,
			"remaining_video_advertisment_cooldown__3"=> 0,
			"video_advertisment_blocked_time__3"=> 1800,
			"remaining_video_advertisment_cooldown__4"=> 0,
			"video_advertisment_blocked_time__4"=> 1800,
			"remaining_video_advertisment_cooldown__5"=> 0,
			"video_advertisment_blocked_time__5"=> 7200
		];
		return $adv;
    }
    
    private function bonusInfo(){
        $b = array(
				"quest_energy"=> 0,//$this->characterData["quest_energy"],
				"duel_stamina"=> 0,//$this->characterData["duel_stamina"],
				"league_stamina"=> 0,//$this->characterData["league_stamina"],
				"training_count"=> 0,//$this->characterData["training_count"]
			);
		return $b;
    }
    
    private function itemPatt(){
        $patt = [
			"biker"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"costume"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"disco"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"doctor"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"movie"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"robinhood"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"superherozero"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"superheroset1"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"superheroset2"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"superheroset3"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"olympia_2016_rio"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"asian"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"frogman1"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"ironman1"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"movienew"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"musketeer"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"overall"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"powerset1"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"powerset2"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"safari"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"nano"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"pirates"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"wrestling"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"octoberfest"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"halloween"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"superhero"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"work"=>["value" => 0,"collected_items" => null,"is_new" => false], 
			"league_custom1"=>["value" => 0,"collected_items" => null,"is_new" => true], 
			"league_custom2"=>["value" => 0,"collected_items" => null,"is_new" => true], 
			"xmas"=>["value" => 0,"collected_items" => null,"is_new" => true]
		];
		return $patt;
    }
    
    private function notif(){
        $t = array(
			"mission_finished"=> array(
				"id"=> 1,
				"active"=> true,
				"vibrate"=> false,
				"title"=> "HeroZ",
				"body"=> "Twoja misja została zakończona."
			),
			"training_finished"=> array(
				"id"=> 2,
				"active"=> true,
				"vibrate"=> false,
				"title"=> "HeroZ",
				"body"=> "Twój trening został zakończony."
			),
			"work_finished"=> array(
				"id"=> 3,
				"active"=> true,
				"vibrate"=> false,
				"title"=> "HeroZ",
				"body"=> "Twoja praca jest zakończona."
			),
			"free_duel_available"=> array(
				"id"=> 4,
				"active"=> true,
				"vibrate"=> false,
				"title"=> "HeroZ",
				"body"=> "Znowu masz wystarczająco dużo odwagi na swobodny atak."
			)
		);
		return $t;
    }
}