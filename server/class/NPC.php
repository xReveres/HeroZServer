<?php
namespace Cls;

use Cls\Entity;
use Srv\Config;
use Cls\Utils\QuestList;

class NPC extends Entity{
    
    public $identifier = '';
    
    public function loadNPC($identifier){
        $this->identifier = $identifier;
    }
    
    public function randomiseQuestStats($player, $difficulty){
        $diffName = QuestList::$DIFFICULTY[$difficulty];
        $percMin = Config::get("constants.fight_quest_npc_stat_percentage_min_{$diffName}");
        $percMax = Config::get("constants.fight_quest_npc_stat_percentage_max_{$diffName}");
        $this->level = $player->getLVL();
        $this->stamina = round($player->character->stat_total_stamina * random($percMin, $percMax));
        $this->strength = round($player->character->stat_total_strength * random($percMin, $percMax));
        $this->criticalrating = round($player->character->stat_total_critical_rating * random($percMin, $percMax));
        $this->dodgerating = round($player->character->stat_total_dodge_rating * random($percMin, $percMax));
        $this->weapondamage = 0;
        $this->hitpoints = $this->stamina * Config::get('constants.battle_hp_scale');
        $this->damage_normal = $this->strength + $this->weapondamage;
        $this->damage_bonus = $this->damage_normal;
    }
    
}