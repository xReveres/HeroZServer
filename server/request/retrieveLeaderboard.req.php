<?php
namespace Request;

use Srv\Core;
use Srv\DB;
use PDO;

class retrieveLeaderboard{
    
    public function __request($player){
        $sortByLVL = getField('level_sort', FIELD_BOOL)=='true';
        $character_name = getField('character_name', FIELD_ALNUM, FALSE);
        $sort_rank = intval(getField('rank', FIELD_NUM, FALSE));
        
        $max_ch = DB::table('character')->select()->count();
        if($sort_rank < 0 || $sort_rank > $max_ch)
            return Core::setError('errRetrieveLeaderboardInvalidRank');
        
        $sortBy = $sortByLVL?'level':'honor';
        if($sort_rank)
            $centerRank = $sort_rank;
        else{
            if($character_name)
                $where = "`ch`.`name` LIKE '%{$character_name}%'";
            else
                $where = "`ch`.`id`={$player->character->id}";
            DB::sql("set @rank = 0");
            $centerRank = DB::sql("
                SELECT `ch`.`rank` FROM
                    (SELECT @rank := @rank+1 as 'rank', `id`, `name` FROM `character` ORDER BY `{$sortBy}` DESC) as ch
                WHERE {$where};
            ")->fetchColumn();
            $centerRank = intval($centerRank);
        }
        
        if($character_name && !$centerRank)
            return Core::setError('errRetrieveLeaderboardInvalidCharacter');
        
        $time = time();
        $columns = "(@rank := @rank+1) as 'rank', ch.`id`, ch.`name`, ch.`guild_id`, ch.`gender`, ch.`level`, ch.`ts_last_action`, ch.`league_points`, IF(({$time}-(`ch`.`ts_last_action`))<60,1,2) as `online_status`, ch.`league_group_id`, ch.`honor`,
        COALESCE(g.`name`,'') as 'guild_name', g.`emblem_background_shape`, g.`emblem_background_color`, g.`emblem_background_border_color`, g.`emblem_icon_shape`, g.`emblem_icon_color`, g.`emblem_icon_size`";
        
        DB::sql("set @rank = 0");
        $lb = DB::sql("
            SELECT `h`.* FROM
                (SELECT {$columns} FROM `character` ch LEFT JOIN `guild` g ON `g`.`id`=`ch`.`guild_id` ORDER BY `{$sortBy}` DESC) as h
            WHERE `h`.`rank` > {$centerRank}-49 LIMIT 50;
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($lb as &$l){
            foreach($l as $k=>&$c){
                /*if($k=='tmp') unset($l[$k]);
                else*/ if(is_numeric($c)) $c = intval($c);
            }
        }
        
        Core::req()->data = array(
            'character'=>[],
            'centered_rank'=>$centerRank,
            'leaderboard_characters'=>$lb,
            'max_characters'=>$max_ch,
        );
    }
}