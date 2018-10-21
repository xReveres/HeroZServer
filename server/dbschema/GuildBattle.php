<?php
namespace Schema;

use Srv\Record;

class GuildBattle extends Record{
    protected static $_TABLE = 'guild_battle';
    
    public function getAttackerCharacterIds(){
        return json_decode($this->attacker_character_ids,TRUE);
    }
    
    public function getDefenderCharacterIds(){
        return json_decode($this->defender_character_ids,TRUE);
    }
    
    public function removePlayerFromBattleAttack($player){
        $playerid = is_numeric($player)?$player:$player->character->id;
        $players = json_decode($this->attacker_character_ids, true);
        foreach($players as $k=>$chid) if($chid == $playerid) unset($players[$k]);
        $this->attacker_character_ids = json_encode(array_values($players));
    }
    
    public function removePlayerFromBattleDefense($player){
        $playerid = is_numeric($player)?$player:$player->character->id;
        $players = json_decode($this->defender_character_ids, true);
        foreach($players as $k=>$chid) if($chid == $playerid) unset($players[$k]);
        $this->defender_character_ids = json_encode(array_values($players));
    }
    
    public function addPlayerToBattleAttack($player){
        $players = json_decode($this->attacker_character_ids, true);
        if(in_array($player->character->id, $players))
            return FALSE;
        $players[] = $player->character->id;
        $this->attacker_character_ids = json_encode(array_values($players));
        return TRUE;
    }
    
    public function addPlayerToBattleDefense($player){
        $players = json_decode($this->defender_character_ids, true);
        if(in_array($player->character->id, $players))
            return FALSE;
        $players[] = $player->character->id;
        $this->defender_character_ids = json_encode(array_values($players));
        return TRUE;
    }
    
    public function getDataForAttacker(){
        if($this->status == 1)
            return array_merge($this->getData(['id','status','ts_attack','battle_time','guild_attacker_id','guild_defender_id']), ['character_ids'=>$this->attacker_character_ids]);
        return array_merge($this->getData(), ['character_ids'=>$this->attacker_character_ids]);
    }
    
    public function getDataForDefender(){
        if($this->status == 1)
            return array_merge($this->getData(['id','status','ts_attack','battle_time','guild_attacker_id','guild_defender_id']), ['character_ids'=>$this->defender_character_ids]);
        return array_merge($this->getData(), ['character_ids'=>$this->defender_character_ids]);
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'status' => 1,
        'battle_time' => 0,
        'ts_attack' => 0,
        'guild_attacker_id' => 0,
        'guild_defender_id' => 0,
        'attacker_character_ids' => '[]' ,
        'defender_character_ids' => '[]' ,
        'guild_winner_id' => 0,
        'attacker_character_profiles' => '' ,
        'defender_character_profiles' => '' ,
        'rounds' => '' ,
        'attacker_rewards' => '' ,
        'defender_rewards' => '' ,
        'initiator_character_id' => 0
    ];
}