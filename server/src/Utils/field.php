<?php
define('FIELD_BOOL',    1);
define('FIELD_NUM',     2);
define('FIELD_ALPHA',   4);
define('FIELD_ALNUM',   8);
define('FIELD_EMAIL',   16);
define('FIELD_MD5',     32);
define('FIELD_SHA1',    64);
define('FIELD_FLAG',    128);

function getField($name, $flags=0, $default=null){
    $var = isset_or($_POST[$name]);
    return checkVar($var, $flags, $default);
}

function isField($name){
    return isset($_POST[$name]);
}

function checkVar($var, $flags=0, $default=null){
    //Return if field is not set
    if(is_null($var)) return $default;
    //Return if flag isn't set
    if(!$flags) return $var;
    $result = false;
    //Check flags
    if(($flags & FIELD_BOOL) == FIELD_BOOL && checkBool($var))
        $result = true;
    if(($flags & FIELD_NUM) == FIELD_NUM && is_numeric($var))
        $result = true;
    if(($flags & FIELD_ALPHA) == FIELD_ALPHA && ctype_alpha($var))
        $result = true;
    if(($flags & FIELD_ALNUM) == FIELD_ALNUM && ctype_alnum($var))
        $result = true;
    if(($flags & FIELD_EMAIL) == FIELD_EMAIL && filter_var($var, FILTER_VALIDATE_EMAIL))
        $result = true;
    if(($flags & FIELD_MD5) == FIELD_MD5 && checkMD5($var))
        $result = true;
    if(($flags & FIELD_SHA1) == FIELD_SHA1 && checkSHA1($var))
        $result = true;
    return $result?$var:$default;
}

function checkBool($str){
    $str = strtolower($str);
    return (in_array($str, array("true", "false", "1", "0"), true));
}

function checkMD5($str){
    return preg_match('#^[a-z0-9]{32}$#i', $str);
}

function checkSHA1($str){
    return preg_match('#^[a-z0-9]{40}$#i', $str);
}