<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\DuelBattle;
use Cls\Player;

class startDuel{
    
    public function __request($player){
        //Core::setError('errStartDuelAttackNotAllowed'); limit ataków 3 dziennie
        if($player->character->active_duel_id != 0)
            return Core::setError('errStartDuelActiveDuelFound');
            
        $use_premium = getField('use_premium',FIELD_BOOL,FALSE)=='true';
        
        if($use_premium){
            $cost = Config::get('constants.duel_single_attack_premium_amount');
            if($player->getPremium() < $cost)
                return Core::setError('errRemovePremiumCurrencyNotEnough');
        }else{
            $cost = Config::get('constants.duel_stamina_cost');
            if($player->character->duel_stamina < $cost)
                return Core::setError('errRemoveDuelStaminaNotEnough');
        }
        
        $opponentID = intval(getField("character_id", FIELD_NUM));
        if(!$opponentID)
            return Core::setError('errNoSuchUser');
        
        if($opponentID == $player->character->id)
            return Core::setError("errSelfAttackIsNotAllowed");
        
        $opponent = Player::findByCharacterId($opponentID);
        $opponent->loadForDuel();
        if(!$opponent)
            return Core::setError('errNoSuchUser');
            
        $duelbattle = new DuelBattle($player, $opponent);
        $duelbattle->start();
        $duelbattle->save();
        
        $opponent->giveRewards($duelbattle->duel->character_b_rewards);
        $opponentEq = $opponent->getOnlyEquipedItems();
        
        $player->character->active_duel_id = $duelbattle->duel->id;
        $player->character->ts_last_duel = time();
        if($use_premium)
            $player->givePremium(-$cost);
        else{
            $player->character->ts_last_duel_stamina_change = time();
            $player->character->duel_stamina -= $cost;
        }
        
        if(!$player->getTutorialFlag('first_duel')){
            //$player->setTutorialFlag('first_duel', true);
            //$player->setTutorialFlag('tutorial_finished', true);
            $player->character->tutorial_flags = '{"first_visit":true,"mission_shown":true,"first_mission":true,"stats_spent":true,"shop_shown":true,"first_item":true,"duel_shown":true,"first_duel":true,"tutorial_finished":true}';
            $player->givePremium(Config::get('constants.tutorial_finished_premium_currency'));
        }
        
        Core::req()->data = array(
            "user" => $use_premium?$player->user:[],
            "character" => $player->character,
            "duel" => $duelbattle->duel,
            "battle" => $duelbattle->battle,
            "opponent" => $opponent->character,
            "opponent_inventory" => $opponentEq['inventory'],
            "opponent_inventory_items" => $opponentEq['items'],
            "inventory" => $player->inventory,
            "items"=> $player->items
        );
    }
}