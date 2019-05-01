<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Schema\Character;
use Schema\Inventory;
use Schema\BankInventory;
use Cls\Utils;

class createCharacter{
    
    public function __request($player){
        if(!$player)
            return Core::setError('errCreateFailed1');
        if($player->user->trusted != 0)
            return Core::setError('errCreateFailed2');
        
        $gender = getField('gender', FIELD_ALPHA);
        $name = getField('name', FIELD_ALNUM);
        $name = trim(strip_tags($name));
        if(!$gender || !$name)
            return Core::setError('errCreateFailed3');
        $cfgApp = Config::get("constants.character.appearances.$gender", FALSE);
        if(!$cfgApp)
            return Core::setError('missingConfAppearance');
        $hair_color = intval(getField('hair_color', FIELD_NUM));
        $hair_type = intval(getField('hair_type', FIELD_NUM));
        $facial_hair_type = intval(getField('facial_hair_type', FIELD_NUM));
        $head_type = intval(getField('head_type', FIELD_NUM));
        $eyebrows_type = intval(getField('eyebrows_type', FIELD_NUM));
        $mouth_type = intval(getField('mouth_type', FIELD_NUM));
        $nose_type = intval(getField('nose_type', FIELD_NUM));
        $eyes_type = intval(getField('eyes_type', FIELD_NUM));
        $decoration_type = intval(getField('decoration_type', FIELD_NUM));
        $skin_color = intval(getField('skin_color', FIELD_NUM));
        if( !in_array($hair_color,$cfgApp['hair_color']) || !in_array($hair_type,$cfgApp['hair_type']) ||
            !in_array($head_type,$cfgApp['head_type']) ||
            !in_array($eyebrows_type,$cfgApp['eyebrows_type']) || !in_array($mouth_type,$cfgApp['mouth_type']) ||
            !in_array($nose_type,$cfgApp['nose_type']) || !in_array($eyes_type,$cfgApp['eyes_type']) ||
            !in_array($decoration_type,$cfgApp['decoration_type']) || !in_array($skin_color,$cfgApp['skin_color']) ||
            ($gender=='m' && !in_array($facial_hair_type,$cfgApp['facial_hair_type'])))
            return Core::setError('missingAppearance');
        
        //Create character
        $character = new Character([
            'user_id'=>$player->user->id,
            'game_currency'=>Config::get('constants.init_game_currency'),
            'gender'=>$gender,
            'name'=>$name,
            'appearance_hair_color'=>$hair_color,
            'appearance_hair_type'=>$hair_type,
            'appearance_facial_hair_type'=>$facial_hair_type,
            'appearance_head_type'=>$head_type,
            'appearance_eyebrows_type'=>$eyebrows_type,
            'appearance_mouth_type'=>$mouth_type,
            'appearance_nose_type'=>$nose_type,
            'appearance_eyes_type'=>$eyes_type,
            'appearance_decoration_type'=>$decoration_type,
            'appearance_skin_color'=>$skin_color,
            'ts_last_duel_stamina_change'=>time()
        ]);
        $character->save();
        $player->character = $character;
        
        $inventory = new Inventory([
            'character_id'=>$player->character->id
        ]);
        $inventory->save();
        $player->inventory = $inventory;
        
        $bankinv = new BankInventory([
            'character_id'=>$player->character->id
        ]);
        $bankinv->save();
        $player->bankinv = $bankinv;

        $player->user->trusted = 1;
        //
        $q = $player->createQuest([
            'duration'=>60,
            'duration_raw'=>60,
            'duration_type'=>1,
            'energy_cost'=>1,
            'identifier'=>'quest_stage1_time1',
            'level'=>1,
            'rewards'=>Utils::rewards(5, 547)
        ], 1);
        
        $player->loadPlayer();
        
        Core::req()->data = array(
            "user"=>$player->user,
            "character"=>$player->character,
            "bank_inventory"=>$player->bankinv,
            //"guild"=>$player->getGuild(), //gildia
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
            "login_count"=>0,
            "missed_duels"=>0,
            "missed_league_fights"=>0,
            "new_guild_log_entries"=>0,
            "new_version"=>false,
            "reskill_enabled"=>false,
            "server_timestamp_offset"=>3600,
            "show_advertisment"=>false,
            "show_preroll_advertisment"=>false,
            "special_offers"=>array(),
            "tos_update_needed"=>false,
            "tournament_end_timestamp"=>0,
            "user_geo_location"=>"xX",
            "worldboss_event_character_data"=>array()
        );
    }
    
    private function advInfo(){
        $adv = [
            "show_advertisment"=> false,
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
                "title"=> "Hero Zero (MAXGame)",
                "body"=> "Twoja misja została zakończona."
            ),
            "training_finished"=> array(
                "id"=> 2,
                "active"=> true,
                "vibrate"=> false,
                "title"=> "Hero Zero (MAXGame)",
                "body"=> "Twój trening został zakończony."
            ),
            "work_finished"=> array(
                "id"=> 3,
                "active"=> true,
                "vibrate"=> false,
                "title"=> "Hero Zero (MAXGame)",
                "body"=> "Twoja praca jest zakończona."
            ),
            "free_duel_available"=> array(
                "id"=> 4,
                "active"=> true,
                "vibrate"=> false,
                "title"=> "Hero Zero (MAXGame)",
                "body"=> "Znowu masz wystarczająco dużo odwagi na swobodny atak."
            )
        );
        return $t;
    }
}