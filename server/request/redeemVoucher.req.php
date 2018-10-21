<?php
namespace Request;

use Srv\Core;

class redeemVoucher{
    public function __request($player){
        Core::req()->data = [
            'character'=>$player->character,
            'voucher_rewards'=>[
                'game_currency'=>5
            ]
        ];
    }
}