<?php
namespace Request;

use Srv\Core;

class abortQuest{
    
    public function __request($player){
        if($player->character->active_quest_id == 0)
            return Core::setError('errStartQuestActiveQuestFound');
        
        $quest = $player->getQuestById($player->character->active_quest_id);
        if($quest == null)
            return Core::setError('errNoActiveQuest');
        if($quest->status != 2)
            return Core::setError('errNoActiveQuest2');
        
        $quest->status = 1;
        $quest->ts_complete = 0;
        
        $player->character->active_quest_id = 0;
        
        Core::req()->data = array(
            'character'=>$player->character,
            'quest'=>array('id'=>$quest->id, 'status'=>$quest->status)
        );
    }
}