<?php
namespace Cls;

use Cls\BaseBattle;

class QuestBattle extends BaseBattle{
    
    public function start(){
        $this->fight->fight();
        $this->rounds = [
            'rounds'=>$this->fight->getRounds(),
            'profile_a_appearance'=>$this->characterAAppearance(),
            'profile_b_appearance'=>$this->characterBAppearance()
        ];
        $this->winner = $this->fight->getWinner()==1?'a':'b';
    }

    public function characterAAppearance(){
        return null;
    }
    
    public function characterBAppearance(){
        return null;
    }
    
    public function save(){
        $this->saveBattle();
    }
}