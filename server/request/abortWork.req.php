<?php
namespace Request;

use Srv\Core;
use Cls\Utils;

class abortWork{
    
    public function __request($player){
        if($player->character->active_work_id == 0)
            return Core::setError('noActiveWork');
        
        $durationInSeconds = $player->work->duration * 3600;
		$workedHours = $player->work->ts_complete - time();
		
		if($workedHours < 0)
			$workedHours = 0;
		$tsFullHours = floor(($durationInSeconds - $workedHours) / 3600);
		
		$abortMoney = Utils::getAbortedWorkCoinReward($player->getLVL(), 0, $tsFullHours*3600);
		
		$player->giveMoney($abortMoney);
		
		$player->work->remove();
		$player->character->active_work_id = 0;
		Core::req()->data = array(
			"user" => array(),
			"character" => $player->character,
			"work" => ["id"=>$player->work->id, "status"=>3],
		);
    }
}