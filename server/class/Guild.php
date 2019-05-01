<?php
namespace Cls;

use Srv\Core;
use Srv\Config;
use Srv\DB;
use Schema\Character;
use Schema\Guild as DBGuild;
use Cls\GuildMember;
use Schema\GuildLogs;
use Schema\GuildMessages;
use JsonSerializable;
use Cls\GuildsBattle;
use Schema\GuildBattleRewards;
use Cls\GuildDungeon;
use Cls\GuildDungeonBattle;


class Guild extends DBGuild implements JsonSerializable{
    //$status = 1-active | 2-deleted
    
    private $members = [];
    private $pending_attack = null;
    private $pending_defense = null;
    private $finished_attack = null;
    private $finished_defense = null;
    private $battles_rewards = [];
    //
    private $dungeon = null;
    private $pending_dungeon = null;
    private $finished_dungeon = null;
    
    public $battles_fought = 0;
    public $pending_guild_battle_attack_id = 0;
    public $pending_guild_battle_defense_id = 0;
    public $pending_guild_dungeon_battle_attack_id = 0;
    
    public function loadGuild(){
        $this->battles_fought = $this->battles_attacked + $this->battles_defended;
        //
        //======[Guilds Battle]
        //
        $this->pending_attack = GuildsBattle::findPendingAttack($this);
        if($this->pending_attack != null)
            $this->pending_guild_battle_attack_id = $this->pending_attack->battle->id;
        $this->pending_defense = GuildsBattle::findPendingDefense($this);
        if($this->pending_defense != null)
            $this->pending_guild_battle_defense_id = $this->pending_defense->battle->id;
        //
        if($this->pending_attack != null && $this->pending_attack->isFought)
            $this->setAttackPendingAsFinished();
        else{
            $reward = GuildBattleRewards::find(function($q){ $q->where('character_id',Core::player()->character->id)->where('type',1); });
            if($reward){
                $this->finished_attack = GuildsBattle::findFinishedAttack($this, $reward->guild_battle_id);
                $this->addBattleReward($reward);
            }
        }
        if($this->pending_defense != null && $this->pending_defense->isFought)
            $this->setDefensePendingAsFinished();
        else{
            $reward = GuildBattleRewards::find(function($q){ $q->where('character_id',Core::player()->character->id)->where('type',2); });
            if($reward){
                $this->finished_defense = GuildsBattle::findFinishedDefense($this, $reward->guild_battle_id);
                $this->addBattleReward($reward);
            }
        }
        //
        //======[Guilds Dungeon Battle]
        //
        $this->pending_dungeon = GuildDungeonBattle::findPending($this);
        if($this->pending_dungeon != null)
            $this->pending_guild_dungeon_battle_attack_id = $this->pending_dungeon->battle->id;
        /*if($this->pending_dungeon != null && $this->pending_dungeon->isFought)
            $this->setDungeonPendingAsFinished();
        else{
            $reward = GuildBattleRewards::find(function($q){ $q->where('character_id',Core::player()->character->id)->where('type',1); });
            if($reward){
                $this->finished_attack = GuildsBattle::findFinishedAttack($this, $reward->guild_battle_id);
                $this->addBattleReward($reward);
            }
        }*/
    }
    
    public function loadGuildForBattle(){
        $this->battles_fought = $this->battles_attacked + $this->battles_defended;
    }
    
    public function getMoney(){
        return $this->game_currency;
    }
    
    public function getPremium(){
        return $this->premium_currency;
    }
    
    public function giveMoney($money){
        $this->game_currency += $money;
        if($this->game_currency < 0)
            $this->game_currency = 0;
    }
    
    public function givePremium($prem){
        $this->premium_currency += $prem;
        if($this->premium_currency < 0)
            $this->premium_currency = 0;
    }
    
    public function giveHonor($honor){
        $this->honor += $honor;
        if($this->honor < 0)
            $this->honor = 0;
    }
    
    public function getGuildBoosterCostGameCurrency()
    {
        return Config::get("constants.guild_booster_cost_game_currency_per_improvement") * $this->stat_guild_capacity;
    }
      
    public function getGuildBoosterCostPremiumCurrency()
    {
        return Config::get("constants.guild_booster_cost_premium_currency");
    }
    
    public function getBoosters($type=false){
        $b = ["training"=>null, "quest"=>null, "duel"=>null];
        if($this->ts_active_training_boost_expires > time()){
            $b["training"] = $this->active_training_booster_id;
        }
        if($this->ts_active_quest_boost_expires > time()){
            $b["quest"] = $this->active_quest_booster_id;
        }
        if($this->ts_active_duel_boost_expires > time()){
            $b["duel"] = $this->active_duel_booster_id;
        }
        return !$type?$b:$b[$type];
    }
    
    public function totalImprovementPercentage(){
        $maxGuildBasePercentage = Config::get('constants.guild_percentage_total_base');
        $sum = $this->stat_guild_capacity + $this->stat_character_base_stats_boost + $this->stat_quest_xp_reward_boost + $this->stat_quest_game_currency_reward_boost;
        return ($sum / $maxGuildBasePercentage) * 100;
    }
    
    public function addLog($player, $logType, $val1=0, $val2=0, $val3=0){
        $data = [
            'guild_id'=>$this->id,
            'type' => $logType,
            'value1' => (string)$val1,
            'value2' => (string)$val2,
            'value3' => (string)$val3,
            'timestamp' => time(),
        ];
        if(!is_null($player)){
            $data['character_id'] = $player->character->id;
            $data['character_name'] = $player->character->name;
        }
        $guildLog = new GuildLogs($data);
        $guildLog->save();
        if(Core::player()->guild->id == $this->id)
            Core::req()->append['guild_log']["{$guildLog->timestamp}_{$guildLog->id}"] = $guildLog;
    }
    
    public function sendMessage($player, $message, $is_officer, $toCharacterId){
        $guildMsg = new GuildMessages([
            'guild_id' => $this->id,
            'character_from_id' => $player->character->id,
            'character_from_name' => $player->character->name,
            'character_to_id' => $toCharacterId?$toCharacterId:0,
            'is_officer' => $is_officer?1:0,
            'is_private' => $toCharacterId?1:0,
            'message' => $message,
            'timestamp' => time()
        ]);
        $guildMsg->save();
    }
    
    public function getLogs($player, $timestamp=false){
        //DB::sql("DELETE l FROM guild_logs l JOIN (SELECT tt.timestamp FROM guild_logs tt ORDER BY tt.timestamp DESC OFFSET 15 LIMIT 1 ) tt ON l.timestamp < tt.timestamp");
        DB::sql("DELETE FROM `guild_logs` WHERE guild_id={$this->id} AND timestamp < (select timestamp from (select timestamp FROM `guild_logs` WHERE `guild_id`={$this->id} ORDER BY `timestamp` DESC LIMIT 1 OFFSET 19) x)");
        DB::sql("DELETE FROM `guild_messages` WHERE guild_id={$this->id} AND timestamp < (select timestamp from (select timestamp FROM `guild_messages` WHERE `guild_id`={$this->id} ORDER BY `timestamp` DESC LIMIT 1 OFFSET 29) x)");
        $guildLogs = GuildLogs::findAll(function($q)use($timestamp,$player){
            $q->where('guild_id', $this->id);
            if($timestamp)
                $q->where('timestamp','>=',$timestamp)->where('character_id','<>',$player->character->id);
        });
        $guildMessages = GuildMessages::findAll(function($q)use($timestamp,$player){
            $q->where('guild_id', $this->id);
            if($timestamp)
                $q->where('timestamp','>=',$timestamp)->where('character_from_id','<>',$player->character->id);
            $q->where('character_to_id',0)->orWhere(function($q)use($player){
                $q->where('is_private',1)->where('character_to_id',$player->character->id);
            });
            $q->where('is_officer',$player->character->guild_rank<3? 1:0);
        });
        $logs = [];
        foreach($guildLogs as $glog)
            $logs["{$glog->timestamp}_{$glog->id}"] = $glog;
        foreach($guildMessages as $gmsg)
            $logs["{$gmsg->timestamp}_{$gmsg->id}"] = $gmsg;
        return $logs;
    }
    
    public function addMember($member){
        $this->members[] = $member;
    }
    
    public function getMembers($array=FALSE){
        if(!count($this->members)){
            $bypass = Core::player()->character->guild_id == $this->id ? Core::player()->character->id : false;
            if($bypass)
                $this->members[] = new GuildMember(Core::player());
            $members = GuildMember::findAllByGuildId($this->id, $bypass);
            foreach($members as $member){
                $member->player->guild = $this;
                $member->player->calculateStats();
                $this->members[] = $member;
            }
        }
        if(is_bool($array))
            return $this->members;
        else
            return array_filter($this->members, function($val)use($array){ return in_array($val->player->character->id, $array); });
    }
    
    public function getMemberByCharacterId($targetID){
        $members = $this->getMembers();
        foreach($members as $member){
            if($member->player->character->id == $targetID)
                return $member;
        }
        return null;
    }
    
    public function removeMember($member){
        $memberid = is_numeric($member)?$member:$member->player->character->id;
        //
        if($this->pending_attack != null)
            $this->pending_attack->battle->removePlayerFromBattleAttack($memberid);
        if($this->pending_defense != null)
            $this->pending_defense->battle->removePlayerFromBattleDefense($memberid);
        //
        $members = $this->getMembers();
        foreach($members as $i=>$member){
            if($member->player->character->id == $memberid){
                unset($this->members[$i]);
                return true;
            }
        }
        return false;
    }
    
    public function hasNewMember($timestamp){
        return Character::count(function($q)use($timestamp){ $q->where('guild_id',$this->id)->where('ts_guild_joined','>',$timestamp); }) > 0;
    }
    
    public function countMembers(){
        return count($this->getMembers());
    }
    
    public function getDungeon(){
        if($this->dungeon == null)
            $this->dungeon = GuildDungeon::find($this);
        return $this->dungeon;
    }
    
    public function getPendingDungeon(){
        return $this->pending_dungeon;
    }
    
    public function getFinishedDungeon(){
        return $this->finished_dungeon;
    }
    
    public function getPendingAttack(){
        return $this->pending_attack;
    }
    
    public function getPendingDefense(){
        return $this->pending_defense;
    }
    
    public function getFinishedAttack(){
        return $this->finished_attack;
    }
    
    public function getFinishedDefense(){
        return $this->finished_defense;
    }
    
    private function setAttackPendingAsFinished(){
        $this->finished_attack = $this->pending_attack;
        $this->pending_guild_battle_attack_id = 0;
        $this->pending_attack = null;
    }
    
    private function setDefensePendingAsFinished(){
        $this->finished_defense = $this->pending_defense;
        $this->pending_guild_battle_defense_id = 0;
        $this->pending_defense = null;
    }
    
    public function getBattleRewards(){
        return $this->battles_rewards;
    }
    
    public function addBattleReward($reward){
        $this->battles_rewards[] = $reward;
    }
    
    public function jsonSerialize(){
        return array_merge(parent::jsonSerialize(), get_public_vars($this));
    }
}