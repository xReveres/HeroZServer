<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class startQuest{
    
    public function __request($player){
        if($player->character->active_quest_id != 0)
            return Core::setError('errStartQuestActiveQuestFound');
        if($player->character->active_work_id != 0)
            return Core::setError('errStartQuestActiveWorkFound');
        if(!$player->hasMultitasking() && $player->character->active_training_id != 0)
            return Core::setError('errStartQuestActiveTrainingFound');
            
        $quest_id = intval(getField('quest_id', FIELD_NUM));
        
        $quest = $player->getQuestById($quest_id);
        if($quest == null)
            return Core::setError('invQuestId');
        if($quest->status != 1)
            return Core::setError('errStartQuestActiveQuestFound');
        if($quest->stage != $player->character->current_quest_stage)
            return Core::setError('invQuestStage');
        
        if($player->character->quest_energy < $quest->energy_cost)
			return Core::setError("errRemoveQuestEnergyNotEnough");
		
		$tsComplete = $quest->duration;
		$energy = $quest->energy_cost;
		$boostSum = 0;
		if(($booster = $player->getBoosters('quest')) != null)
		    $boostSum += Config::get("constants.boosters.$booster.amount");
		    
        if($player->character->guild_id != 0 && ($booster = $player->guild->getBoosters('quest')) != null)
            $boostSum += Config::get("constants.guild_boosters.$booster.amount");
		
		if($boostSum > 0){
            $val = (1 - ($boostSum/100));
            $tsComplete = round($tsComplete * $val);
            $energy = round($energy * $val);
		}
		
		$tsComplete += time();
		
		$quest->ts_complete = $tsComplete;
		$quest->energy_cost = $energy;
		$quest->status = 2;
		$player->character->active_quest_id = $quest->id;
		$player->character->quest_energy -= $energy;
		
		Core::req()->data = array(
		    "character"=>$player->character,
		    "quest"=>['id'=>$quest->id,'status'=>$quest->status,'ts_complete'=>$quest->ts_complete]
		);
    }
}