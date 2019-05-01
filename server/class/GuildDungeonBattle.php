<?php
namespace Cls;

use Schema\GuildDungeonBattle as GDungeonBattle;
use Cls\Entity;
use Cls\Fight;

class GuildDungeonBattle{
    
    public $isFought = false;
    public $battle = null;
    public $gAttacker = null;
    public $nDefender = null; //NPC
    public $aMemberIndex = 0;
    public $nMemberIndex = 0; //NPC
    private $attackerAppearances = [];
    private $defenderAppearances = []; //NPC
    
    public function __construct($battle, $gAttacker){
        $this->battle = $battle;
        $this->gAttacker = $gAttacker;
        $this->nDefender = new NPCGroup();
        $this->isFought = $this->checkFight();
    }
    
    public function checkFight(){
        if($this->battle->ts_attack > time() || $this->battle->status == 3)
            return FALSE;
        $this->nDefender->loadFromBattle($this->battle);
        //TODO: Kolejnosc memberow z $gAttacker ... itd. jak w GuildsBattle
        $gAMembers = $this->gAttacker->getMembers($this->battle->getAttackerCharacterIds());
        $gNMembers = $this->nDefender->getMembers();
        $memberA=null; $memberB=null; $winner=0; $rounds=[];
        while(true){
            if($memberA == null || $memberA->player->hitpoints <= 0){
                if(isset($gAMembers[$this->aMemberIndex]))
                    $memberA = $this->prepareNextAMemberForBattle($gAMembers);
                else $winner = 2;//B guild win
            }
            if($memberB == null || $memberB->player->hitpoints <= 0){
                if(isset($gNMembers[$this->nMemberIndex]))
                    $memberB = $this->prepareNextBMemberForBattle($gNMembers);
                else $winner = 1;//A guild win
            }
            if($winner != 0)
                break;
            $fight = new Fight($memberA->player, $memberB->player, TRUE);
            $fight->fight();
            $rounds = array_merge($rounds, $fight->getRounds());
        }
    }
    
    private function prepareNextAMemberForBattle($members){
        $member = $members[$this->aMemberIndex];
        $member->player->profile = $member->player->character->id;
        $this->attackerAppearances[$member->player->character->id] = $this->characterAppearance($member->player, $this->aMemberIndex);
        $this->aMemberIndex++;
        return $member;
    }
    private function prepareNextBMemberForBattle($members){
        $member = $members[$this->nMemberIndex];
        $member->player->profile = $member->player->character->id;
        $this->defenderAppearances[] = $this->characterAppearance($member->player, $this->nMemberIndex);
        $this->nMemberIndex++;
        return $member;
    }
    
    private function characterAppearance($op, $counter){
        $data = [
            'profile'=> $op->profile,
            'name'=> $op->character->name,
            'gender'=> $op->character->gender,
            'level'=> $op->getLVL(),
            'position'=> $counter+1,
            'stamina'=> $op->stamina,
            'total_stamina'=> $op->total_stamina,
            'strength'=> $op->strength,
            'criticalrating'=> $op->criticalrating,
            'dodgerating'=> $op->dodgerating,
            'weapondamage'=> $op->weapondamage,
            'appearance_skin_color'=> $op->character->appearance_skin_color,
            'appearance_hair_color'=> $op->character->appearance_hair_color,
            'appearance_hair_type'=> $op->character->appearance_hair_type,
            'appearance_head_type'=> $op->character->appearance_head_type,
            'appearance_eyes_type'=> $op->character->appearance_eyes_type,
            'appearance_eyebrows_type'=> $op->character->appearance_eyebrows_type,
            'appearance_nose_type'=> $op->character->appearance_nose_type,
            'appearance_mouth_type'=> $op->character->appearance_mouth_type,
            'appearance_facial_hair_type'=> $op->character->appearance_facial_hair_type,
            'appearance_decoration_type'=> $op->character->appearance_decoration_type,
            'show_mask'=> $op->character->show_mask
        ];
        $eqItems = $op->getOnlyEquipedItems()['items'];
        foreach($eqItems as $it){
            if($it->type == 7 || $it->type == 6)
                continue;
            $data[Item::$TYPE[$it->type]] = $it->identifier;
        }
        return $data;
    }
    
    private function NPCAppearance($op, $counter){
        $data = [
            'profile'=> $op->profile,
            'level'=> $op->getLVL(),
            'stamina'=> $op->stamina,
            'strength'=> $op->strength,
            'criticalrating'=> $op->criticalrating,
            'dodgerating'=> $op->dodgerating,
            'weapondamage'=> $op->weapondamage,
            ''
        ];
        return $data;
    }
    
    public static function findPending($guild){
        $battle = GDungeonBattle::find(function($q)use($guild){ $q->where('guild_id',$guild->id)->where('status',1); });
        if($battle == NULL)
            return NULL;
        $pending = new GuildDungeonBattle($battle, $guild);
        return $pending;
    }
    
    public static function findFinished($guild){
        $battle = GDungeonBattle::find(function($q)use($guild){ $q->where('guild_id',$guild->id)->where('status',3); });
        if($battle == NULL)
            return NULL;
        $pending = new GuildDungeonBattle($battle, $guild);
        return $pending;
    }
}

class NPCGroup{
    private $members = [];
    
    public function randomiseDungeonNPCS($battle){
        //TODO: Generowanie NPC npc_team_character_profiles puste (gdy 1 bitwa w dungeonie)
        $battle->npc_team_character_profiles = json_encode($this->members);
    }
    
    public function loadFromBattle($battle){
        if(empty($battle->npc_team_character_profiles))
            $this->randomiseDungeonNPCS($battle);
        else{
            $appearances = json_decode($battle->npc_team_character_profiles, true);
            foreach($appearances as $appear){
                $ent = new Entity();
                $ent->loadFromAppearanceArray($appear);
                $this->members[] = $ent;
            }
        }
    }
    
    public function getMembers(){
        return $this->members;
    }
}