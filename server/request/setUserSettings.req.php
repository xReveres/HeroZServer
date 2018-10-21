<?php
namespace Request;

use Srv\Core;

class setUserSettings{
    public function __request($player){
        $get_setting = getField('settings');
        if(!$get_setting) return;

        $settings = json_decode($player->user->settings, true);
		$clientSettings = json_decode($get_setting, true);
		
		foreach($clientSettings as $sKey => $sVal)
			$settings[$sKey] = $sVal;
			
		$setting = json_encode($settings);
		
		$player->user->settings = $setting;
        
        Core::req()->data = array('user'=>$player->user->toArray());
    }
}