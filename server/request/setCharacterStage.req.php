<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class setCharacterStage{
    
    public function __request($player){
        $stage = intval(getField('stage', FIELD_NUM));
        
        if(!$stage || $stage < 0 || $stage > Config::get('constants.quest_max_stage') || $stage > $player->character->max_quest_stage)
			Core::setError("errInvalidStage");
			
		if($player->character->active_quest_id != 0)
			Core::setError("errCannotChangeStageWhenMission");
			
		$player->character->current_quest_stage = $stage;
			
		Core::req()->data = array(
			"user" => [],
			"character" => $player->character
		);
    }
}