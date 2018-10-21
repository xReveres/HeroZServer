<?php
namespace Srv;

use Srv\Config;
use Srv\DB;
use Srv\Record;
use Srv\Req;
use Srv\Cache;
use Cls\Player;

class Core{
    
    const PASSWORD_SALT = 'q!*1IYn1eZr#A?#FGlqkt';
    static $REQ_NOLOGIN = ['initGame','checkCharacterName','registerUser','createCharacter','loginUser','autoLoginUser','gameReportError'];
    const TIME_OFFSET = 7200;
    const HOUR_TIME_OFFSET = 2;
    static $ACTUAL_ACTION = '';
    public static $PLAYER = null;
    public static $GUILDS = [];
    
    public static function start(){
        Req::__init();
        Config::__init();
        if(!isField('client_version') || getField('client_version') != Config::get('server.flash_ver'))
            return Req::setError('missingFlash');
        //Init modules
        Cache::__init();
        DB::__init();
        //Load player if exist SSID
        $player = static::tryLoadPlayer();
        //Load request and execute it
        $action = isset_or($_POST['action'],false);
        if(!$action)
            return Req::setError('missingAction');
        //Prevent load request without login
        if(!$player && !in_array($action, static::$REQ_NOLOGIN))
            return Req::setError('vuneRED');
        static::$ACTUAL_ACTION = $action;
        static::$PLAYER = $player;
        //
        if(stripos($action, 'gameTest')!==FALSE){
            $path = SERVER_DIR."/request/test/$action.req.php";
        }else
            $path = SERVER_DIR."/request/$action.req.php";
        if(!file_exists($path))
            return Req::setError('unknownAction');
        require_once($path);
        $ns = "\\Request\\$action";
        $request = new $ns;
        $request->__request($player);
        if($player != null)
            $player->__endRequest();
        //Finalize all
        Record::__saveAllRecords();
    }
    
    public static function time(){
        return time() + self::TIME_OFFSET;
    }
    public static function timestamp(){
        return static::time();
    }
    
    private static function tryLoadPlayer(){
        if(isField('user_id') && isField('user_session_id')){
            $user_id = intval(getField('user_id', FIELD_NUM));
            $user_session_id = getField('user_session_id', FIELD_MD5);
            if(!$user_id || !$user_session_id)
                return null;
            if(!$user_id || !$user_session_id)
                return Req::setError('errLoginNoSuchUser');
            $player = Player::findBySSID($user_id, $user_session_id);
            return $player;
        }
        return null;
    }
    
    public static function passwordHash($pass){
        return sha1(self::PASSWORD_SALT.md5($pass).$pass);
    }
    
    //Request class
    public static function setError($err){
        Req::setError($err);
        return -1;
    }
    
    public static function req(){
        return Req::$instance;
    }
    
    public static function player(){
        return static::$PLAYER;
    }
    public static function getPlayer(){
        return static::player();
    }
    
    public static function getTimestampOffset(){
        return 7200;
    }
    
    public static function validMSG($msg, $rep="", $each=false){
        $msg = strip_tags($msg);
        $regex = "/\b\d{1,3}+\p{P}*\d{1,3}+\p{P}*\d{1,3}+\p{P}*\d{1,3}+\b|([\w-\.]+)((?:[\w]+\.)+)([a-zA-Z]{2,4})/";
        if($each)
            while(preg_match($regex, $msg))
                $msg = preg_replace($regex, $rep, $msg);
        else
            $msg = preg_replace($regex, $rep, $msg);
        return $msg;
    }
    
    public static function getAlphaFromAlphabet($offset){
        return substr('abcdefghiklmnopqrstvxyzABCDEFGHIKLMNOPQRSTVXYZ', $offset, 1);
    }
}