<?php
namespace Srv;

class Debug{
    
    public static $logs = [];
    
    public static function add($val){
        static::$logs[] = $val;
    }
    
}