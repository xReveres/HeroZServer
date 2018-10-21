<?php
namespace Request;

use Srv\Core;

class checkForWorkComplete{
    
    public function __request($player){
        if($player->character->active_work_id == 0)
            return Core::setError('errNoStartQuestActiveWorkFound');
        
        $player->work->status = $player->work->ts_complete > time() ? 2 : 4;
        
        Core::req()->data = array(
            'character'=>$player->character,
            'work'=>$player->work
        );
    }
}