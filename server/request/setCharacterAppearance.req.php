<?php
namespace Request;

use Srv\Core;
use Srv\Config;

class setCharacterAppearance{
    
    public function __request($player){
        $gender = getField('gender', FIELD_ALPHA);
        $cfgApp = Config::get("constants.character.appearances.$gender", FALSE);
        if(!$cfgApp)
            return Core::setError('missingConfAppearance');
            
        $hair_color = intval(getField('hair_color', FIELD_NUM));
        $hair_type = intval(getField('hair_type', FIELD_NUM));
        $facial_hair_type = intval(getField('facial_hair_type', FIELD_NUM));
        $head_type = intval(getField('head_type', FIELD_NUM));
        $eyebrows_type = intval(getField('eyebrows_type', FIELD_NUM));
        $mouth_type = intval(getField('mouth_type', FIELD_NUM));
        $nose_type = intval(getField('nose_type', FIELD_NUM));
        $eyes_type = intval(getField('eyes_type', FIELD_NUM));
        $decoration_type = intval(getField('decoration_type', FIELD_NUM));
        $skin_color = intval(getField('skin_color', FIELD_NUM));
        if( !in_array($hair_color,$cfgApp['hair_color']) || !in_array($hair_type,$cfgApp['hair_type']) ||
            !in_array($head_type,$cfgApp['head_type']) ||
            !in_array($eyebrows_type,$cfgApp['eyebrows_type']) || !in_array($mouth_type,$cfgApp['mouth_type']) ||
            !in_array($nose_type,$cfgApp['nose_type']) || !in_array($eyes_type,$cfgApp['eyes_type']) ||
            !in_array($decoration_type,$cfgApp['decoration_type']) || !in_array($skin_color,$cfgApp['skin_color']) ||
            ($gender=='m' && !in_array($facial_hair_type,$cfgApp['facial_hair_type'])))
            return Core::setError('missingAppearance');
        
        $player->character->gender=$gender;
        $player->character->appearance_hair_color=$hair_color;
        $player->character->appearance_hair_type=$hair_type;
        $player->character->appearance_facial_hair_type=$facial_hair_type;
        $player->character->appearance_head_type=$head_type;
        $player->character->appearance_eyebrows_type=$eyebrows_type;
        $player->character->appearance_mouth_type=$mouth_type;
        $player->character->appearance_nose_type=$nose_type;
        $player->character->appearance_eyes_type=$eyes_type;
        $player->character->appearance_decoration_type=$decoration_type;
        $player->character->appearance_skin_color=$skin_color;
        
        Core::req()->data = array(
            'user'=>array(),
            'character'=>$player->character
        );
    }
}