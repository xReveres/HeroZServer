<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;

class buyQuestEnergy{
    
    public function __request($player){
        $premium = getField('use_premium', FIELD_BOOL)==='true'?true:false;
        
        //TODO: odblokowac jak bd potrzebny limit na enegrię
        if($player->character->quest_energy_refill_amount_today >= Config::get('constants.quest_max_refill_amount_per_day'))
        	return Core::setError('');
        
        if($player->character->quest_energy > 50)
			return Core::setError('');
			
		if($premium){
		    if($player->getPremium() < Config::get('constants.quest_energy_refill_premium_amount'))
		        return Core::setError('errRemovePremiumCurrencyNotEnough');
		    $player->givePremium(-Config::get('constants.quest_energy_refill_premium_amount'));
		}else{
		    $cost = Utils::coinCostEnergyRefill($player->getLVL(), $player->character->quest_energy_refill_amount_today);
		    
		    if($player->getMoney() < $cost)
		        return Core::setError('errRemoveGameCurrencyNotEnough');
		    
		    $player->giveMoney(-$cost);
		}
		
		$energy = Config::get('constants.quest_energy_refill_amount');
		$player->character->quest_energy += $energy;
		$player->character->quest_energy_refill_amount_today += $energy;
		
		Core::req()->data = array(
		    'character'=>$player->character
		);
    }
}