<?php
ob_start();

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

define('IN_ENGINE',TRUE);
header('Content-Type: application/json');
define('START_TIME', microtime(true));
define('BASE_DIR', __DIR__.'/..');
define('SERVER_DIR', __DIR__);
define('CACHE_DIR', SERVER_DIR.'/cache');

require_once(SERVER_DIR.'/src/Utils/functions.php');
require_once(SERVER_DIR.'/src/Utils/field.php');
require_once(SERVER_DIR.'/src/Utils/autoloader.php');

\Srv\Core::start();

$_exectime = (microtime(true) - START_TIME);
{
    header('X-Powered-By: Reveres');
    header('X-Github-Source: https://github.com/xReveres/HeroZServer');
    header('X-PHP-Version:'.phpversion());
    header('X-Server: What are you looking for ? This is not allowed, so go from here, and search friends somewhere else.');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Exectime: '.$_exectime);
}
echo \Srv\Req::pack( $_exectime );
ob_end_flush();