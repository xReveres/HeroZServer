<?php
namespace Request;

use Srv\Core;
use Srv\Config;
use Cls\Utils;

class washInventoryItem{
    
    public function __request($player){
        $itemid = intval(getField('item_id', FIELD_NUM));
        
        if($player->getLVL() < Config::get('constants.washing_machine_req_level'))
            return Core::setError('');
        
        $usepremium = Utils::isToday( $player->character->ts_last_wash_item );
        
        if($usepremium && $player->getPremium() < Config::get('constants.washing_machine_premium_currency_amount'))
            return Core::setError('errRemovePremiumCurrencyNotEnough');
        
        $item = $player->getItemById($itemid);
        if($item == null)
            return Core::setError('');
        if($item->type == 8)
            return Core::setError('');
        
        $stat_sum = $item->stat_stamina + $item->stat_strength + $item->stat_critical_rating + $item->stat_dodge_rating;
        $gived = 0;
        $stat_order = [0,1,2,3];
        shuffle($stat_order);
        $d= [];
        //
        for($i=0; $i < 4; $i++){
            $togive = $stat_sum-$gived;
            if($togive > 0 && $i != 3)
                $ch = rand(0, $togive);
            else if($togive >= 0 && $i == 3)
                $ch = $togive;
            else
                $ch = 0;
            switch($stat_order[$i]){
                case 0: //stat_stamina
                    $item->stat_stamina = $ch;
                    break;
                case 1: //stat_strength
                    $item->stat_strength = $ch;
                    break;
                case 2: //stat_critical_rating
                    $item->stat_critical_rating = $ch;
                    break;
                case 3: //stat_dodge_rating
                    $item->stat_dodge_rating = $ch;
                    break;
            }
            $gived += $ch;
        }
        
        $player->character->ts_last_wash_item = time();
        
        if($usepremium)
            $player->givePremium(-Config::get('constants.washing_machine_premium_currency_amount'));
        
        $player->calculateStats();
        Core::req()->data = array(
            "character"=>$player->character,
            "item"=>[
                'id'=>$item->id,
                'stat_stamina'=>$item->stat_stamina,
                'stat_strength'=>$item->stat_strength,
                'stat_critical_rating'=>$item->stat_critical_rating,
                'stat_dodge_rating'=>$item->stat_dodge_rating
            ]
        );
        if($usepremium)
            Core::req()->data += array('user'=>['id'=>$player->user->id,'premium_currency'=>$player->getPremium()]);
    }
}