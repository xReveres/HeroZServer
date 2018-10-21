<?php
namespace Cls;

use Cls\Player;
use JsonSerializable;

class GuildMember implements JsonSerializable{
    
    public $player = null;
    
    public function __construct($player){
        $this->player = $player;
        $this->player->loadForGuild();
    }
    
    public static function findAllByGuildId($gid, $bypass=false){
        $players = Player::findAllByGuildId($gid,$bypass);
        $guildmembers = [];
        foreach($players as $player)
            $guildmembers[] = new GuildMember($player);
        return $guildmembers;
    }
    
    public function jsonSerialize(){
        $character = $this->player->character;
        return [
            "id"=>$character->id,
        	"user_id"=>$character->user_id,
        	"name"=>$character->name,
        	"gender"=>$character->gender,
        	"level"=>$character->level,
        	"honor"=>$character->honor,
        	"guild_rank"=>$character->guild_rank,
        	"ts_guild_joined"=>$character->ts_guild_joined,
        	"ts_last_online"=>$character->ts_last_action,
        	"last_action"=>round((time() - $character->ts_last_action) / 60),
        	"online_status"=>$character->online_status,
        	"game_currency_donation"=>$character->game_currency_donation,
        	"premium_currency_donation"=>$character->premium_currency_donation,
        	"stat_total_stamina"=>$character->stat_total_stamina,
        	"stat_total_strength"=>$character->stat_total_strength,
        	"stat_total_critical_rating"=>$character->stat_total_critical_rating,
        	"stat_total_dodge_rating"=>$character->stat_total_dodge_rating
        ];
    }
}