<?php
namespace Request;

use Srv\Core;
use Cls\QuestBattle;
use Cls\NPC;
use Srv\Config;

class checkForQuestComplete{
    
    public function __request($player){
        if($player->character->active_quest_id == 0)
            return Core::setError('errStartQuestActiveQuestFound');
        
        $quest_id = $player->character->active_quest_id;
        $quest = $player->getQuestById($quest_id);
        if($quest == null)
            return Core::setError('errNoActiveQuest');
            
        if($quest->ts_complete < time())
            $quest->status = 4;
            
        $questbattle = false;
        $rewards = false;
        if($quest->type == 2){
            $npc = new NPC($quest->fight_npc_identifier);
            $npc->randomiseQuestStats($player, $quest->fight_difficulty);
            $questbattle = new QuestBattle($player, $npc);
            $questbattle->start();
            $questbattle->save();
            $quest->fight_battle_id = $questbattle->battle->id;
            //
            if($questbattle->battle->winner == 'b'){
                $rewards = json_decode($quest->rewards, true);
                $rewards['coins'] = round($rewards['coins'] * Config::get('constants.fight_quest_reward_lost_coin'));
                $rewards['xp'] = round($rewards['xp'] * Config::get('constants.fight_quest_reward_lost_xp'));
                $rewards = $quest->rewards = json_encode($rewards);
            }
        }
        
        Core::req()->data = array(
            'character'=>$player->character,
            'quest'=>['id'=>$quest->id,'status'=>$quest->status,'ts_complete'=>$quest->ts_complete]
        );
        if($questbattle){
            Core::req()->data += ['battle'=>$questbattle->battle];
            Core::req()->data['quest']['fight_battle_id'] = $questbattle->battle->id;
            Core::req()->data += ['items'=>$player->items];
        }
        if($rewards)
            Core::req()->data['quest']['rewards'] = $rewards;
    }
}