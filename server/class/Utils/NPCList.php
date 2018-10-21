<?php
namespace Cls\Utils;

class NPCList{
	
	public static $NPC = array(
		'npc_moviestar',
		'npc_adventurer',
		'npc_animator',
		//'npc_artist',
		'npc_bad_artist',
		'npc_ball_stabber',
		//'npc_bttf_buff',
		'npc_business_man_artless',
		'npc_business_man_cool',
		'npc_business_man_respectable',
		'npc_business_man_threatening',
		//'npc_c3_d2',
		'npc_casualguy',
		'npc_cheater',
		'npc_cheese_technic',
		'npc_concierge',
		'npc_cook',
		//'npc_dark_father',
		//'npc_dirty_slob',
		//'npc_disneyinfinity_maleficent',
		'npc_disturbing_neighbor',
		'npc_doglady',
		'npc_dubious_trader',
		//'npc_easterthief',
		'npc_elvis',
		'npc_false_mayor',
		'npc_flyer_distributor',
		//'npc_fonic',
		//'npc_gontrilla_roboter',
		//'npc_grinch',
		'npc_halloween_ghost',
		//'npc_hercules_hydra',
		'npc_hoody_evil',
		'npc_hoody_scruffy',
		'npc_hoody_very_evil',
		//'npc_joker',
		'npc_kangaroo',
		'npc_kids_one_evil',
		'npc_kids_two_evil',
		'npc_kids_two_laughing',
		'npc_loser',
		//'npc_mad_scientist',
		//'npc_mafioso_godfather',
		'npc_magicians',
		//'npc_mario',
		//'npc_marshmellow_man',
		'npc_mastermind',
		'npc_nastier_employee',
		'npc_olympia_crusher',
		'npc_olympia_fencer',
		'npc_olympia_hippies',
		'npc_olympia_robot_small',
		'npc_olympia_winner',
		//'npc_olympia_worldboss',
		'npc_paris_couple',
		'npc_paris_frenchman',
		'npc_paris_gredin',
		'npc_paris_thief',
		//'npc_poacher',
		//'npc_prof_evil',
		//'npc_revenger',
		//'npc_rtl2promo_lora_ley',
		//'npc_sergant',
		'npc_sillycon_valley_boss',
		'npc_sillycon_valley_killer_segway',
		'npc_sillycon_valley_nerd',
		'npc_sillycon_valley_stressed_manager',
		'npc_summer_olympia_ice_vendor',
		'npc_summer_olympia_robot',
		'npc_summer_olympia_sprinter',
		'npc_sunnyboy',
		//'npc_telekom',
		'npc_thief',
		//'npc_tmnt_shredder',
		'npc_tourist',
		'npc_tourists',
		'npc_vegetable_thief',
		'npc_violator',
		'npc_westler',
		'npc_winterolympics_coach',
		'npc_winterolympics_iceman',
		'npc_winterolympics_littlerascal',
		'npc_winterolympics_protestors',
		'npc_winterolympics_yeti',
		'npc_worldcup_fan',
		'npc_worldcup_hotdog_vendor',
		//'npc_worldcup_killjoy',
		'npc_worldcup_security',
		'npc_worldcup_shirt_thief',
		'npc_yokyo_angry_cook',
		'npc_yokyo_mister_wiagi',
		'npc_yokyo_ninja',
		'npc_yokyo_octopus',
		'npc_yokyo_samurai',
		'npc_yokyo_sumo',
		'npc_yoyosurfer',
		//'npc_zombie'
	);
	
	public static $GUILD_DUNGEON = [
		//UNUSED, only for template for next teams
		[ //team0
			'always'=>[],
			'first_half'=>[],
			'second_half'=>[],
			'end'=>[]
		],
		//UNUSED, only for template for next teams
		[ //team1
			'always'=>['npc_dungeon1_npc2', 'npc_dungeon1_npc3'],
			'first_half'=>['npc_cook', 'npc_dungeon2_npc1'],
			'second_half'=>['npc_cook', 'npc_business_man_respectable'],
			'end'=>['npc_dungeon1_npc10']
		],
		[ //team2
			//'always'=>['']
			'first_half'=>['npc_kids_one_evil', 'npc_kids_two_evil', 'npc_kids_two_laughing'],
			'second_half'=>['npc_kids_one_evil', 'npc_kids_two_evil', 'npc_kids_two_laughing'],
			'end'=>['npc_hoody_very_evil']
		],
		[ //team3
			'always'=>['npc_dungeon3_npc6', 'npc_mad_scientist'],
			'first_half'=>['npc_mastermind'],
			'second_half'=>['npc_c3_d2'],
			'end'=>['npc_prof_evil']
		],
		[ //team4
			//'always'=>[],
			'first_half'=>['npc_business_man_artless', 'npc_business_man_respectable'],
			'second_half'=>['npc_business_man_threatening', 'npc_dungeon1_npc4'],
			'end'=>['npc_dungeon2_npc1']
		],
		[ //team5
			'always'=>['npc_elvis'],
			'first_half'=>['npc_dungeon3_npc5'],
			'second_half'=>['npc_dungeon3_npc10'],
			'end'=>['npc_elvis']
		],
		[ //team6
			//'always'=>[],
			'first_half'=>['npc_dungeon2_npc2', 'npc_dungeon2_npc5', 'npc_dungeon2_npc6'],
			'second_half'=>['npc_dungeon2_npc4', 'npc_dungeon2_npc9', 'npc_revenger'],
			'end'=>['npc_dungeon3_npc4']
		],
		[ //team7
			//'always'=>[],
			'first_half'=>['npc_hoody_evil', 'npc_hoody_scruffy', 'npc_hoody_very_evil'],
			'second_half'=>['npc_hoody_evil', 'npc_hoody_scruffy', 'npc_hoody_very_evil'],
			'end'=>['npc_kids_two_evil']
		],
		[ //team8
			//'always'=>[],
			'first_half'=>['npc_dungeon1_npc6', 'npc_dungeon1_npc7'],
			'second_half'=>['npc_cheater', 'npc_dungeon3_npc6', 'npc_mad_scientist'],
			'end'=>['npc_c3_d2']
		],
		[ //team9
			'always'=>['npc_kids_one_evil'],
			'first_half'=>['npc_dungeon3_npc8'],
			'second_half'=>['npc_dungeon3_npc8'],
			'end'=>['npc_mafioso_godfather']
		],
		[ //team10
			'always'=>['npc_business_man_artless', 'npc_dungeon1_npc8'],
			'first_half'=>['npc_dungeon3_npc7', 'npc_sillycon_valley_boss'],
			'second_half'=>['npc_dungeon3_npc9'],
			'end'=>['npc_sillycon_valley_stressed_manager']
		],
		[ //team11
			'always'=>[],
			'first_half'=>['npc_dungeon3_npc1', 'npc_dungeon3_npc5'],
			'second_half'=>['npc_dungeon3_npc2', 'npc_dungeon3_npc3'],
			'end'=>['npc_dungeon3_npc4']
		],
		[ //team12
			'always'=>['npc_business_man_threatening', 'npc_dungeon2_npc8'],
			'first_half'=>['npc_dungeon1_npc1'],
			'second_half'=>['npc_dungeon2_npc9'],
			'end'=>['npc_cook']
		],
		[ //team13
			'always'=>['npc_dungeon2_npc4', 'npc_joker'],
			'first_half'=>['npc_magicians'],
			'second_half'=>['npc_dungeon3_npc4'],
			'end'=>['npc_dark_father']
		],
		[ //team14
			'always'=>['npc_dungeon3_npc6', 'npc_prof_evil', 'npc_sergant'],
			'first_half'=>['npc_dungeon2_npc7', 'npc_dungeon2_npc9', 'npc_elvis'],
			'second_half'=>['npc_cook', 'npc_dungeon2_npc2', 'npc_dungeon2_npc6', 'npc_halloween_ghost'],
			'end'=>['npc_dungeon2_npc5']
		],
		[ //team15
			'always'=>['npc_dungeon1_npc9'],
			'first_half'=>['npc_dark_father', 'npc_joker'],
			'second_half'=>['npc_revenger', 'npc_sergant'],
			'end'=>['npc_prof_evil']
		],
		[ //team16
			//'always'=>[],
			'first_half'=>['npc_dark_father', 'npc_dungeon2_npc5'],
			'second_half'=>['npc_dungeon3_npc6', 'npc_hoody_scruffy'],
			'end'=>['npc_magicians']
		],
		[ //team17
			'always'=>[],
			'first_half'=>['npc_dungeon3_npc7', 'npc_mafioso_godfather'],
			'second_half'=>['npc_business_man_artless', 'npc_dungeon2_npc1'],
			'end'=>['npc_dungeon3_npc9']
		],
		[ //team18
			//'always'=>[],
			'first_half'=>['npc_dungeon1_npc8', 'npc_loser'],
			'second_half'=>['npc_dungeon1_npc10', 'npc_mafioso_godfather'],
			'end'=>['npc_dungeon3_npc10']
		],
		[ //team19
			'always'=>['npc_dark_father'],
			'first_half'=>['npc_dark_father'],
			'second_half'=>['npc_dark_father'],
			'end'=>['npc_dark_father']
		],
		[ //team20
			//'always'=>[],
			'first_half'=>['npc_animator', 'npc_dungeon1_npc9'],
			'second_half'=>['npc_mad_scientist', 'npc_mastermind'],
			'end'=>['npc_dungeon3_npc5']
		],
		[ //team21
			//'always'=>[],
			'first_half'=>['npc_dungeon5_npc7', 'npc_dungeon8_npc4'],
			'second_half'=>['npc_dungeon5_npc6', 'npc_dungeon5_npc8'],
			'end'=>['npc_dungeon8_npc8']
		],
		[ //team22
			//'always'=>[],
			'first_half'=>['npc_c3_d2', 'npc_olympia_robot_small'],
			'second_half'=>['npc_kangaroo', 'npc_zombie'],
			'end'=>['npc_winterolympics_yeti']
		],
		[ //team23
			//'always'=>[],
			'first_half'=>['npc_dungeon1_npc4', 'npc_dungeon8_npc9'],
			'second_half'=>['npc_business_man_respectable', 'npc_dungeon1_npc9'],
			'end'=>['npc_dungeon3_npc10']
		],
		[ //team24
			'always'=>['npc_dungeon7_npc4', 'npc_dungeon7_npc5'],
			'first_half'=>['npc_dungeon7_npc7'],
			'second_half'=>['npc_dungeon7_npc3'],
			'end'=>['npc_dungeon7_npc10']
		],
		[ //team25
			'always'=>['npc_cook', 'npc_dungeon2_npc3', 'npc_dungeon2_npc6'],
			'first_half'=>['npc_winterolympics_iceman', 'npc_worldcup_hotdog_vendor'],
			'second_half'=>['npc_nastier_employee', 'npc_halloween_ghost'],
			'end'=>['npc_dungeon8_npc5']
		],
		[ //team26
			'always'=>['npc_dungeon1_npc2'],
			'first_half'=>['npc_dungeon1_npc5', 'npc_mad_scientist'],
			'second_half'=>['npc_dungeon4_npc8', 'npc_mad_scientist'],
			'end'=>['npc_prof_evil']
		],
		[ //team27
			'always'=>['npc_dungeon5_npc2'],
			'first_half'=>['npc_business_man_artless', 'npc_dungeon1_npc4'],
			'second_half'=>['npc_dungeon2_npc10', 'npc_mafioso_godfather'],
			'end'=>['npc_dungeon4_npc10']
		],
		[ //team28
			'always'=>['npc_artist'],
			'first_half'=>['npc_paris_thief'],
			'second_half'=>['npc_artist'],
			'end'=>['npc_paris_gredin']
		],
	];
	/*
		[ //team0
			'always'=>[],
			'first_half'=>[],
			'second_half'=>[],
			'end'=>[]
		],
	*/

	public static $DUNGEON = [
		[],
		[
			'npc_dungeon1_npc1',
			'npc_dungeon1_npc2',
			'npc_dungeon1_npc3',
			'npc_dungeon1_npc4',
			'npc_dungeon1_npc5',
			'npc_dungeon1_npc6',
			'npc_dungeon1_npc7',
			'npc_dungeon1_npc8',
			'npc_dungeon1_npc9',
			'npc_dungeon1_npc10'
		],
		[
			'npc_dungeon2_npc1',
			'npc_dungeon2_npc2',
			'npc_dungeon2_npc3',
			'npc_dungeon2_npc4',
			'npc_dungeon2_npc5',
			'npc_dungeon2_npc6',
			'npc_dungeon2_npc7',
			'npc_dungeon2_npc8',
			'npc_dungeon2_npc9',
			'npc_dungeon2_npc10'
		],
		[
			'npc_dungeon3_npc1',
			'npc_dungeon3_npc2',
			'npc_dungeon3_npc3',
			'npc_dungeon3_npc4',
			'npc_dungeon3_npc5',
			'npc_dungeon3_npc6',
			'npc_dungeon3_npc7',
			'npc_dungeon3_npc8',
			'npc_dungeon3_npc9',
			'npc_dungeon3_npc10'
		],
		[
			'npc_dungeon4_npc1',
			'npc_dungeon4_npc2',
			'npc_dungeon4_npc3',
			'npc_dungeon4_npc4',
			'npc_dungeon4_npc5',
			'npc_dungeon4_npc6',
			'npc_dungeon4_npc7',
			'npc_dungeon4_npc8',
			'npc_dungeon4_npc9',
			'npc_dungeon4_npc10'
		],
		[
			'npc_dungeon5_npc1',
			'npc_dungeon5_npc2',
			'npc_dungeon5_npc3',
			'npc_dungeon5_npc4',
			'npc_dungeon5_npc5',
			'npc_dungeon5_npc6',
			'npc_dungeon5_npc7',
			'npc_dungeon5_npc8',
			'npc_dungeon5_npc9',
			'npc_dungeon5_npc10'
		],
		[
			'npc_dungeon6_npc1',
			'npc_dungeon6_npc2',
			'npc_dungeon6_npc3',
			'npc_dungeon6_npc4',
			'npc_dungeon6_npc5',
			'npc_dungeon6_npc6',
			'npc_dungeon6_npc7',
			'npc_dungeon6_npc8',
			'npc_dungeon6_npc9',
			'npc_dungeon6_npc10'
		],
		[
			'npc_dungeon7_npc1',
			'npc_dungeon7_npc2',
			'npc_dungeon7_npc3',
			'npc_dungeon7_npc4',
			'npc_dungeon7_npc5',
			'npc_dungeon7_npc6',
			'npc_dungeon7_npc7',
			'npc_dungeon7_npc8',
			'npc_dungeon7_npc9',
			'npc_dungeon7_npc10'
		],
		[
			'npc_dungeon8_npc1',
			'npc_dungeon8_npc2',
			'npc_dungeon8_npc3',
			'npc_dungeon8_npc4',
			'npc_dungeon8_npc5',
			'npc_dungeon8_npc6',
			'npc_dungeon8_npc7',
			'npc_dungeon8_npc8',
			'npc_dungeon8_npc9',
			'npc_dungeon8_npc10'
		],
		[
			'npc_dungeon9_npc1',
			'npc_dungeon9_npc2',
			'npc_dungeon9_npc3',
			'npc_dungeon9_npc4',
			'npc_dungeon9_npc5',
			'npc_dungeon8_npc6',
			'npc_dungeon9_npc7',
			'npc_dungeon9_npc8',
			'npc_dungeon9_npc9',
			'npc_dungeon9_npc10'
		]
	];
}

?>