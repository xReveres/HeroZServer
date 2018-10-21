<?php
namespace Srv;

class Config{
    
    static $_config = null;
    
    public static function __init(){
        static::$_config = include(SERVER_DIR.'/config.php');
    }
    
    public static function get($path)
    {
        $temp = array_path_get($path, static::$_config);
        if(!isset($temp))
            if(func_num_args() == 2)
                $temp = func_get_arg(1);
            else
                throw new \Exception("Can't find '$path' in config");
        return $temp;
    }
    
    public static function exists($path){
        $temp = array_path_get($path, static::$_config);
        return isset($temp);
    }
    
    public static function raw(){
        return static::$_config;
    }
    
}