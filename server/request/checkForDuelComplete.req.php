<?php
namespace Request;

use Srv\Core;
use Schema\Duel;

class checkForDuelComplete{
    
    public function __request($player){
        if($player->character->active_duel_id == 0)
			return Core::setError("errStartDuelActiveDuelFound");
		
		$duel = Duel::find(function($q)use($player){
			$q->where('id', $player->character->active_duel_id);
		});
		$duel->character_a_status = 2;
		
		Core::req()->data = array(
			"duel" => [
				"id" => $duel->id,
				"character_a_status" => 2
			]
		);
    }
}