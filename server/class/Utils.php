<?php
namespace Cls;

use Srv\Core;
use Srv\Config;
use Cls\Utils\ItemsList;
use Cls\Utils\Item;
use Cls\Utils\QuestList;
use Cls\Utils\NPCList;
use DateTime;

class Utils{
    
    public static function diffDate($time){
        $match = date('Y.m.d', $time);
        
        $curr_date = new DateTime();
        $curr_date->setTime(0,0,0);
        
        $match_date = DateTime::createFromFormat( "Y.m.d", $match);
        $match_date->setTime(0,0,0);
        
        $diff = $curr_date->diff( $match_date );
        return intval($diff->format("%R%a"));
    }
    
    public static function isNotToday($time){
        return Utils::diffDate($time) != 0;
    }
    
    public static function isToday($time){
        return Utils::diffDate($time) == 0;
    }
    
    public static function isTomorrow($time){
        return Utils::diffDate($time) == 1;
    }
    
    public static function isYesterday($time){
        return Utils::diffDate($time) == -1;
    }
    
    public static function isSometime($time){
        return abs(Utils::diffDate($time)) > 1; 
    }

    public static function calculateDailyBonus($player, $bonus, &$amount1, &$amount2){
        $amount1 = static::randomiseDailyBonus($player, $bonus['reward_type1'], $bonus['reward_type1_factor'], $amount1);
        $amount2 = static::randomiseDailyBonus($player, $bonus['reward_type2'], $bonus['reward_type1_factor'], $amount2);
    }
    
    private static function randomiseDailyBonus($player, $type, $factor, &$amount){
        switch($type){
            case 0:
                return 0;
            case 1: //Money
                $amount = round((Config::get('constants.daily_login_bonus_reward_game_currency_base') * $player->getLVL() * random(0.5,1)) * $factor);
                $player->giveMoney($amount);
                return $amount;
            break;
            case 2: //XP
                $amount = round((Config::get('constants.daily_login_bonus_reward_xp_base') * $player->getLVL() * random(0.4,1)) * $factor);
                $player->giveExp($amount);
                return $amount;
            break;
            case 3: //Premium
                $amount = round((Config::get('constants.daily_login_bonus_reward_premium_currency_base') * round($player->getLVL()/10) * random(0.8,2)) * $factor);
                $player->givePremium($amount);
                return $amount;
            break;
        }
    }

    public static function rewards($coins=0, $xp=0, $honor=0, $premium=0, $statPoints=0, $item=0){
        if(is_object($item)) $item = $item->id;
        return json_encode(['coins'=>$coins,'xp'=>$xp,'honor'=>$honor,'premium'=>$premium,'statPoints'=>$statPoints,'item'=>$item]);
    }
    
    public static function clamp($min, $max, $value){
        if($value < $min)
            return $min;
        else if($value > $max)
            return $max;
        return $value;
    }
    
    public static function randomiseQuest($player, $stage, $canGenItem=false, &$isAnyItem=false){
        $type = 1;
        $difficulty = 0;
        $npcidentifier = '';
        if(random() < 0.2){
            $type = 2;
            $difficulty = random_between([1=>0.6, 2=>0.3, 3=>0.1]);
            $qDiff = QuestList::$DIFFICULTY[$difficulty];
            $npcidentifier = NPCList::$NPC[mt_rand(0, count(NPCList::$NPC)-1)];
        }
        if($canGenItem && random() < 0.05){
            $isAnyItem = true;
            
        }
        $qType = $type==1?'time':'fight';
        $lvl = $player->getLVL();
        $dur_raw = mt_rand(min(4, $lvl-1), min($lvl+5, 12));
        $energy = $dur_raw*random(1,1.3);
        $duration = $dur_raw * 60;
        //
        $coins = mt_rand($lvl + 2, $lvl + 5)*($lvl/2);
        if($type==2) $coins *= Config::get("constants.fight_quest_reward_coin_scale_{$qDiff}");
        $xp = (10 * $lvl * $dur_raw) + (random(0.5, 1) * 550);
        if($type==2) $xp *= Config::get("constants.fight_quest_reward_xp_scale_{$qDiff}");
        //Guild booster
        if($player->character->guild_id != 0){
            $coins *= (1+(($player->guild->stat_quest_game_currency_reward_boost*2)/100));
            $xp *= (1+(($player->guild->stat_quest_xp_reward_boost*2)/100));
        }
        return [
            'identifier'=> "quest_stage{$stage}_{$qType}".mt_rand(1, QuestList::$QUEST_DATA["stage$stage"][$type-1]),
            'type'=> $type, //1 czasowa | 2 fight
            'stage'=> $stage,
            'level'=> $lvl,
            'duration_type'=> 1,
            'duration'=> round($duration),
            'duration_raw'=> round($duration),
            'energy_cost'=> round($energy),
            'fight_difficulty'=> $difficulty,
            'fight_npc_identifier'=> $npcidentifier,
            'rewards'=> Utils::rewards(round($coins), round($xp))
        ];
    }
    
    public static function refreshShopItems($player){
        $chance_rare = Config::get('constants.item_quality_chance_rare');
        $chance_epic = Config::get('constants.item_quality_chance_epic');
        $items_rare = 0;
        $items_epic = 0;
        $items_premium = 0;
        $max_rare = Config::get('constants.shop_max_rare_items');
        $max_epic = Config::get('constants.shop_max_epic_items');
        $max_premium = Config::get('constants.shop_max_premium_items');
        $lvl = $player->getLVL();
        for($i=0; $i < 9; $i++){
            $quality = 1;
            if(random() < $chance_epic && $items_epic < $max_epic)
                $quality = 3;
            if(random() < $chance_rare && $items_rare < $max_rare)
                $quality = 2;
            
            do{
                $type = mt_rand(1, 11);
                if($type == 9 || $type == 10) $type -= 7;
                $item = ItemsList::$ITEMS[Item::$TYPE[$type]][mt_rand(0, count(ItemsList::$ITEMS[Item::$TYPE[$type]])-1)];
            }while(($item["quality"] != $quality || $item["required_level"] > $lvl));
            
            $shpit = $player->getItemFromSlot('shop_item'.($i+1).'_id');
            if($shpit == null)
                $shpit = $player->createItem($item);
            else
                $shpit->setData($item);
            
            if($item['type'] == Item::$TYPE_ID['missiles']){
                $shpit->charges = 100;
                $shpit->stat_critical_rating = $shpit->stat_dodge_rating = $shpit->stat_stamina = $shpit->stat_strength = $shpit->stat_weapon_damage = 0;
            }else{
                $shpit = static::randomiseItem($shpit, $player->getLVL());
                if($item['type'] == Item::$TYPE_ID['weapon'])
                    $shpit->stat_weapon_damage = round($shpit->item_level * Config::get('constants.item_weapon_damage_factor'));
                else
                    $shpit->stat_weapon_damage = 0;
            }
            if($item['type'] == Item::$TYPE_ID['reskill']){
                $shpit->stat_critical_rating = $shpit->stat_dodge_rating = $shpit->stat_stamina = $shpit->stat_strength = $shpit->stat_weapon_damage = 0;
                $shpit->buy_price = 39;
                $shpit->premium_item = true;
            }
            
            $player->setItemInInventory($shpit, 'shop_item'.($i+1).'_id');

            if($shpit->premium_item)
                $items_premium++;
            if($quality == 2)
                $items_rare++;
            if($quality == 3)
                $items_epic++;
        }
    }
    
    public static function randomiseItem($item, $lvl){
        $item->item_level = round(random(Config::get('constants.item_level_character_level_min_percentage'), 1.1) * $lvl);
        $item->premium_item = mt_rand(1,10) < 3;
        $totalstats = ($item->item_level * Config::get('constants.item_stats_per_level'));
        $allstats = ceil($totalstats) * $item->quality * ($item->premium_item?2:1);
        $stats = ['stat_stamina','stat_strength','stat_critical_rating','stat_dodge_rating'];
        shuffle($stats);
        foreach($stats as $st){
            if(random() < 0.5) continue;
            $val = ceil(random() * $allstats);
            $item->{$st} = $val;
            $allstats = max($allstats - $val, 0);
        }
        $lastStat = $stats[mt_rand(0,3)];
        $item->{$lastStat} += $allstats;
        if($item->premium_item){
            $quality = Item::$QUALITY[$item->quality];
            $item->buy_price = Config::get("constants.item_buy_price_premium_{$quality}");
        }else
            $item->buy_price = ceil($totalstats*1.65);
        $item->sell_price = $item->premium_item?0:ceil($item->buy_price/2);
        return $item;
    }
    
    public static function getStartingItems($player){
        $items = ItemsList::$START_ITEMS;
        for($i=0,$c=count($items); $i < $c; $i++){
            $item = $player->createItem($items[$i]);
            $player->setItemInInventory($item, 'shop_item'.($i+1).'_id');
        }
    }
    
    public static function getStatById($stat, $prefix=""){
        switch($stat){
            case 1:
                return $prefix."stamina";
            case 2:
                return $prefix."strength";
            case 3:
                return $prefix."critical_rating";
            case 4:
                return $prefix."dodge_rating";
            default:
                return null;
        }
    }
    
    public static function calcNeededCoins($param1){
        $_loc_2 = Config::get('constants.cost_stat_base');
        $_loc_3 = Config::get('constants.cost_stat_scale');
        $_loc_4 = Config::get('constants.cost_stat_base_scale');
        $_loc_5 = Config::get('constants.cost_stat_base_exp');
        $_loc_6 = round($_loc_2 + ($_loc_3 * (pow($_loc_4 * $param1, $_loc_5))));
        return $_loc_6;
    }
    
    public static function boosterCost($param1, $param2){
         $_loc3_ = ceil(($param1 + 1) / 10);
         $_loc4_ = 0;
         if($param2)
         {
            $_loc4_ = Config::get('constants.booster_small_costs_time');
         }
         else
         {
            $_loc4_ = Config::get('constants.booster_medium_costs_time');
         }
         $_loc5_ = Config::get('constants.booster_costs_coins_step');
         $_loc6_ = Config::get('constants.coins_per_time_base');
         $_loc7_ = Config::get('constants.coins_per_time_scale');
         $_loc8_ = Config::get('constants.coins_per_time_level_scale');
         $_loc9_ = Config::get('constants.coins_per_time_level_exp');
         $_loc10_ = ceil(($_loc6_ + $_loc7_ * pow($_loc8_ * ($_loc3_ * 10 - 9),$_loc9_)) * $_loc4_ / $_loc5_) * $_loc5_;
         return round($_loc10_);
    }
    
    //$param1 - lvl
    public static function coinsPerTime($param1){
        $_loc_2 = Config::get('constants.coins_per_time_base');
        $_loc_3 = Config::get('constants.coins_per_time_scale');
        $_loc_4 = Config::get('constants.coins_per_time_level_scale');
        $_loc_5 = Config::get('constants.coins_per_time_level_exp');
        $_loc_6 = $_loc_2 + ($_loc_3 * (pow($_loc_4 * $param1, $_loc_5)));
        return round($_loc_6, 3);
    }
    
    //$param1 - lvl | $param 2 - ? | $param3 - duration | $param4 - mult?
    public static function getWorkCoinReward($param1, $param2, $param3, $param4 = 0){
        $_loc_5 = Config::get('constants.work_effectiveness_max');
        $_loc_6 = Config::get('constants.work_effectiveness_min');
        $_loc_7 = Config::get('constants.work_duration_min');
        $_loc_8 = Config::get('constants.work_duration_max');
        $_loc_9 = ($param3 * ($_loc_5 - ($param3 - $_loc_7) / ($_loc_8 - $_loc_7) * ($_loc_5 - $_loc_6))) * Utils::coinsPerTime($param1) * (1 + $param2);
        return round($_loc_9 * (1 + $param4));
    }
    
    public static function getAbortedWorkCoinReward($param1, $param2, $param3, $param4 = 0){
        $_loc_5 = Config::get('constants.work_abort_reward_factor');
        $_loc_6 = Utils::getWorkCoinReward($param1, $param2, $param3, $param4);
        return round($_loc_6 * $_loc_5);
    }
    
    public static function checkPlayerStatus($time){
        return (time() - $time < 60?true:false);
    }
    
    public static function getCriticalHitPercentage($critical1, $critical2){
        $_loc_3 = Config::get('constants.battle_critical_probability_min');
        $_loc_4 = Config::get('constants.battle_critical_probability_base');
        $_loc_5 = Config::get('constants.battle_critical_probability_max');
        $_loc_6 = Config::get('constants.battle_critical_probability_exp_low');
        $_loc_7 = Config::get('constants.battle_critical_probability_exp_high');
        $_loc_8 = $critical1 / $critical2;    
        $_loc_9 = 0;
        if($_loc_8 <= 1)
        {
            $_loc_9 = (pow($_loc_8, $_loc_6)) * ($_loc_4 - $_loc_3) + $_loc_3;
        }
        else
        {
            $_loc_9 = (1 - (pow(1 / $_loc_8, $_loc_7))) * ($_loc_5 - $_loc_4) + $_loc_4;
        }
        return round($_loc_9, 3);
    }
    
    public static function getDodgePercentage($dodge1, $dodge2){
        $_loc_3 = Config::get('constants.battle_dodge_probability_min');
        $_loc_4 = Config::get('constants.battle_dodge_probability_base');
        $_loc_5 = Config::get('constants.battle_dodge_probability_max');
        $_loc_6 = Config::get('constants.battle_dodge_probability_exp_low');
        $_loc_7 = Config::get('constants.battle_dodge_probability_exp_high');
        $_loc_8 = $dodge1 / $dodge2;
        $_loc_9 = 0;
        if($_loc_8 <= 1)
        {
            $_loc_9 = (pow($_loc_8, $_loc_6)) * ($_loc_4 - $_loc_3) + $_loc_3;
        }
        else
        {
            $_loc_9 = (1 - (pow(1 / $_loc_8, $_loc_7))) * ($_loc_5 - $_loc_4) + $_loc_4;
        }
        return round($_loc_9, 3);
    }
    
    public static function duelHonorWinReward($honor1, $honor2, $guildDuelBooster=1, $guildDuelArtifactBooster=1){
        $_local5 = Config::get('constants.pvp_honor_win_exp_better');
        $_local6 = Config::get('constants.pvp_honor_win_exp_worse');
        $_local7 = 0;
        if ($honor1 > $honor2){
            $_local7 = (1 - pow(($honor2 / $honor1), $_local6));
        } else {
            if($honor2 == 0)
                return 0;
            $_local7 = (-1 * (1 - pow(($honor1 / $honor2), $_local5)));
        }
        $_local7 = (100 - ($_local7 * 100));
        $_local7 = (($_local7 * $guildDuelBooster) * $guildDuelArtifactBooster);
        return (round($_local7));
    }
    
    public static function guildBattleCost($param1){
        $_loc1_ = floor($param1);
        $_loc2_ = Config::get("constants.guild_battle_attack_cost.{$_loc1_}");
        return $_loc2_;
    }
    
    public static function getGuildBattleAttackTimestamp($param1){
        $_loc2_ = intval(date('H'));
        $_loc3_ = Config::get('constants.guild_battle_preparation_time');
        switch($param1)
        {
            case 1:
                return $_loc2_ >= (12 - $_loc3_)?intval(Utils::calculateGuildBattleAttackTimestamp(12,true)):intval(Utils::calculateGuildBattleAttackTimestamp(12,false));
            case 2:
                return $_loc2_ >= (16 - $_loc3_)?intval(Utils::calculateGuildBattleAttackTimestamp(16,true)):intval(Utils::calculateGuildBattleAttackTimestamp(16,false));
            case 3:
                return $_loc2_ >= (18 - $_loc3_)?intval(Utils::calculateGuildBattleAttackTimestamp(18,true)):intval(Utils::calculateGuildBattleAttackTimestamp(18,false));
            case 4:
                return $_loc2_ >= (20 - $_loc3_)?intval(Utils::calculateGuildBattleAttackTimestamp(20,true)):intval(Utils::calculateGuildBattleAttackTimestamp(20,false));
            case 5:
                return $_loc2_ >= (22 - $_loc3_)?intval(Utils::calculateGuildBattleAttackTimestamp(22,true)):intval(Utils::calculateGuildBattleAttackTimestamp(22,false));
            default:
                return 0;
        }
    }
    
    private static function calculateGuildBattleAttackTimestamp($param1, $param2){
        $param1 = $param1 - Core::HOUR_TIME_OFFSET;
        $nextDaySeconds = 86400;
        return strtotime(date("d-m-Y $param1:00:00"))+($param2?$nextDaySeconds:0);
    }
    
    public static function duelHonorLostReward($honor1, $honor2){
        if ($honor1 == 0){
           return (0);
        };
        $_local3 = Config::get('constants.pvp_honor_lose_amount');
        $_local4 = Config::get('constants.pvp_honor_lose_max');
        $_local5 = Utils::duelHonorWinReward($honor1, $honor2);
        $_local6 = 0;
        if (($_local3 * $_local5) < ($_local4 * $honor2)){
            $_local6 = ($_local3 * $_local5);
        } else {
            $_local6 = ($_local4 * $honor2);
        };
        $_local7 = round($_local6);
        $_local7 = ($_local7 * -1);
        return ($_local7);
    }
    
    public static function duelCoinWinReward($lvl, $_arg2=1, $_arg3=1){
        $_local4 = Config::get('constants.pvp_waiting_time');
        $_local5 = Config::get('constants.pvp_effectiveness_won');
        $_local6 = (((($_local4 * Utils::coinsPerTime($lvl)) * $_local5) * $_arg2) * $_arg3);
        return (round($_local6));
    }
    
    public static function coinCostEnergyRefill($param1, $param2){
        $_loc3_ = intval($param2 / Config::get('constants.quest_energy_refill_amount'));
        $_loc4_ = 0;
        switch($_loc3_)
        {
            case 0:
                $_loc4_ = Config::get('constants.quest_energy_refill1_cost_factor');
                break;
            case 1:
                $_loc4_ = Config::get('constants.quest_energy_refill2_cost_factor');
                break;
            case 2:
                $_loc4_ = Config::get('constants.quest_energy_refill3_cost_factor');
                break;
            case 3:
                $_loc4_ = Config::get('constants.quest_energy_refill4_cost_factor');
        }
        $_loc5_ = $_loc4_ * Utils::coinsPerTime($param1);
        return round($_loc5_);
    }
    
    public static function getTrainingInstantFinishCost($iterations){
        if($iterations % 2 != 0)
        {
            $iterations++;
        }
        return $iterations / 2;
    }
      
    public static function getTrainingStartPremiumCurrencyCost($iterations){
        if($iterations <= 1)
        {
            return 0;
        }
        if($iterations % 2 != 0)
        {
            $iterations++;
        }
        return $iterations / 2;
    }
    
    public static function getGuildDungeonBattleAttackTimestamp($param1)
    {
        $_loc2_ = intval(date('H'));
        $_loc3_ = Config::get('constants.guild_dungeon_preparation_time');
        switch($param1)
        {
            case 1:
               return $_loc2_ >= 12 - $_loc3_?intval(Utils::calculateGuildBattleAttackTimestamp(12,true)):intval(Utils::calculateGuildBattleAttackTimestamp(12,false));
            case 2:
               return $_loc2_ >= 16 - $_loc3_?intval(Utils::calculateGuildBattleAttackTimestamp(16,true)):intval(Utils::calculateGuildBattleAttackTimestamp(16,false));
            case 3:
               return $_loc2_ >= 18 - $_loc3_?intval(Utils::calculateGuildBattleAttackTimestamp(18,true)):intval(Utils::calculateGuildBattleAttackTimestamp(18,false));
            case 4:
               return $_loc2_ >= 20 - $_loc3_?intval(Utils::calculateGuildBattleAttackTimestamp(20,true)):intval(Utils::calculateGuildBattleAttackTimestamp(20,false));
            case 5:
               return $_loc2_ >= 22 - $_loc3_?intval(Utils::calculateGuildBattleAttackTimestamp(22,true)):intval(Utils::calculateGuildBattleAttackTimestamp(22,false));
            default:
               return 0;
        }
    }
    
    public static function guildBattleHonorWinReward($param1, $param2){
         return self::duelHonorWinReward($param1,$param2) * 10;
    }
      
    public static function guildBattleHonorLostReward($param1, $param2){
         return self::duelHonorLostReward($param1,$param2) * 10;
    }
    
    //$param1 - all_stages | $param2 - max_stage
    public static function getQuestRefreshCost($param1, $param2){
        $_loc3_ = Config::get('constants.quest_refresh_single_stage_premium_currency_amount');
        $_loc4_ = Config::get('constants.quest_refresh_all_stages_reduction_factor');
        if(!$param1)
        {
            return $_loc3_;
        }
        return round($_loc3_ + $param2 * $_loc4_);
    }
}