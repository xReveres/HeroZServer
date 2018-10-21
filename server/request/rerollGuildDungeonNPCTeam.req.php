<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class rerollGuildDungeonNPCTeam{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('');
        $dungeon = $player->guild->getDungeon();
        if($dungeon == null)
            return Core::setError('');
        if(!$dungeon->checkLockedDungeon($player))
            return Core::setError('');
        
        if($dungeon->getRerollCount() > 0){
            $cost = Config::get('constants.guild_dungeon_new_enemy_premium_amount');
            if($player->guild->getPremium() < $cost)
                return Core::setError('errRemovePremiumCurrencyNotEnough');
            $player->guild->givePremium(-$cost);
        }
        
        $dungeon->randomiseDungeon(false);
        
        Core::req()->data = [
            'guild_dungeon_battle'=>$dungeon->getBattle(),
            'guild'=>$player->guild
        ];
    }
}