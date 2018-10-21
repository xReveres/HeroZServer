<?php
namespace Request;

use Srv\Core;

class claimWorkRewards{
    
    public function __request($player){
        if($player->character->active_work_id == 0)
            return Core::setError('errStartQuestActiveWorkFound');
        
        if($player->work->status != 4)
            return Core::setError('errUnknownStatus');
        
        $player->giveRewards($player->work->rewards);
        
        $player->work->remove();
        $player->character->active_work_id = 0;
        Core::req()->data = array(
            'character'=>$player->character,
            'work'=>array('id'=>$player->work->id, 'status'=>4)
        );
    }
}