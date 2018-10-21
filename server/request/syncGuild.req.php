<?php
namespace Request;

use Srv\Core;

class syncGuild{
    public function __request($player){
        if($player->character->guild_id == 0)
            return;
        $updateCharacter = false;
        
        Core::req()->data['guild'] = $player->guild;
        Core::req()->data['guild_members'] = $player->guild->getMembers();
        
        if(count($player->guild->getBattleRewards()))
        		Core::req()->data['guild_battle_rewards'] = $player->guild->getBattleRewards();
        if(($finishedAttack = $player->guild->getFinishedAttack()) != NULL){
        	Core::req()->data['finished_guild_battle_attack'] = $finishedAttack->battle->getDataForAttacker();
        	Core::req()->data['guild_battle_guilds'][] = $finishedAttack->gDefender;
        	$updateCharacter = true;
        }
        if(($finishedDefense = $player->guild->getFinishedDefense()) != NULL){
        	Core::req()->data['finished_guild_battle_defense'] = $finishedDefense->battle->getDataForDefender();
        	Core::req()->data['guild_battle_guilds'][] = $finishedDefense->gAttacker;
        	$updateCharacter = true;
        }
        if(($pendingAttack = $player->guild->getPendingAttack()) != NULL){
        	Core::req()->data['pending_guild_battle_attack'] = $pendingAttack->battle->getDataForAttacker();
        	Core::req()->data['guild_battle_guilds'][] = $pendingAttack->gDefender;
        }
        if(($pendingDefense = $player->guild->getPendingDefense()) != NULL){
        	Core::req()->data['pending_guild_battle_defense'] = $pendingDefense->battle->getDataForDefender();
        	Core::req()->data['guild_battle_guilds'][] = $pendingDefense->gAttacker;
        }
        if($updateCharacter)
            Core::req()->data['character'] = $player->character;
    }
}