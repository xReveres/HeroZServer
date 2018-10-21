<?php
namespace Request;

use Srv\Core;

class checkForTrainingComplete{
    
    public function __request($player){
        if($player->character->active_training_id == 0)
            return Core::setError('errNoStartQuestActiveTrainingFound');
            
        $player->training->status = $player->training->ts_complete > time() ? 2 : 4;
        
        Core::req()->data = array(
            'character'=>$player->character,
            'training'=>$player->training
        );
    }
}