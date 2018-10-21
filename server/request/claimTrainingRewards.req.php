<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;

class claimTrainingRewards{
    
    public function __request($player){
        if($player->character->active_training_id == 0)
            return Core::setError('errNoStartQuestActiveTrainingFound');
        
        $stat_name = Utils::getStatById($player->training->stat_type, "training_progress_value_");
        $stat_name_end = Utils::getStatById($player->training->stat_type, "training_progress_end_");
        $stat_trained = Utils::getStatById($player->training->stat_type);
        
        $player->character->{$stat_name} += $player->training->iterations;
        if($player->character->{$stat_name} >= $player->character->{$stat_name_end}){
            $player->character->{$stat_name} = 0;
            $player->character->{'stat_trained_'.$stat_trained} += Config::get('constants.training_stat_increase_value');
            $player->character->{'stat_base_'.$stat_trained} += Config::get('constants.training_stat_increase_value');
        }
        //$player->setCharacter('training_count', $player->getCharacter('training_count')-1);
        
        $trainingRatioLVL = Config::get('constants.training_to_level_ratio');
        $trainingMin = Config::get('constants.training_min_sessions');
        $trainingMax = Config::get('constants.training_max_sessions');
        $player->character->{$stat_name_end} = Utils::clamp($trainingMin, $trainingMax, ceil($trainingRatioLVL * $player->character->{'stat_trained_'.$stat_trained}));
        
        $player->training->remove();
        $player->character->active_training_id = 0;
        $player->calculateStats();
        Core::req()->data = array(
            'character'=>$player->character
        );
    }
}