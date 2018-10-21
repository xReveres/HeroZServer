<?php
namespace Request;

use Srv\Core;
use Srv\DB;

class getGuildBattleList{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        if($player->character->guild_rank == 3)
            return Core::setError('errNoPermission');
        
        $guilds = DB::table('guild as g')
            ->select([
                'g.id',
                'g.name',
                'g.honor',
                'g.emblem_background_shape',
                'g.emblem_background_color',
                'g.emblem_background_border_color',
                'g.emblem_icon_shape',
                'g.emblem_icon_color',
                'g.emblem_icon_size',
                DB::Expr("COUNT(ch.id) as 'member_count'"),
                DB::Expr("ROUND(AVG(ch.level)) as 'average_level'"),
                "g.artifact_ids"
            ])
            ->join('character as ch', 'ch.guild_id','=','g.id')
            ->where('g.id','<>',$player->character->guild_id)
            //->where('g.honor','<',$player->guild->honor + 400)
            ->where('g.id','NOT IN',DB::Expr("(SELECT guild_defender_id FROM guild_battle WHERE status=1)"))
            ->where('g.status',1)
            ->groupBy('ch.guild_id')
            ->orderBy('g.honor')
            ->limit(50)
            ->get();
        
        foreach($guilds as &$g)
            foreach($g as &$c)
                if(is_numeric($c)) $c = intval($c);
        
        Core::req()->data = [
            'guilds'=>$guilds
        ];
    }
}