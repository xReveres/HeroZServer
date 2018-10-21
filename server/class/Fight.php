<?php
namespace Cls;

use Srv\Config;
use Cls\Player;
use Cls\NPC;
use Cls\Utils;

class Fight{
    public static $ATTACK_TYPE = [
        0=>'unknown',
        1=>'dodged',
        2=>'normalhit',
        3=>'criticalhit',
        4=>'guildmissilenormalhit',
        5=>'guildmissilecriticalhit'
    ];
    public static $ATTACK_TYPE_ID = [
        'dodged'=>1,
        'normalhit'=>2,
        'criticalhit'=>3,
        'guildmissilenormalhit'=>4,
        'guildmissilecriticalhit'=>5
    ];
    
    private $op1 = null;
    private $op2 = null;
    private $rounds = [];
    private $winner = 0;
    private $critFact = 0;
    private $isGuildFight = false;
    private $missileFactor = 1;
    private $missilesUsed = false;
    
    public function __construct($op1, $op2, $guildFight=false){
        $this->op1 = $op1;
        $this->op2 = $op2;
        $this->isGuildFight = $guildFight;
        //
        $this->op1->chance_critical = Utils::getCriticalHitPercentage($this->op1->criticalrating, $this->op2->criticalrating);
        $this->op2->chance_critical = Utils::getCriticalHitPercentage($this->op2->criticalrating, $this->op1->criticalrating);
        $this->op1->chance_dodge = Utils::getDodgePercentage($this->op1->dodgerating, $this->op2->dodgerating);
        $this->op2->chance_dodge = Utils::getDodgePercentage($this->op2->dodgerating, $this->op1->dodgerating);
        //
        $this->critFact = Config::get('constants.battle_critical_factor');
        $this->missileFactor = Config::get('constants.guild_battle_missile_damage_factor');
    }
    
    public function fight(){
        $attacker = $this->op1;
        $attacker_canmissile = $this->isGuildFight && $attacker->useGuildMissile() && $attacker->guild->missiles > 0 && $attacker->guild->use_missiles_attack;
        if($attacker_canmissile){
            $attacker->guild->missiles--;
            $attacker->guild->missiles_fired++;
        }
        
        $opponent = $this->op2;
        $opponent_canmissile = $this->isGuildFight && $opponent->useGuildMissile() && $opponent->guild->missiles > 0 && $opponent->guild->use_missiles_defense;
        if($opponent_canmissile){
            $opponent->guild->missiles--;
            $opponent->guild->missiles_fired++;
        }
        //Walka
        $rand = random() < 0.5;
        do{
            if($rand){
                if($attacker->hitpoints > 0)
                    $this->hit($attacker, $opponent, $attacker_canmissile);
                if($opponent->hitpoints > 0)
                    $this->hit($opponent, $attacker, $opponent_canmissile);
            }else{
                if($opponent->hitpoints > 0)
                    $this->hit($opponent, $attacker, $opponent_canmissile);
                if($attacker->hitpoints > 0)
                    $this->hit($attacker, $opponent, $attacker_canmissile);
            }
        }while($attacker->hitpoints > 0 && $opponent->hitpoints > 0);
        if($this->op1->hitpoints > 0)
            $this->winner = 1;
        else
            $this->winner = 2;
    }
    
    private function hit($attacker, $issuer, $use_missile){
        if($this->isGuildFight)
            $roundData = ['a'=> (string)$attacker->profile, 'd'=>(string)$issuer->profile];
        else
            $roundData = ['a'=> $attacker->profile];

        if(!$use_missile && round(random(), 3) < $issuer->chance_dodge)
            $roundData['r'] = static::$ATTACK_TYPE_ID['dodged'];
        else{
            if($use_missile)
                $roundData['r'] = static::$ATTACK_TYPE_ID['guildmissilenormalhit'];
            else{
                $roundData['r'] = static::$ATTACK_TYPE_ID['normalhit'];
                if($attacker->getMissile() && $attacker->getMissile()->charges > 0){
                    $roundData['m'] = 1;
                    $attacker->getMissile()->charges--;
                    $this->missilesUsed = true;
                }
            }
            $hitpoints = random(0.8,1.05)*$attacker->damage_normal*($use_missile?$this->missileFactor:1);
            if(round(random(), 3) < $attacker->chance_critical){
                $hitpoints = round($hitpoints * $this->critFact);
                $roundData['r'] = $use_missile?static::$ATTACK_TYPE_ID['guildmissilecriticalhit']:static::$ATTACK_TYPE_ID['criticalhit'];
            }
            //$roundData['m'] - Użycie pocisku/broni rzucanej
            $hitpoints = round($hitpoints);
            $roundData['v'] = $hitpoints;
            $issuer->hitpoints -= $hitpoints;
        }
        
        $this->rounds[] = $roundData;
    }
    
    public function getWinner(){
        return $this->winner;
    }
    
    public function getRounds(){
        return $this->rounds;
    }
    
    public function isMissileUsed(){
        return $this->missilesUsed;
    }
}