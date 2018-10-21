<?php
namespace Request;

use Srv\Core;
use Srv\DB;
use Srv\Config;
use Schema\User;

class registerUser{
    
    public function __request(){
        $email = getField('email', FIELD_EMAIL);
        if(!$email)
            return Core::setError('errRegisterInvalidEmail');
        $pass = getField('password');
        if(!$pass)
            return Core::setError('errRegisterInvalidPassword');
            
        $time = time();
        
        $exists = DB::table('user')->select()->where('email',$email)->exists();
        if($exists)
            Core::setError('errRegisterUserAlreadyExists');
        
        $usr = new User([
            'email'=>$email,
            'password_hash'=>Core::passwordHash($pass),
            'ts_creation'=>$time,
            'registration_ip'=>getclientip(),
            'premium_currency'=>Config::get('constants.init_premium_currency'),
            'session_id'=> md5(microtime())
        ]);
        $usr->save();
        
        Core::req()->data = (['user'=>$usr,'campaigns'=>[]]);
    }
    
}