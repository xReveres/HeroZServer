<?php
namespace Cls;

use Schema\GuildDungeon as GDungeon;
use Srv\Config;

class GuildDungeon{
    
    private $guild = null;
    private $dungeon = null;
    
    public function __construct($guild, $dungeon){
        $this->guild = $guild;
        $this->dungeon = empty($dungeon)?null:$dungeon;
    }
    
    public function lockDungeon($player){
        if($this->dungeon == null)
            $this->randomiseDungeon(true);
        if(strlen($this->dungeon->locking_character_name) > 0 && $this->dungeon->ts_unlock > time())
            return $this->dungeon->locking_character_name;
        $this->dungeon->locking_character_name = $player->character->name;
        $this->dungeon->ts_unlock = time() + Config::get('constants.guild_dungeon_selection_lock_time');
        return true;
    }
    
    public function checkLockedDungeon($player){
        if(strlen($this->dungeon->locking_character_name) > 0 && $this->dungeon->locking_character_name == $player->character->name && $this->dungeon->ts_unlock > time())
            return true;
        return false;
    }
    
    public function unlockDungeon(){
        if($this->dungeon == null)
            return;
        $this->dungeon->locking_character_name = '';
        $this->dungeon->ts_unlock = 0;
    }
    
    public function getBattle(){
        return $this->dungeon;
    }
    
    public function getRerollCount(){
        return $this->dungeon->getRerollCount();
    }
    
    public function randomiseDungeon($resetRerollCount){
        $teamid = mt_rand(1, 28);
        $difficulty = random_between([
            1=>Config::get('constants.guild_dungeon_enemy_chance_easy'),
            2=>Config::get('constants.guild_dungeon_enemy_chance_medium'),
            3=>Config::get('constants.guild_dungeon_enemy_chance_hard')
        ]);
        switch($difficulty){
            case 1:
                $factor_min = Config::get('constants.guild_dungeon_reward_factor_start');
                $factor_max = Config::get('constants.guild_dungeon_reward_factor_medium');
            break;
            case 2:
                $factor_min = Config::get('constants.guild_dungeon_reward_factor_easy');
                $factor_max = Config::get('constants.guild_dungeon_reward_factor_hard');
            break;
            case 3:
                $factor_min = Config::get('constants.guild_dungeon_reward_factor_medium');
                $factor_max = Config::get('constants.guild_dungeon_reward_factor_end');
            break;
        }
        $rewards = [
            1=>round(random($factor_min, $factor_max), 2),    //Player coins
            2=>round(random($factor_min, $factor_max), 2),    //Player xp
            3=>0,   //Guild premium
            4=>0,   //Guild improvement points
            5=>0,    //Guild missiles
            6=>0   //Player item
        ];
        $data = [
            'guild_id'=> $this->guild->id,
            'npc_team_identifier'=> "team{$teamid}",
            'ts_unlock'=> time() + Config::get('constants.guild_dungeon_selection_lock_time'),
            'settings'=>json_encode([
                'rewards'=>$rewards,
                'reroll_count'=>$resetRerollCount?0:$this->dungeon->getRerollCount()+1,
                'difficulty'=>$difficulty
            ])
        ];
        if($this->dungeon == null){
            $this->dungeon = new GDungeon($data);
            $this->dungeon->save();
        }else{
            $this->dungeon->setData($data);
        }
    }
    
    public static function find($guild){
        $dungeon = GDungeon::find(function($q)use($guild){ $q->where('guild_id',$guild->id); });
        $dungeon = new GuildDungeon($guild, $dungeon);
        return $dungeon;
    }
}