<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Srv\DB;
use PDO;

class getGuildList{
    public function __request($player){
        $maxGuildBasePercentage = Config::get('constants.guild_percentage_total_base');
        
        $guilds = DB::table('guild as g')
            ->select([
                DB::Expr('`g`.*'),
                DB::Expr("((`g`.`stat_guild_capacity`+`g`.`stat_character_base_stats_boost`+`g`.`stat_quest_xp_reward_boost`+`g`.`stat_quest_game_currency_reward_boost`)/{$maxGuildBasePercentage}) as tp"),
                DB::Expr('COUNT(`ch`.`id`) as membercount'),
                DB::Expr('`ch`.`name` as leadername')
            ])
            ->join('character as ch', 'ch.guild_id','=','g.id')
            ->where('g.min_apply_honor','<=',$player->character->honor)
            ->where('g.min_apply_level','<=',$player->getLVL())
            ->where('ch.guild_rank',1)
            ->orderBy('tp','desc')
            ->groupBy('ch.guild_id')
            ->limit(100)
            ->get();
        $guildsData = [];
        foreach($guilds as $g){
            $guildsData[] = array(
                'id'=>intval($g['id']),
                'apply_open'=>$g['accept_members']?true:false,
                'emblem_background_border_color'=>intval($g['emblem_background_border_color']),
                'emblem_background_color'=>intval($g['emblem_background_color']),
                'emblem_background_shape'=>intval($g['emblem_background_shape']),
                'emblem_icon_color'=>intval($g['emblem_icon_color']),
                'emblem_icon_shape'=>intval($g['emblem_icon_shape']),
                'emblem_icon_size'=>intval($g['emblem_icon_size']),
                'name'=>$g['name'],
                'total_percentage'=>floatval($g['tp']),
                'member_count'=>intval($g['membercount']),
                'leader_name'=>$g['leadername']
            );
        }
        //
        Core::req()->data = array(
            'character'=>$player->character,
            'guilds'=>$guildsData
        );
    }
}
/*
apply_open:true //
emblem_background_border_color:1 //
emblem_background_color:0 //
emblem_background_shape:23 //
emblem_icon_color:11 //
emblem_icon_shape:9 //
emblem_icon_size:150 //
id:9851 //
leader_name:"Y0ungFizzh"
member_count:5 //
name:"JEBAC PSY NA ZAWSZE" //
total_percentage:0.1543 //
*/