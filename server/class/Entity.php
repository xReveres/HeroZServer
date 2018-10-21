<?php
namespace Cls;

use JsonSerializable;

class Entity implements JsonSerializable{
    
    public $profile = '';
    public $level = 0;
    public $stamina = 0;
    public $total_stamina = 0;
    public $strength = 0;
    public $criticalrating = 0;
    public $dodgerating = 0;
    public $weapondamage = 0;
    public $hitpoints = 0;
    //public $start_hitpoints = 0; To moge dać w klasie NPC.php tak samo zamiast Entity to NPC używać w GuildDungeonBattle
    public $damage_normal = 0;
    public $damage_bonus = 0;
    //
    public $chance_critical = 0;
    public $chance_dodge = 0;
    //GuildMissiles
    private $guildmissile = 0; //0 disabled 1 enabled 2 used
    private $itemMissile = null;
    
    public function jsonSerialize(){
        return get_public_vars($this);
    }
    
    public function useGuildMissile(){
        if($this->guildmissile == 0 || $this->guildmissile == 2)
            return FALSE;
        $this->guildmissile = 2;
        return TRUE;
    }
    public function enableGuildMissile(){
        $this->guildmissile = 1;
    }
    
    public function getMissile(){
        return $this->itemMissile;
    }
    public function setMissile($missile){
        $this->itemMissile = $missile;
    }
    
    public function loadFromAppearanceArray($a){
        if(isset($a['profile']))
            $this->profile = $a['profile'];
        if(isset($a['level']))
            $this->level = $a['level'];
        if(isset($a['stamina']))
            $this->stamina = $a['stamina'];
        if(isset($a['total_stamina']))
            $this->total_stamina = $a['total_stamina'];
        if(isset($a['strength']))
            $this->strength = $a['strength'];
        if(isset($a['criticalrating']))
            $this->criticalrating = $a['criticalrating'];
        if(isset($a['dodgerating']))
            $this->dodgerating = $a['dodgerating'];
        if(isset($a['weapondamage']))
            $this->weapondamage = $a['weapondamage'];
        if(isset($a['hitpoints']))
            $this->hitpoints = $a['hitpoints'];
        if(isset($a['start_hitpoints']))
            $this->start_hitpoints = $a['start_hitpoints'];
        if(isset($a['damage_normal']))
            $this->damage_normal = $a['damage_normal'];
        if(isset($a['damage_bonus']))
            $this->damage_normal = $a['damage_bonus'];
        if(isset($a['damage_bonus']))
            $this->damage_normal = $a['damage_bonus'];
        if(isset($a['damage_bonus']))
            $this->damage_normal = $a['damage_bonus'];
    }
}