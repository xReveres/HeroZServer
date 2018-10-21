<?php
namespace Srv;

class Cache{
    
    private static $cache = [];
    
    public static function __init(){
        if(!file_exists(CACHE_DIR.'/data'))
            mkdir(CACHE_DIR.'/data', 0777, true);
        if(!file_exists(CACHE_DIR.'/cache.json')){
            file_put_contents(CACHE_DIR.'/cache.json', '{}');
            return;
        }
        static::$cache = json_decode(file_get_contents(CACHE_DIR.'/cache.json'),true);
        foreach(static::$cache as $name=>$data){
            if($data['expire'] > 0 && microtime(true) > $data['save_time'] + $data['expire'])
                static::remove($name);
        }
    }
    
    public static function getData($name){
        if(static::exists($name)&&static::$cache[$name]['type']!='data')
            return NULL;
        return static::$cache[$name]['data'];
    }
    
    public static function getInfo($name){
        return static::exists($name)?static::$cache[$name]:FALSE;
    }
    
    public static function getHash($name){
        return static::exists($name)?static::$cache[$name]['hash']:FALSE;
    }
    
    public static function getFilePath($name){
        if(!static::exists($name) || static::$cache[$name]['type'] != 'file')
            return FALSE;
        return (CACHE_DIR.'/data/'.static::$cache[$name]['data'].'.tmp');
    }
    
    public static function getFile($name){
        $f = static::getFilePath($name);
        if(!$f || !file_exists($f))
            return FALSE;
        return file_get_contents($f);
    }

    public static function exists($name){
        return isset(static::$cache[$name]);
    }

    public static function remove($name){
        if(static::$cache[$name]['type'] == 'file' && file_exists(CACHE_DIR.'/data/'.static::$cache[$name]['data'].'.tmp'))
            unlink(CACHE_DIR.'/data/'.static::$cache[$name]['data'].'.tmp');
        unset(static::$cache[$name]);
        file_put_contents(CACHE_DIR.'/cache.json', json_encode(static::$cache, JSON_NUMERIC_CHECK));
    }

    public static function storeData($name, $data, $expire=0){
        static::saveCacheInfo($name, 'data', $data, $expire);
    }

    // @expire - expiration time in seconds
    public static function storeFile($name, $file, $expire=0){
        static::storeToFile($name, file_get_contents($file), $expire);
    }
    
    public static function storeToFile($name, $data, $expire=0){
        $cacheName = md5(microtime(true).$name);
        $file = CACHE_DIR."/data/$cacheName.tmp";
        file_put_contents($file, $data);
        static::saveCacheInfo($name, 'file', $cacheName, $expire);
    }
    
    private static function saveCacheInfo($name, $type, $param, $expire){
        static::$cache[$name] = [
            'type'=> $type,
            'data'=> $param,
            'save_time'=> microtime(true),
            'expire'=> $expire
        ];
        //
        file_put_contents(CACHE_DIR.'/cache.json', json_encode(static::$cache, JSON_NUMERIC_CHECK));
    }
    
}