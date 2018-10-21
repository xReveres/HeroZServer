<?php
namespace Cls;

use Srv\Core;
use Cls\Utils;
use Schema\GuildBattle;
use Cls\Guild;
use JsonSerializable;
use Cls\Fight;
use Cls\Utils\Item;
use Schema\GuildBattleRewards;
use Cls\Utils\GuildLogType;

class GuildsBattle{
    
    public $isFought = false;
    public $battle = null;
    public $gAttacker = null;
    public $gDefender = null;
    private $aMemberIndex = 0;
    private $bMemberIndex = 0;
    private $attackerAppearances = [];
    private $defenderAppearances = [];
    
    //$type - 1.$gAttacker, 2.$gDefender
    public function __construct($battle, $gAttacker, $gDefender){
        $this->battle = $battle;
        $this->gAttacker = $gAttacker;
        $this->gDefender = $gDefender;
        $this->isFought = $this->checkFight();
    }
    
    public function checkFight(){
        if($this->battle->ts_attack > time() || $this->battle->status == 3)
            return FALSE;
        $gAMembers = $this->memberOrder($this->gAttacker->getMembers($this->battle->getAttackerCharacterIds()), $this->gAttacker->guild_battle_tactics_attack_order);
        $gBMembers = $this->memberOrder($this->gDefender->getMembers($this->battle->getDefenderCharacterIds()), $this->gDefender->guild_battle_tactics_defense_order);
        /*if(count($gAMembers)==0 && count($gBMembers)==0){
            $this->battle->status = 3;
            return TRUE;
        }*/
        $this->processOrderTactic($gAMembers, $this->gAttacker->guild_battle_tactics_attack_order, $this->gAttacker->guild_battle_tactics_attack_tactic);
        $this->processOrderTactic($gBMembers, $this->gDefender->guild_battle_tactics_defense_order, $this->gDefender->guild_battle_tactics_defense_tactic);
        $memberA=null; $memberB=null; $winner=0; $rounds=[];
        while(true){
            if($memberA == null || $memberA->player->hitpoints <= 0){
                if(isset($gAMembers[$this->aMemberIndex]))
                    $memberA = $this->prepareNextAMemberForBattle($gAMembers);
                else $winner = 2;//B guild win
            }
            if($memberB == null || $memberB->player->hitpoints <= 0){
                if(isset($gBMembers[$this->bMemberIndex]))
                    $memberB = $this->prepareNextBMemberForBattle($gBMembers);
                else $winner = 1;//A guild win
            }
            if($winner != 0)
                break;
            $fight = new Fight($memberA->player, $memberB->player, TRUE);
            $fight->fight();
            $rounds = array_merge($rounds, $fight->getRounds());
        }
        $this->battle->rounds = count($rounds)?json_encode($rounds):'';
        $this->battle->attacker_character_profiles = json_encode($this->attackerAppearances);
        $this->battle->defender_character_profiles = json_encode($this->defenderAppearances);
        $this->battle->status = 3;
        $this->gAttacker->pending_guild_battle_attack_id = 0;
        $this->gDefender->pending_guild_battle_defense_id = 0;
        if($winner == 1){
            $winReward = Utils::guildBattleHonorWinReward($this->gAttacker->honor, $this->gDefender->honor);
            $loseReward = Utils::guildBattleHonorLostReward($this->gAttacker->honor, $this->gDefender->honor);
            $this->battle->attacker_rewards = Utils::rewards(0,0, $winReward);
            $this->gAttacker->giveHonor($winReward);
            $this->battle->defender_rewards = Utils::rewards(0,0, $loseReward);
            $this->gDefender->giveHonor($loseReward);
            $this->battle->guild_winner_id = $this->gAttacker->id;
            $tsBattle = $this->battle->ts_attack;
            $this->gAttacker->addLog(null, GuildLogType::GuildBattle_BattleWon, $this->gDefender->id, $this->gDefender->name, $tsBattle);
            $this->gDefender->addLog(null, GuildLogType::GuildBattle_BattleLost, $this->gAttacker->id, $this->gAttacker->name, $tsBattle);
            $this->gAttacker->battles_attacked++;
            $this->gAttacker->battles_won++;
            $this->gDefender->battles_defended++;
            $this->gDefender->battles_lost++;
        }else if($winner == 2){
            $winReward = Utils::guildBattleHonorWinReward($this->gDefender->honor, $this->gAttacker->honor);
            $loseReward = Utils::guildBattleHonorLostReward($this->gDefender->honor, $this->gAttacker->honor);
            $this->battle->attacker_rewards = Utils::rewards(0,0, $loseReward);
            $this->gAttacker->giveHonor($loseReward);
            $this->battle->defender_rewards = Utils::rewards(0,0, $winReward);
            $this->gDefender->giveHonor($winReward);
            $this->battle->guild_winner_id = $this->gDefender->id;
            $tsBattle = $this->battle->ts_attack;
            $this->gAttacker->addLog(null, GuildLogType::GuildBattle_BattleLost, $this->gDefender->id, $this->gDefender->name, $tsBattle);
            $this->gDefender->addLog(null, GuildLogType::GuildBattle_BattleWon, $this->gAttacker->id, $this->gAttacker->name, $tsBattle);
            $this->gAttacker->battles_attacked++;
            $this->gAttacker->battles_lost++;
            $this->gDefender->battles_defended++;
            $this->gDefender->battles_won++;
        }
        foreach($gAMembers as $member)
            $this->createMembersReward($member, $winner == 1, 1);
        foreach($gBMembers as $member)
            $this->createMembersReward($member, $winner == 2, 2);
        return TRUE;
    }
    
    private function processOrderTactic(&$members, $orderType, $tacticType){
        $missileCount = 0;
        $c = count($members);
        for($i=0; $i < $c; $i++){
            $member = &$members[$i];
            if( (($orderType == 2 || $orderType == 4) && $i < 5) || (($orderType == 1 || $orderType == 3) && ($c-1) - $i < 5) || ($orderType == 5 && random() < 0.5 && $missileCount < 5)){
                $member->player->enableGuildMissile();
                $missileCount++;
            }
            //if($tacticType == 10)//nie potrzebne, zrównoważona walka
            $hpMult = 1;
            $dmgMult = 1;
            if($tacticType == 11){
                $hpMult = 1.05;
                $dmgMult = 0.925;
            }else if($tacticType == 12){
                $hpMult = 0.925;
                $dmgMult = 1.05;
            }
            $member->player->stamina = round($member->player->stamina * $hpMult);
            $member->player->total_stamina = round($member->player->total_stamina * $hpMult);
            $member->player->hitpoints = round($member->player->hitpoints * $hpMult);
            $member->player->damage_normal = round($member->player->damage_normal * $dmgMult);
        }
    }
    
    private function createMembersReward($member, $hisGuildWin, $type){
        $reward = new GuildBattleRewards([
            'guild_battle_id'=>$this->battle->id,
            'character_id'=>$member->player->character->id,
            'game_currency'=>$hisGuildWin?(floor((random(0.7,0.8) * pow($member->player->getLVL()+10, 2) * 10)/10)*10):0,
            'type'=> $type
        ]);
        $reward->save();
        $member->player->guild->addBattleReward($reward);
    }
    
    private function prepareNextAMemberForBattle($members){
        $member = $members[$this->aMemberIndex];
        $member->player->profile = $member->player->character->id;
        $this->attackerAppearances[$member->player->character->id] = $this->characterAppearance($member->player, $this->aMemberIndex);
        $this->aMemberIndex++;
        return $member;
    }
    private function prepareNextBMemberForBattle($members){
        $member = $members[$this->bMemberIndex];
        $member->player->profile = $member->player->character->id;
        $this->defenderAppearances[$member->player->character->id] = $this->characterAppearance($member->player, $this->bMemberIndex);
        $this->bMemberIndex++;
        return $member;
    }
    
    private function memberOrder($members, $order){
        if($order == 5){
            shuffle($members);
            return $members;
        }else{
            usort($members, function($a, $b)use($order){
                $aPlayer = $a->player->character;
                $bPlayer = $b->player->character;
                if($aPlayer->stat_total == $bPlayer->stat_total)
                    return 0;
                switch($order){
                    case 1: case 2:
                        return $aPlayer->stat_total > $bPlayer->stat_total ? -1 : 1;
                    case 3: case 4:
                        return $aPlayer->stat_total < $bPlayer->stat_total ? -1 : 1;
                }
            });
            return $members;
        }
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
    
    public static function findPendingAttack($guild){
        return static::findAttack($guild, 1);
    }
    
    public static function findPendingDefense($guild){
        return static::findDefense($guild, 1);
    }
    
    public static function findFinishedAttack($guild, $battleid){
        return static::findAttack($guild, 3, $battleid);
    }
    
    public static function findFinishedDefense($guild, $battleid){
        return static::findDefense($guild, 3, $battleid);
    }
    
    private static function findAttack($guild, $status, $battleid=FALSE){
        if(!$battleid)
            $battle = GuildBattle::find(function($q)use($guild, $status){ $q->where('guild_attacker_id',$guild->id)->where('status',$status); });
        else
            $battle = GuildBattle::find(function($q)use($battleid){ $q->where('id',$battleid); });
        if(!$battle)
            return NULL;
        $oppGuild = Guild::find(function($q)use($battle){ $q->where('id',$battle->guild_defender_id); });
        $oppGuild->loadGuildForBattle();
        $statusBefore = $battle->status;
        return new GuildsBattle($battle, $guild, $oppGuild);
    }
    
    private static function findDefense($guild, $status, $battleid=FALSE){
        if(!$battleid)
            $battle = GuildBattle::find(function($q)use($guild, $status){ $q->where('guild_defender_id',$guild->id)->where('status',$status); });
        else
            $battle = GuildBattle::find(function($q)use($battleid){ $q->where('id',$battleid); });
        if(!$battle)
            return NULL;
        $oppGuild = Guild::find(function($q)use($battle){ $q->where('id',$battle->guild_attacker_id); });
        $oppGuild->loadGuildForBattle();
        return new GuildsBattle($battle, $oppGuild, $guild);
    }
}