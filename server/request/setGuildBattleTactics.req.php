<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class setGuildBattleTactics{
    public function __request($player){
        if($player->character->guild_id == 0)
            return Core::setError('errCharacterNoGuild');
        
        $defense_order = intval(getField('defense_order',FIELD_NUM));
        $defense_tactic = intval(getField('defense_tactic',FIELD_NUM));
        $attack_order = intval(getField('attack_order',FIELD_NUM));
        $attack_tactic = intval(getField('attack_tactic',FIELD_NUM));
        
        $gTactics = Config::get('constants.guild_battle_tactics');
        if(!isset($gTactics[$defense_order]) || $gTactics[$defense_order]['type'] != 1 ||
            !isset($gTactics[$defense_tactic]) || $gTactics[$defense_tactic]['type'] != 2 ||
            !isset($gTactics[$attack_order]) || $gTactics[$attack_order]['type'] != 1 ||
            !isset($gTactics[$attack_tactic]) || $gTactics[$attack_tactic]['type'] != 2)
            return Core::setError('');
        
        $player->guild->guild_battle_tactics_attack_order = $attack_order;
        $player->guild->guild_battle_tactics_attack_tactic = $attack_tactic;
        $player->guild->guild_battle_tactics_defense_order = $defense_order;
        $player->guild->guild_battle_tactics_defense_tactic = $defense_tactic;
        
        Core::req()->data = [
            'guild'=>$player->guild
        ];
    }
}