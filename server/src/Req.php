<?php
namespace Srv;

use Srv\Config;
use Srv\DB;
use Srv\Debug;
use JsonSerializable;

class Req{
    
    static $instance = null;
    static $raw = null;
    public $data = [];
    public $append = [];
    public $error = '';
    
    public static function __init(){
        static::$instance = new Req();
    }
    
    public static function pack($corrtime){
        if(static::$raw == null){
            $parse = [];
            if(static::$instance->data instanceof JsonSerializable)
                $parse['data'] = static::$instance->data->getData();
            else
                $parse['data'] = static::$instance->data;
            $parse['data'] = array_merge($parse['data'], static::$instance->append);
            $parse['data']['server_time'] = time();
            $parse['data']['time_correction'] = $corrtime;
            $parse['error']=static::$instance->error;
            if(Config::get('database.querylog')){
                $parse['qrydebug'] = [
                    'querylog'=>DB::$queryLog,
                    'queryerr'=>DB::errorInfo(),
                ];
                $parse['debug'] = Debug::$logs;
            }
            return json_encode($parse);
        }else 
            return '{"data":{'.static::$raw.',"server_time":'.time().',"time_correction":'.$corrtime.'},"error":""}';
    }
    
    public static function setError($err){
        static::$instance->data = [];
        static::$instance->error = $err;
    }
    
    public static function add($data){
        static::$instance->append = array_merge_recursive(static::$instance->append, $data);
    }
    
    public static function rawData($data){
        static::$raw = $data;
    }
}