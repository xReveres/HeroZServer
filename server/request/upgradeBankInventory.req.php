<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class upgradeBankInventory{
    
    public function __request($player){
        $bankIndex = $player->bankinv->max_bank_index;
		
		$bankIndex++;
		$bankUpgrade = Config::get("constants.bank_upgrade{$bankIndex}_premium_amount");
		if(!$bankUpgrade)
			return Core::setError('');
		if($player->getPremium() < $bankUpgrade)
			return Core::setError("errRemovePremiumCurrencyNotEnough");
			
		$player->givePremium(-$bankUpgrade);
		$player->bankinv->max_bank_index = $bankIndex;
		
		Core::req()->data = array(
			"user" =>['id'=>$player->user->id, 'game_currency'=>$player->getPremium()],
			"bank_inventory" => ["id"=>$player->bankinv->id, "max_bank_index"=>$bankIndex]
		);
    }
}