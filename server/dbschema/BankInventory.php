<?php
namespace Schema;

use Srv\Record;
use JsonSerializable;

class BankInventory extends Record implements JsonSerializable{
    protected static $_TABLE = 'bank_inventory';
    
    public function findEmptySlot(){
        $maxslots = ($this->max_bank_index+1) * 18;
        for($i=1; $i<=$maxslots; $i++){
            $slotname = "bank_item{$i}_id";
            if($this->{$slotname}==0)
                return $slotname;
        }
        return null;
    }
    
    public function getSlotByItemId($id){
        $id = intval($id);
		foreach($this->getData() as $iKey => $iVal){
			if($iKey == "id" || $iKey == "character_id" || $iKey == "max_bank_index")
				continue;
			if($iVal == $id)
				return $iKey;
		}
		return null;
    }
    
    public function jsonSerialize() {
        return $this->getData();
    }
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'max_bank_index' => 0,
        'bank_item1_id' => 0,
        'bank_item2_id' => 0,
        'bank_item3_id' => 0,
        'bank_item4_id' => 0,
        'bank_item5_id' => 0,
        'bank_item6_id' => 0,
        'bank_item7_id' => 0,
        'bank_item8_id' => 0,
        'bank_item9_id' => 0,
        'bank_item10_id' => 0,
        'bank_item11_id' => 0,
        'bank_item12_id' => 0,
        'bank_item13_id' => 0,
        'bank_item14_id' => 0,
        'bank_item15_id' => 0,
        'bank_item16_id' => 0,
        'bank_item17_id' => 0,
        'bank_item18_id' => 0,
        'bank_item19_id' => 0,
        'bank_item20_id' => 0,
        'bank_item21_id' => 0,
        'bank_item22_id' => 0,
        'bank_item23_id' => 0,
        'bank_item24_id' => 0,
        'bank_item25_id' => 0,
        'bank_item26_id' => 0,
        'bank_item27_id' => 0,
        'bank_item28_id' => 0,
        'bank_item29_id' => 0,
        'bank_item30_id' => 0,
        'bank_item31_id' => 0,
        'bank_item32_id' => 0,
        'bank_item33_id' => 0,
        'bank_item34_id' => 0,
        'bank_item35_id' => 0,
        'bank_item36_id' => 0,
        'bank_item37_id' => 0,
        'bank_item38_id' => 0,
        'bank_item39_id' => 0,
        'bank_item40_id' => 0,
        'bank_item41_id' => 0,
        'bank_item42_id' => 0,
        'bank_item43_id' => 0,
        'bank_item44_id' => 0,
        'bank_item45_id' => 0,
        'bank_item46_id' => 0,
        'bank_item47_id' => 0,
        'bank_item48_id' => 0,
        'bank_item49_id' => 0,
        'bank_item50_id' => 0,
        'bank_item51_id' => 0,
        'bank_item52_id' => 0,
        'bank_item53_id' => 0,
        'bank_item54_id' => 0,
        'bank_item55_id' => 0,
        'bank_item56_id' => 0,
        'bank_item57_id' => 0,
        'bank_item58_id' => 0,
        'bank_item59_id' => 0,
        'bank_item60_id' => 0,
        'bank_item61_id' => 0,
        'bank_item62_id' => 0,
        'bank_item63_id' => 0,
        'bank_item64_id' => 0,
        'bank_item65_id' => 0,
        'bank_item66_id' => 0,
        'bank_item67_id' => 0,
        'bank_item68_id' => 0,
        'bank_item69_id' => 0,
        'bank_item70_id' => 0,
        'bank_item71_id' => 0,
        'bank_item72_id' => 0,
        'bank_item73_id' => 0,
        'bank_item74_id' => 0,
        'bank_item75_id' => 0,
        'bank_item76_id' => 0,
        'bank_item77_id' => 0,
        'bank_item78_id' => 0,
        'bank_item79_id' => 0,
        'bank_item80_id' => 0,
        'bank_item81_id' => 0,
        'bank_item82_id' => 0,
        'bank_item83_id' => 0,
        'bank_item84_id' => 0,
        'bank_item85_id' => 0,
        'bank_item86_id' => 0,
        'bank_item87_id' => 0,
        'bank_item88_id' => 0,
        'bank_item89_id' => 0,
        'bank_item90_id' => 0
    ];
}