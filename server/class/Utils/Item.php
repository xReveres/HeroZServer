<?php
namespace Cls\Utils;

class Item{
	
	public static $QUALITY = [
		1=>'common',
		2=>'rare',
		3=>'epic'
	];
	
	public static $QUALITY_ID =[
		'common'=>1,
		'rare'=>2,
		'epic'=>3
	];
    
    public static $TYPE = [
		0=>"unknown",
		1=>"mask",
		2=>"cape",
		3=>"suit",
		4=>"belt",
		5=>"boots",
		6=>"weapon",
		7=>"gadget",
		8=>"missiles",
		9=>"sidekick",
		10=>"surprise",
		11=>"reskill"
	];
	
	public static $TYPE_ID = [
		"unknown"=>0,
		"mask"=>1,
		"cape"=>2,
		"suit"=>3,
		"belt"=>4,
		"boots"=>5,
		"weapon"=>6,
		"gadget"=>7,
		"missiles"=>8,
		"sidekick"=>9,
		"surprise"=>10,
		"reskill"=>11
	];
	
	public static $USABLE = [9,10,11];
	
}