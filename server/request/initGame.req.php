<?php
namespace Request;

use Srv\Req;
use Srv\Cache;
use Srv\Config;
use Cls\GameSettings;

class initGame{
    
    public function __request(){
        $configFile = SERVER_DIR.'/config.php';
        if(Cache::exists('initGameData') && Cache::exists('initGameHash') && Cache::getData('initGameHash') == sha1_file($configFile))
            $data = Cache::getFile('initGameData');
        else{
            Cache::storeData('initGameHash', sha1_file($configFile));
            $data = '"constants":'.json_encode(array_merge(GameSettings::returnConstants(), Config::get('constants')), JSON_NUMERIC_CHECK).','.'"extendedConfig":'.json_encode(GameSettings::returnExtendedConfig(), JSON_NUMERIC_CHECK);
            Cache::storeToFile('initGameData', $data);
        }
        Req::rawData($data);
    }
    
}