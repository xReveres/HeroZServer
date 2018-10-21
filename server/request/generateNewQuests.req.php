<?php
namespace Request;

use Srv\Core;
use Cls\Utils;

class generateNewQuests{
    
    public function __request($player){
        $all_stages = (getField('all_stages', FIELD_BOOL)==='true');
        
        $max_stages = $player->character->max_quest_stage;
        $single_refresh = Utils::getQuestRefreshCost($all_stages, $max_stages);
		if($player->getPremium() < $single_refresh)
		    return Core::setError("errRemovePremiumCurrencyNotEnough");
		$player->givePremium(-$single_refresh);
        
        if($all_stages){ //wszystkie stage
            for($stage = 1; $stage <= $max_stages; $stage++)
                $player->generateQuestsAtStage($stage, 3);
        }else{ //tylko 1 stage
            $curr_stage = $player->character->current_quest_stage;
            $player->generateQuestsAtStage($curr_stage, 3);
        }
        $player->updateQuestsPool();
        
        Core::req()->data = array(
            'character'=>$player->character,
            'quests'=>$player->quests
        );
    }
}