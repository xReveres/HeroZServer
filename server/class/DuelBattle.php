<?php
namespace Cls;

use Cls\BaseBattle;
use Cls\Utils;
use Schema\Duel;
use Cls\Utils\Item;
use Srv\Config;

class DuelBattle extends BaseBattle{
    
    public function start(){
        $this->fight->fight();
        $this->rounds = [
            'rounds'=>$this->fight->getRounds(),
            'profile_a_appearance'=>$this->characterAAppearance(),
            'profile_b_appearance'=>$this->characterBAppearance()
        ];
        if($this->fight->getWinner() == 1){
            $coins = Utils::duelCoinWinReward($this->op2->getLVL());
            if($this->op1->character->guild_id != 0 && ($booster = $this->op1->guild->getBoosters('duel')) != null)
                $coins = round($coins * ((100+Config::get("constants.guild_boosters.$booster.amount"))/100));
            $this->a_rewards = Utils::rewards($coins, 0, Utils::duelHonorWinReward($this->op1->getHonor(), $this->op2->getHonor()));
            $this->b_rewards = Utils::rewards(0, 0, Utils::duelHonorLostReward($this->op1->getHonor(), $this->op2->getHonor()));
            $this->winner = 'a';
        }else{
            $coins = Utils::duelCoinWinReward($this->op1->getLVL());
            if($this->op2->character->guild_id != 0 && ($booster = $this->op2->guild->getBoosters('duel')) != null)
                $coins = round($coins * ((100+Config::get("constants.guild_boosters.$booster.amount"))/100));
            $this->a_rewards = Utils::rewards(0, 0, Utils::duelHonorLostReward($this->op2->getHonor(), $this->op1->getHonor()));
            $this->b_rewards = Utils::rewards($coins, 0, Utils::duelHonorWinReward($this->op2->getHonor(), $this->op1->getHonor()));
            $this->winner = 'b';
        }
    }
    
    public function characterAAppearance(){
        return $this->characterAppearance($this->op1);
    }
    
    public function characterBAppearance(){
        return $this->characterAppearance($this->op2);
    }
    
    private function characterAppearance($op){
        $data = [
            'name'=> $op->character->name,
			'gender'=> $op->character->gender,
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
			'show_mask'=> $op->character->show_mask,
        ];
        $eqItems = $op->getOnlyEquipedItems()['items'];
        foreach($eqItems as $it){
            if($it->type == 7 || $it->type == 6)
                continue;
            $data[Item::$TYPE[$it->type]] = $it->identifier;
        }
        return $data;
    }

    private function saveDuel(){
        $this->duel = new Duel([
            'ts_creation'=>time(),
            'battle_id'=>$this->battle->id,
            'character_a_id'=>$this->op1->character->id,
            'character_b_id'=>$this->op2->character->id,
            'character_a_rewards'=>$this->a_rewards,
            'character_b_rewards'=>$this->b_rewards
        ]);
        $this->duel->save();
    }
    
    public function save(){
        $this->saveBattle();
        $this->saveDuel();
    }
}