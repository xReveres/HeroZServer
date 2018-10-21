<?php
namespace Request;

use Srv\Core;
use Cls\Bonus\SlotMachine;

class applySlotMachineReward{
    public function __request($player){
        $machine = SlotMachine::findCurrentReward($player);
        if(!$machine)
            return Core::setError('errApplySlotmachineRewardCharacterHasNoActiveSpin');
        //errInventoryNoEmptySlot
        
        $player->giveRewards($machine->reward);
        $machine->remove();
        $player->character->current_slotmachine_spin = SlotMachine::countCurrentSpins($player);
        
        Core::req()->data = [
            'character'=>$player->character
        ];
    }
}