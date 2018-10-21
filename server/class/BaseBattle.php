<?php
namespace Cls;

use Cls\Entity;
use Schema\Battle;
use Cls\Fight;

class BaseBattle{
    protected $op1 = null; //a
    protected $op2 = null; //b
    protected $rounds = [];
    protected $winner = null; //a|b
    protected $fight = null;
    protected $a_rewards = '';
    protected $b_rewards = '';
    protected $characterAStats = null;
    protected $characterBStats = null;
    public $battle = null;
    public $duel = null;
    
    //@Player           $op1 - Ten kto rozpoczął walke
    //@Player | @NPC    $op2 - Ten kto jest atakowany
    public function __construct($op1, $op2){
        $this->op1 = $op1;
        $this->op2 = $op2;
        $this->op1->profile = 'a';
        $this->op2->profile = 'b';
        $this->fight = new Fight($this->op1, $this->op2);
        $this->characterAStats = $this->characterAStats();
        $this->characterBStats = $this->characterBStats();
    }
    
    //@Override
    public function start(){}
    
    public function characterAStats(){
        return cast($this->op1, '\Cls\Entity');
    }
    
    public function characterBStats(){
        return cast($this->op2, '\Cls\Entity');
    }
    
    //@Override
    public function characterAAppearance(){}
    
    //@Override
    public function characterBAppearance(){}
    
    protected function saveBattle(){
        $this->battle = new Battle([
            'ts_creation'=>time(),
            'profile_a_stats'=>json_encode($this->characterAStats),
            'profile_b_stats'=>json_encode($this->characterBStats),
            'winner'=>$this->winner,
            'rounds'=>json_encode($this->rounds)
        ]);
        $this->battle->save();
    }
}