<?php
namespace Request;

use Srv\Core;

class setUserPassword{
    
    public function __request($player){
        $password_old = getField('password_old');
        $password_new = getField('password_new');
        
        if($player->user->password_hash != Core::passwordHash($password_old))
            return Core::setError('errNewPasswordInvalidOldPassword');
        
        $player->user->password_hash = Core::passwordHash($password_new);
    }
}