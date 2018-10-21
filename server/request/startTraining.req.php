<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;
use Schema\Training;

class startTraining{
    
    public function __request($player){
        if(!$player->hasMultitasking() && $player->character->active_quest_id != 0)
            return Core::setError('errStartQuestActiveQuestFound');
        if($player->character->active_work_id != 0)
            return Core::setError('errStartQuestActiveWorkFound');
        if($player->character->active_training_id != 0)
            return Core::setError('errStartQuestActiveTrainingFound');
        if($player->character->training_count <= 0)
            return Core::setError('errStartTrainingDailyLimitReached');
        
        $stat_type = intval(getField('stat_type', FIELD_NUM));
        $stat_end_name = Utils::getStatById($stat_type, "training_progress_end_");
        $iterations = intval(getField('iterations', FIELD_NUM));
        if($iterations < 1 || $iterations > $player->character->{$stat_end_name})
			return Core::setError(''.($player->character->{$stat_end_name}));
		if($stat_type < 1 || $stat_type > 4)
			return Core::setError('errInvalidStat');
			
		$stat_name = Utils::getStatById($stat_type, "training_progress_value_");
		
		$cost = Utils::getTrainingStartPremiumCurrencyCost($iterations);
		
		if($player->getPremium() < $cost)
		    return Core::setError('errRemovePremiumCurrencyNotEnough');
		
		$player->givePremium(-$cost);
		
		$tsCreation = time();
		$tsDuration = $tsCreation + (Config::get("constants.training_duration") * $iterations);
		
		$training = new Training([
            'character_id'=> $player->character->id,
            'status'=> 2,
            'stat_type'=> $stat_type,
            'ts_creation'=> $tsCreation,
            'ts_complete'=> $tsDuration,
            'iterations'=> $iterations
	    ]);
        $training->save();
        $player->character->active_training_id = $training->id;
        $player->character->ts_last_training = time();
        $player->character->training_count -= $iterations;
        $player->training = $training;
        
        Core::req()->data = array(
            'user'=>array('id'=>$player->user->id, "premium_currency"=>$player->getPremium()),
            'character'=>$player->character,
            'training'=>$player->training
        );
    }
}