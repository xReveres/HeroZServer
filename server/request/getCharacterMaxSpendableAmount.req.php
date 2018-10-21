<?php
namespace Request;

use Srv\Core;

class getCharacterMaxSpendableAmount{
    public function __request(){
        Core::req()->data = array(
            'character'=>[],
            "max_spendable_amount" => 999
        );
    }
}