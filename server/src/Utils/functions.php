<?php

function array_path_get($path, &$array){
    $exploded = explode('.', $path);
    $temp =& $array;
    foreach($exploded as $key){
        if(isset($temp[$key]))
            $temp =& $temp[$key];
        else
            return;
    }
    return $temp;
}

function array_path_set($path, $val, &$array){
    $exploded = explode('.', $path);
    $temp =& $array;
    foreach($exploded as $key){
        if(isset($temp[$key]))
            $temp =& $temp[$key];
        else{
            $temp[$key] = [];
            $temp =& $temp[$key];
        }
    }
    $temp = $val;
}

function recursive_implode($myArray)
{
    $ritit = new RecursiveIteratorIterator(new RecursiveArrayIterator($myArray));
    $result = array();
    foreach ($ritit as $leafValue) {
        $keys = array();
        foreach (range(0, $ritit->getDepth()) as $depth)
            $keys[] = $ritit->getSubIterator($depth)->key();
        
        $result[] = join('.', $keys);
    }
    return $result;
}

function is_assoc($arr){
    foreach(array_keys($arr) as $i=>$key)
        if ($i!=$key) return TRUE;
    return FALSE;
}

function getclientip(){
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function isset_or(&$var, $default = null)
{
    return (isset($var)) ? $var : $default;
}

function arrayToObject($arr, $classname){
    $cls = new $classname;
    foreach($arr as $k=>$v)
        $cls->{$k} = $v;
    return $cls;
}

function str_islengthadd($var, $length, $text, $operator='=='){
    switch($operator){
        case '==':
            if(strlen($var) == $length)
                return $var.$text;
            return $var;
        case '<':
            if(strlen($var) < $length)
                return $var.$text;
            return $var;
        case '>':
            if(strlen($var) > $length)
                return $var.$text;
            return $var;
        case '<=':
            if(strlen($var) <= $length)
                return $var.$text;
            return $var;
        case '>=':
            if(strlen($var) >= $length)
                return $var.$text;
            return $var;
        case '!=':
            if(strlen($var) != $length)
                return $var.$text;
            return $var;
    }
    
}

function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}
    
function cPVar($path){
    $var = explode('.',$path);
    $varname = array_shift($var);
    $tabs = "";
    if(count($var) > 0)
        $tabs = '["'.implode('"]["', $var).'"]';
    return "$$varname".$tabs;
}

function url($var=null){
    if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || isset_or($_SERVER['SERVER_PORT'], null) == 443 || isset_or($_SERVER['HTTP_X_FORWARDED_PORT'], null) == 443)
        $protocol = 'https';
    else
        $protocol = 'http';
            
    $url = sprintf('%s://%s/%s', $protocol, $_SERVER['HTTP_HOST'], trim(dirname($_SERVER['SCRIPT_NAME']), '/'));
    
    $url = str_replace('/admin', '', $url);
    
    if(is_array($var))
        $url .= '/'.implode('/', $var);
    else
        $url .= '/'.trim(str_replace(BASE_DIR.'/', '', $var), '/');

    return rtrim($url,'/');
}

function currentURL()
{
    if(defined('ADMIN'))
        return url([ADMIN,implode('/', parseURL())]);
    return url(implode('/', parseURL()));
}

function parseURL($key = null)
{
    $url    = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $url    = trim(str_replace($url, '', $_SERVER['REQUEST_URI']), '/');
    $url    = explode('?', $url);
    $array  = explode('/', $url[0]);

    if($key) return isset_or($array[$key-1], false);
    else return $array;
}

function redirect($url=null, $time=0, $ex = true){
    if($url === null)
        $url = currentURL();
    if(is_array($url))
        $url = url($url);
    if($time>0)
        header('refresh:'.$time.';url='.$url);
    else
        header('Location:'.$url);
    if($ex)
        exit();
}

function reformatdate($format, $olddate){
    return date($format, strtotime($olddate));
}

function array_outer_combine($arr1,$arr2){
    $arr = [];
    foreach($arr2 as $kys)
        if(isset($arr1[$kys]))
            $arr[$kys] = $arr1[$kys];
    return $arr;
}

/**/
function toBool($str){
    $str = strtolower($str);
    return (in_array($str, array("true", "1"), true));
}

function typeVar($var){
    if(is_numeric($var))
        return intval($var);
    if($var==='true'||$var==='false')
        return $var==='true';
    return $var;
}

function random($min=0, $max=1){
    return $min + abs($max - $min) * mt_rand(0, mt_getrandmax())/mt_getrandmax();
}

function timestamp(){
    return Srv\Core::timestamp();
}

function debug($val){
    \Srv\Debug::add($val);
}

function clamp($min, $max, $value){
    if($value < $min)
        return $min;
    else if($value > $max)
        return $max;
    return $value;
}

function cast($object, $class) {
    $cls = new $class();
    $vars = get_public_vars($cls);
    foreach($vars as $k=>$v)
        $cls->{$k} = $object->{$k};
    return $cls;
}

function get_public_vars($object){
    return get_object_vars($object);
}

function array_push_notnull(&$array, $object){
    if(!is_null($object))
        array_push($array, $object);
}

function random_between($rands){
    if(count($rands) < 2)
        throw new \InvalidArgumentException('$rands argument must be an array with minimum 2 elements');
    asort($rands);
    $min = 0;
    $vals = array_values($rands);
    $max = array_pop($vals);
    $rand = random($min, $max);
    foreach($rands as $ret=>$val){
        if($rand <= $val)
            return $ret;
    }
}

function array_unset(&$arr, $keys = []){
    foreach($keys as $key)
        unset($arr[$key]);
}