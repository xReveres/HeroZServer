<?php
namespace Request;

use Srv\Core;
use Srv\DB;
use Srv\Config;
use PDO;

class retrieveGuildLeaderboard{
    public function __request($player){
        $sortByHonor = getField('sort_type', FIELD_NUM)==1;
        $guild_name = getField('guild_name', FIELD_ALNUM, FALSE);
        $sort_rank = intval(getField('rank', FIELD_NUM, FALSE));
        
        $max_guilds = DB::table('guild')->select()->where('status','!=',2)->count();
        if($sort_rank < 0 || $sort_rank > $max_guilds)
            return Core::setError('errRetrieveGuildLeaderboardInvalidRank');
            
        $maxGuildBasePercentage = Config::get('constants.guild_percentage_total_base');
        $tpColumn = "((g.`stat_guild_capacity`+g.`stat_character_base_stats_boost`+g.`stat_quest_xp_reward_boost`+g.`stat_quest_game_currency_reward_boost`)/{$maxGuildBasePercentage}) as tp";
        
        $sortBy = $sortByHonor?'`honor`':'`tp`';
        if($sort_rank)
            $centerRank = $sort_rank;
        else{
            if($guild_name || $player->character->guild_id){
                if($guild_name)
                    $where = "`g`.`name`='{$guild_name}'";
                else if($player->character->guild_id)
                    $where = "`g`.`id`={$player->character->guild_id}";
                DB::sql("set @rank = 0");
                $centerRank = DB::sql("
                    SELECT `g`.`rank`, `g`.`id` FROM
                        (SELECT @rank := @rank+1 as 'rank', `id`, `name`, {$tpColumn} FROM `guild` g WHERE `status` != 2 ORDER BY {$sortBy} DESC) as g
                    WHERE {$where};
                ")->fetchColumn();
                $centerRank = intval($centerRank);
            }else
                $centerRank = 1;
        }
        
        $columns = "(@rank:=@rank+1) as 'r', g.`name` as n, g.`id` as id, g.`honor` as h, {$tpColumn},
        g.`emblem_background_shape` as ebs, g.`emblem_background_color` as ebc, g.`emblem_background_border_color` as ebbc, g.`emblem_icon_shape` as eis, g.`emblem_icon_color` as eic, g.`emblem_icon_size` as eiz, g.`artifact_ids` as ga, COALESCE(gb.id,0) as gbd, '0' as v";
        
        DB::sql('set @rank = 0');
        $lb = DB::sql("
            SELECT `h`.* FROM
                (SELECT {$columns} FROM `guild` g LEFT JOIN `guild_battle` gb ON gb.`guild_defender_id`=g.`id` AND gb.`status`=1 WHERE g.`status`=1 ORDER BY {$sortBy} DESC) as h
            WHERE `h`.`r` > {$centerRank}-49 LIMIT 50;
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        if($guild_name && !$centerRank)
            return Core::setError('errRetrieveGuildLeaderboardInvalidGuild');
        
        foreach($lb as &$l){
            foreach($l as $k=>&$c){
                if(is_numeric($c) && (int)$c!=$c) $c = floatval($c);
                else if(is_numeric($c)) $c = intval($c);
            }
        }
        
        Core::req()->data = array(
            "leaderboard_guilds" => $lb,
			"max_guilds" => $max_guilds,
			"centered_rank" => $centerRank
        );
    }
}