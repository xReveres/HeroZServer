<?php
namespace Request;

use Srv\Core;
use Cls\Utils;

class instantFinishTraining{
    
    public function __request($player){
        if($player->character->active_training_id == 0)
            return Core::setError('errNoStartQuestActiveTrainingFound');
            
        $cost = Utils::getTrainingInstantFinishCost($player->training->iterations);
        
        if($player->getPremium() < $cost)
            return Core::setError('errRemovePremiumCurrencyNotEnough');
        
        $player->givePremium(-$cost);
        $player->training->ts_complete = 0;
        $player->calculateStats();
        Core::req()->data = array(
            'character'=>$player->character,
            'training'=>array('id'=>$player->training->id, 'ts_complete'=>0)
        );
    }
}