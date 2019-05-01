<?php
namespace Request;

use Srv\Core;
use Cls\Player;

class getCharacter{
    
    public function __request($player){
        $retrieveID = intval(getField("character_id", FIELD_NUM));
        if($retrieveID <= 0)
            return Core::setError('');

        $retrievePlayer = Player::findByCharacterId($retrieveID);
        $retrievePlayer->loadForCharacterView();
        if(!$retrievePlayer)
            return Core::setError('errNoSuchUser');
        
        $retrieveInfoSet = $retrievePlayer->getOnlyEquipedItems();
        
        Core::req()->data = array(
            "requested_character" => $retrievePlayer->character,
            "requested_character_inventory" => $retrieveInfoSet["inventory"],
            "requested_character_inventory_items" => $retrieveInfoSet["items"]
        );
        if($retrievePlayer->character->guild_id != 0)
            Core::req()->data += array("requested_character_guild" => $retrievePlayer->guild);
    }
}