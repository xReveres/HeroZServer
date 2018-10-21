<?php
namespace Request;

use Srv\Core;
use Cls\Utils;
use Cls\Bonus\SlotMachine;

class getSlotMachineReward{
    function __request($player){
        $reward = SlotMachine::findCurrentReward($player);
        if(!$reward)
            return Core::setError('errGetSlotmachineRewardCharacterHasNoActiveSpin');
        Core::req()->data = $reward;
    }
}