<?php
namespace Request;

use Request\loginUser;

class autoLoginUser{
    
    public function __request(){
        $ssid = getField('existing_session_id', FIELD_MD5);
        $uid = getField('existing_user_id', FIELD_NUM);
        if($ssid && $uid)
            (new loginUser())->__request(null, $uid, $ssid);
    }
    
}