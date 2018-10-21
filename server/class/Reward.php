<?php
namespace Cls;

use JsonSerializable;

class Reward implements JsonSerializable{
    private $reward = [];
    
    public function __construct($reward=false){
        if($reward !== FALSE)
            $this->reward = json_decode($reward, true);
    }
    
    public function exists($k){
        return isset($this->reward[$k]);
    }
    
    public function coins(){
        if(func_num_args()==1)
            $this->reward['coins'] = round(func_get_arg(0));
        else
            return $this->reward['coins'];
    }
    
    public function xp(){
        if(func_num_args()==1)
            $this->reward['xp'] = round(func_get_arg(0));
        else
            return $this->reward['xp'];
    }
    
    public function honor(){
        if(func_num_args()==1)
            $this->reward['honor'] = round(func_get_arg(0));
        else
            return $this->reward['honor'];
    }
    
    public function premium(){
        if(func_num_args()==1)
            $this->reward['premium'] = round(func_get_arg(0));
        else
            return $this->reward['premium'];
    }
    
    public function statPoints(){
        if(func_num_args()==1)
            $this->reward['statPoints'] = round(func_get_arg(0));
        else
            return $this->reward['statPoints'];
    }
    
    public function itemId(){
        if(func_num_args()==1)
            $this->reward['item'] = intval(func_get_arg(0));
        else
            return $this->reward['item'];
    }
    
    public function item(){
        if(func_num_args()==1){
            $item = func_get_arg(0);
            if(is_numeric($item))
                $this->reward['item'] = intval($item);
            else
                $this->reward['item'] = $item->id;
        }else
            return $this->reward['item'];
    }
    
    public function dungeonKey(){
        if(func_num_args()==1)
            $this->reward['dungeonKey'] = func_get_arg(0);
        else
            return $this->reward['dungeonKey'];
    }
    
    public function eventItemIdentifier(){
        if(func_num_args()==1)
            $this->reward['event_item'] = func_get_arg(0);
        else
            return $this->reward['event_item'];
    }
    
    /*TODO:public function herobookItemIdentifier(){
        
    }*/
    
    public function slotMachinJetons(){
        if(func_num_args()==1)
            $this->reward['slotmachine_jetons'] = intval(func_get_arg(0));
        else
            return $this->reward['slotmachine_jetons'];
    }
    
    public function questEnergy(){
        if(func_num_args()==1)
            $this->reward['quest_energy'] = intval(func_get_arg(0));
        else
            return $this->reward['quest_energy'];
    }
    
    public function trainingSessions(){
        if(func_num_args()==1)
            $this->reward['training_sessions'] = intval(func_get_arg(0));
        else
            return $this->reward['training_sessions'];
    }
    
    public function artifactId(){
        if(func_num_args()==1)
            $this->reward['artifact_id'] = intval(func_get_arg(0));
        else
            return $this->reward['artifact_id'];
    }
    
    public function artifactStolen(){
        if(func_num_args()==1)
            $this->reward['artifact_stolen'] = boolval(func_get_arg(0));
        else
            return $this->reward['artifact_stolen'];
    }
    
    public function hasGuildImprovementPoint(){
        if(func_num_args()==1)
            $this->reward['improvement_point'] = intval(func_get_arg(0));
        else
            return $this->reward['improvement_point'];
    }
    
    public function guildMissiles(){
        if(func_num_args()==1)
            $this->reward['missiles'] = intval(func_get_arg(0));
        else
            return $this->reward['missiles'];
    }
    
    public function toArray(){
        return $this->reward;
    }
    
    public function jsonSerialize(){
        return $this->toArray();
    }
    
    public function toJSON(){
        return json_encode($this->toArray());
    }
}