<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;
use Schema\Work;

class startWork{
    
    public function __request($player){
        if($player->character->active_quest_id != 0)
            return Core::setError('errStartQuestActiveQuestFound');
        if($player->character->active_work_id != 0)
            return Core::setError('errStartQuestActiveWorkFound');
        if($player->character->active_training_id != 0)
            return Core::setError('errStartQuestActiveTrainingFound');
        
        $duration = intval(getField('duration', FIELD_NUM));

        $tscomplete = ($duration * 3600) + time();
        $coins = Utils::getWorkCoinReward($player->getLVL(), 0, $duration * 3600);
        
		if(($booster = $player->getBoosters('work')) != null)
			$coins *= (1+ (Config::get("constants.boosters.$booster.amount")/100));
		if($player->character->guild_id != 0)
		    $coins *= (1+ (($player->guild->stat_quest_game_currency_reward_boost*2)/100));

		$rewards = Utils::rewards(round($coins));
		
		$work = new Work([
		    'character_id'=> $player->character->id,
		    'ts_complete'=> $tscomplete,
		    'duration'=> $duration,
		    'rewards'=>$rewards,
		    'status'=> 2
		]);
		$work->save();
        $player->character->active_work_id = $work->id;
        $player->work = $work;
        
        Core::req()->data = array(
            'user'=>[],
            'character'=>$player->character,
            'work'=>$player->work
        );
    }
}