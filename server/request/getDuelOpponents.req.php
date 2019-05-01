<?php
namespace Request;

use Srv\Core;
use Schema\Opponent;
use Cls\Player;
use Srv\DB;
use PDO;

class getDuelOpponents{
    
    public function __request($player){
        
        $opp = DB::sql("SELECT `user_id` FROM `character` WHERE `honor` <= {$player->character->honor} AND `honor` >= 0 AND `id`<>{$player->character->id} ORDER BY `honor` DESC LIMIT 10")->fetchALL(PDO::FETCH_NUM);
        
        if(count($opp) < 2)
            $opp = DB::sql("SELECT `user_id` FROM `character` WHERE `id`<>{$player->character->id} ORDER BY `honor` ASC LIMIT 10")->fetchALL(PDO::FETCH_NUM);
        
        shuffle ( $opp );
        
        $oppData = [];
        foreach($opp as $val){
            $o = Player::findByUserId($val[0]);
            $o->loadForDuel();
            $oppData[] = [
                "id" => $o->character->id,
                "name" => $o->character->name,
                "level" => $o->character->level,
                "honor" => $o->character->honor,
                "gender" => $o->character->gender,
                "stat_total_stamina" => $o->character->stat_total_stamina,
                "stat_total_strength" => $o->character->stat_total_strength,
                "stat_total_critical_rating" => $o->character->stat_total_critical_rating,
                "stat_total_dodge_rating" => $o->character->stat_total_dodge_rating,
                "stat_weapon_damage" => $o->character->stat_weapon_damage,
                "online_status" => $o->character->online_status,
                "total_stats" => $o->character->stat_total
            ];
        }
        
        Core::req()->data = array(
            'character'=>[],
            'opponents'=>$oppData
        );
    }
    
}