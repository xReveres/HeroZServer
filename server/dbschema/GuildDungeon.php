<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class GuildDungeon extends Record implements JsonSerializable{
    protected static $_TABLE = 'guild_dungeon';
    
    public function getSettings(){
        return json_decode($this->settings, TRUE);
    }
    
    public function getReward(){
        return $this->getSettings()['rewards'];
    }
    
    public function getRerollCount(){
        return $this->getSettings()['reroll_count'];
    }
    
    public function getDifficulty(){
        return $this->getSettings()['difficulty'];
    }
    
    public function jsonSerialize(){
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id'=>0,
        'guild_id'=>0,
        'npc_team_identifier'=>'',
        'npc_team_character_profiles'=>'',
        'settings'=>'',
        'ts_unlock'=>0,
        'locking_character_name'=>''
    ];
}