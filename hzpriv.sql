-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas wygenerowania: 12 Paź 2018, 15:13
-- Wersja serwera: 10.1.29-MariaDB-1~wheezy

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `hzpriv`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bank_inventory`
--

CREATE TABLE IF NOT EXISTS `bank_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `max_bank_index` int(11) NOT NULL,
  `bank_item1_id` int(11) NOT NULL,
  `bank_item2_id` int(11) NOT NULL,
  `bank_item3_id` int(11) NOT NULL,
  `bank_item4_id` int(11) NOT NULL,
  `bank_item5_id` int(11) NOT NULL,
  `bank_item6_id` int(11) NOT NULL,
  `bank_item7_id` int(11) NOT NULL,
  `bank_item8_id` int(11) NOT NULL,
  `bank_item9_id` int(11) NOT NULL,
  `bank_item10_id` int(11) NOT NULL,
  `bank_item11_id` int(11) NOT NULL,
  `bank_item12_id` int(11) NOT NULL,
  `bank_item13_id` int(11) NOT NULL,
  `bank_item14_id` int(11) NOT NULL,
  `bank_item15_id` int(11) NOT NULL,
  `bank_item16_id` int(11) NOT NULL,
  `bank_item17_id` int(11) NOT NULL,
  `bank_item18_id` int(11) NOT NULL,
  `bank_item19_id` int(11) NOT NULL,
  `bank_item20_id` int(11) NOT NULL,
  `bank_item21_id` int(11) NOT NULL,
  `bank_item22_id` int(11) NOT NULL,
  `bank_item23_id` int(11) NOT NULL,
  `bank_item24_id` int(11) NOT NULL,
  `bank_item25_id` int(11) NOT NULL,
  `bank_item26_id` int(11) NOT NULL,
  `bank_item27_id` int(11) NOT NULL,
  `bank_item28_id` int(11) NOT NULL,
  `bank_item29_id` int(11) NOT NULL,
  `bank_item30_id` int(11) NOT NULL,
  `bank_item31_id` int(11) NOT NULL,
  `bank_item32_id` int(11) NOT NULL,
  `bank_item33_id` int(11) NOT NULL,
  `bank_item34_id` int(11) NOT NULL,
  `bank_item35_id` int(11) NOT NULL,
  `bank_item36_id` int(11) NOT NULL,
  `bank_item37_id` int(11) NOT NULL,
  `bank_item38_id` int(11) NOT NULL,
  `bank_item39_id` int(11) NOT NULL,
  `bank_item40_id` int(11) NOT NULL,
  `bank_item41_id` int(11) NOT NULL,
  `bank_item42_id` int(11) NOT NULL,
  `bank_item43_id` int(11) NOT NULL,
  `bank_item44_id` int(11) NOT NULL,
  `bank_item45_id` int(11) NOT NULL,
  `bank_item46_id` int(11) NOT NULL,
  `bank_item47_id` int(11) NOT NULL,
  `bank_item48_id` int(11) NOT NULL,
  `bank_item49_id` int(11) NOT NULL,
  `bank_item50_id` int(11) NOT NULL,
  `bank_item51_id` int(11) NOT NULL,
  `bank_item52_id` int(11) NOT NULL,
  `bank_item53_id` int(11) NOT NULL,
  `bank_item54_id` int(11) NOT NULL,
  `bank_item55_id` int(11) NOT NULL,
  `bank_item56_id` int(11) NOT NULL,
  `bank_item57_id` int(11) NOT NULL,
  `bank_item58_id` int(11) NOT NULL,
  `bank_item59_id` int(11) NOT NULL,
  `bank_item60_id` int(11) NOT NULL,
  `bank_item61_id` int(11) NOT NULL,
  `bank_item62_id` int(11) NOT NULL,
  `bank_item63_id` int(11) NOT NULL,
  `bank_item64_id` int(11) NOT NULL,
  `bank_item65_id` int(11) NOT NULL,
  `bank_item66_id` int(11) NOT NULL,
  `bank_item67_id` int(11) NOT NULL,
  `bank_item68_id` int(11) NOT NULL,
  `bank_item69_id` int(11) NOT NULL,
  `bank_item70_id` int(11) NOT NULL,
  `bank_item71_id` int(11) NOT NULL,
  `bank_item72_id` int(11) NOT NULL,
  `bank_item73_id` int(11) NOT NULL,
  `bank_item74_id` int(11) NOT NULL,
  `bank_item75_id` int(11) NOT NULL,
  `bank_item76_id` int(11) NOT NULL,
  `bank_item77_id` int(11) NOT NULL,
  `bank_item78_id` int(11) NOT NULL,
  `bank_item79_id` int(11) NOT NULL,
  `bank_item80_id` int(11) NOT NULL,
  `bank_item81_id` int(11) NOT NULL,
  `bank_item82_id` int(11) NOT NULL,
  `bank_item83_id` int(11) NOT NULL,
  `bank_item84_id` int(11) NOT NULL,
  `bank_item85_id` int(11) NOT NULL,
  `bank_item86_id` int(11) NOT NULL,
  `bank_item87_id` int(11) NOT NULL,
  `bank_item88_id` int(11) NOT NULL,
  `bank_item89_id` int(11) NOT NULL,
  `bank_item90_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `battle`
--

CREATE TABLE IF NOT EXISTS `battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ts_creation` int(11) NOT NULL,
  `profile_a_stats` text NOT NULL,
  `profile_b_stats` text NOT NULL,
  `winner` varchar(1) NOT NULL,
  `rounds` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `character`
--

CREATE TABLE IF NOT EXISTS `character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `game_currency` int(11) unsigned NOT NULL DEFAULT '0',
  `xp` int(11) unsigned NOT NULL DEFAULT '0',
  `level` int(11) unsigned NOT NULL DEFAULT '1',
  `description` varchar(255) NOT NULL,
  `note` varchar(512) NOT NULL,
  `ts_last_action` int(11) NOT NULL,
  `score_honor` int(11) NOT NULL DEFAULT '10',
  `score_level` int(11) NOT NULL DEFAULT '10',
  `stat_points_available` mediumint(9) NOT NULL,
  `stat_base_stamina` smallint(6) NOT NULL DEFAULT '10',
  `stat_base_strength` smallint(6) NOT NULL DEFAULT '10',
  `stat_base_critical_rating` smallint(6) NOT NULL DEFAULT '10',
  `stat_base_dodge_rating` smallint(6) NOT NULL DEFAULT '10',
  `stat_bought_stamina` mediumint(8) NOT NULL,
  `stat_bought_strength` mediumint(8) NOT NULL,
  `stat_bought_critical_rating` mediumint(8) NOT NULL,
  `stat_bought_dodge_rating` mediumint(8) NOT NULL,
  `active_quest_booster_id` varchar(25) NOT NULL,
  `ts_active_quest_boost_expires` int(11) NOT NULL,
  `active_stats_booster_id` varchar(25) NOT NULL,
  `ts_active_stats_boost_expires` int(11) NOT NULL,
  `active_work_booster_id` varchar(25) NOT NULL,
  `ts_active_work_boost_expires` int(11) NOT NULL,
  `ts_active_sense_boost_expires` int(11) NOT NULL,
  `active_league_booster_id` tinyint(3) NOT NULL,
  `ts_active_league_boost_expires` int(11) NOT NULL,
  `ts_active_multitasking_boost_expires` int(11) NOT NULL,
  `max_quest_stage` smallint(6) NOT NULL DEFAULT '1',
  `current_quest_stage` smallint(6) NOT NULL DEFAULT '1',
  `quest_energy` smallint(6) NOT NULL DEFAULT '100',
  `max_quest_energy` smallint(6) NOT NULL DEFAULT '100',
  `ts_last_quest_energy_refill` int(11) NOT NULL,
  `quest_energy_refill_amount_today` smallint(6) NOT NULL,
  `quest_reward_training_sessions_rewarded_today` smallint(6) NOT NULL,
  `honor` mediumint(8) unsigned NOT NULL DEFAULT '100',
  `ts_last_duel` int(11) NOT NULL,
  `duel_stamina` smallint(6) NOT NULL DEFAULT '100',
  `max_duel_stamina` smallint(6) NOT NULL DEFAULT '100',
  `ts_last_duel_stamina_change` int(11) NOT NULL,
  `ts_last_duel_enemies_refresh` int(11) NOT NULL,
  `current_work_offer_id` varchar(32) NOT NULL DEFAULT 'work1',
  `stat_trained_stamina` mediumint(8) NOT NULL,
  `stat_trained_strength` mediumint(8) NOT NULL,
  `stat_trained_critical_rating` mediumint(8) NOT NULL,
  `stat_trained_dodge_rating` mediumint(8) NOT NULL,
  `training_progress_value_stamina` smallint(8) NOT NULL,
  `training_progress_value_strength` mediumint(8) NOT NULL,
  `training_progress_value_critical_rating` mediumint(8) NOT NULL,
  `training_progress_value_dodge_rating` mediumint(8) NOT NULL,
  `training_progress_end_stamina` smallint(6) NOT NULL DEFAULT '3',
  `training_progress_end_strength` smallint(6) NOT NULL DEFAULT '3',
  `training_progress_end_critical_rating` smallint(6) NOT NULL DEFAULT '3',
  `training_progress_end_dodge_rating` smallint(6) NOT NULL DEFAULT '3',
  `ts_last_training` int(11) NOT NULL,
  `training_count` smallint(6) NOT NULL DEFAULT '10',
  `max_training_count` smallint(6) NOT NULL DEFAULT '10',
  `active_worldboss_attack_id` int(11) NOT NULL,
  `active_dungeon_quest_id` int(11) NOT NULL,
  `ts_last_dungeon_quest_fail` int(11) NOT NULL,
  `max_dungeon_index` int(11) NOT NULL,
  `appearance_skin_color` tinyint(3) NOT NULL,
  `appearance_hair_color` tinyint(3) NOT NULL,
  `appearance_hair_type` tinyint(3) NOT NULL,
  `appearance_head_type` tinyint(3) NOT NULL,
  `appearance_eyes_type` tinyint(3) NOT NULL,
  `appearance_eyebrows_type` tinyint(3) NOT NULL,
  `appearance_nose_type` tinyint(3) NOT NULL,
  `appearance_mouth_type` tinyint(3) NOT NULL,
  `appearance_facial_hair_type` tinyint(3) NOT NULL,
  `appearance_decoration_type` tinyint(3) NOT NULL DEFAULT '1',
  `show_mask` tinyint(1) NOT NULL DEFAULT '1',
  `tutorial_flags` text NOT NULL,
  `guild_id` int(11) NOT NULL,
  `guild_rank` tinyint(2) NOT NULL,
  `ts_guild_joined` int(11) NOT NULL,
  `finished_guild_battle_attack_id` int(11) NOT NULL,
  `finished_guild_battle_defense_id` int(11) NOT NULL,
  `finished_guild_dungeon_battle_id` int(11) NOT NULL,
  `guild_donated_game_currency` int(11) NOT NULL,
  `guild_donated_premium_currency` int(11) NOT NULL,
  `worldboss_event_id` int(11) NOT NULL,
  `worldboss_event_attack_count` smallint(6) NOT NULL,
  `ts_last_wash_item` int(11) NOT NULL,
  `ts_last_daily_login_bonus` int(11) NOT NULL,
  `daily_login_bonus_day` tinyint(3) NOT NULL DEFAULT '1',
  `pending_tournament_rewards` int(11) NOT NULL,
  `ts_last_shop_refresh` int(11) NOT NULL,
  `shop_refreshes` smallint(6) NOT NULL,
  `event_quest_id` int(11) NOT NULL,
  `friend_data` varchar(32) NOT NULL,
  `pending_resource_requests` smallint(6) NOT NULL,
  `unused_resources` varchar(32) NOT NULL DEFAULT '{"1":4,"2":1}',
  `used_resources` int(11) NOT NULL,
  `league_points` int(11) NOT NULL,
  `league_group_id` int(11) NOT NULL,
  `active_league_fight_id` int(11) NOT NULL,
  `ts_last_league_fight` int(11) NOT NULL,
  `league_fight_count` int(11) NOT NULL,
  `league_opponents` varchar(32) NOT NULL,
  `ts_last_league_opponents_refresh` int(11) NOT NULL,
  `league_stamina` smallint(6) NOT NULL DEFAULT '20',
  `max_league_stamina` smallint(6) NOT NULL DEFAULT '20',
  `ts_last_league_stamina_change` int(11) NOT NULL,
  `league_stamina_cost` int(11) NOT NULL DEFAULT '20',
  `herobook_objectives_renewed_today` int(11) NOT NULL,
  `slotmachine_spin_count` int(11) NOT NULL,
  `ts_last_slotmachine_refill` int(11) NOT NULL,
  `new_user_voucher_ids` varchar(32) NOT NULL,
  `current_energy_storage` int(11) NOT NULL,
  `current_training_storage` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `guild_id` (`guild_id`),
  KEY `user_id` (`user_id`),
  KEY `honor` (`honor`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `duel`
--

CREATE TABLE IF NOT EXISTS `duel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ts_creation` int(11) NOT NULL,
  `battle_id` int(11) NOT NULL,
  `character_a_id` int(11) NOT NULL,
  `character_b_id` int(11) NOT NULL,
  `character_a_status` tinyint(1) NOT NULL DEFAULT '1',
  `character_b_status` tinyint(1) NOT NULL DEFAULT '1',
  `character_a_rewards` text NOT NULL,
  `character_b_rewards` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attackerduel` (`character_a_id`,`character_a_status`),
  KEY `defenderduel` (`character_b_id`,`character_b_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild`
--

CREATE TABLE IF NOT EXISTS `guild` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ts_creation` int(11) NOT NULL,
  `initiator_character_id` int(11) NOT NULL,
  `leader_character_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `note` text NOT NULL,
  `forum_page` varchar(128) NOT NULL,
  `premium_currency` int(11) NOT NULL,
  `game_currency` int(11) NOT NULL DEFAULT '500',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `accept_members` tinyint(1) NOT NULL,
  `honor` int(11) NOT NULL DEFAULT '1000',
  `artifact_ids` text NOT NULL,
  `missiles` int(11) NOT NULL DEFAULT '15',
  `auto_joins` tinyint(1) NOT NULL,
  `battles_attacked` int(11) NOT NULL,
  `battles_defended` int(11) NOT NULL,
  `battles_won` int(11) NOT NULL,
  `battles_lost` int(11) NOT NULL,
  `artifacts_won` int(11) NOT NULL,
  `artifacts_lost` int(11) NOT NULL,
  `artifacts_owned_max` int(11) NOT NULL DEFAULT '2',
  `artifacts_owned_current` int(11) NOT NULL,
  `ts_last_artifact_released` int(11) NOT NULL,
  `missiles_fired` int(11) NOT NULL,
  `auto_joins_used` tinyint(1) NOT NULL,
  `dungeon_battles_fought` int(11) NOT NULL,
  `dungeon_battles_won` int(11) NOT NULL,
  `stat_points_available` int(11) NOT NULL,
  `stat_guild_capacity` int(11) NOT NULL DEFAULT '10',
  `stat_character_base_stats_boost` int(11) NOT NULL DEFAULT '1',
  `stat_quest_xp_reward_boost` int(11) NOT NULL DEFAULT '1',
  `stat_quest_game_currency_reward_boost` int(11) NOT NULL DEFAULT '1',
  `arena_background` smallint(3) NOT NULL DEFAULT '1',
  `emblem_background_shape` tinyint(3) NOT NULL DEFAULT '1',
  `emblem_background_color` tinyint(3) NOT NULL DEFAULT '2',
  `emblem_background_border_color` tinyint(3) NOT NULL,
  `emblem_icon_shape` tinyint(3) NOT NULL DEFAULT '1',
  `emblem_icon_color` tinyint(3) NOT NULL DEFAULT '4',
  `emblem_icon_size` smallint(3) NOT NULL DEFAULT '100',
  `use_missiles_attack` tinyint(1) NOT NULL DEFAULT '1',
  `use_missiles_defense` tinyint(1) NOT NULL DEFAULT '1',
  `use_missiles_dungeon` tinyint(1) NOT NULL DEFAULT '1',
  `use_auto_joins_attack` tinyint(1) NOT NULL DEFAULT '1',
  `use_auto_joins_defense` tinyint(1) NOT NULL DEFAULT '1',
  `use_auto_joins_dungeon` tinyint(1) NOT NULL DEFAULT '1',
  `pending_leader_vote_id` int(11) NOT NULL,
  `min_apply_level` int(11) NOT NULL,
  `min_apply_honor` int(11) NOT NULL,
  `guild_battle_tactics_attack_order` int(11) NOT NULL DEFAULT '1',
  `guild_battle_tactics_attack_tactic` int(11) NOT NULL DEFAULT '10',
  `guild_battle_tactics_defense_order` int(11) NOT NULL DEFAULT '1',
  `guild_battle_tactics_defense_tactic` int(11) NOT NULL DEFAULT '10',
  `active_training_booster_id` varchar(40) NOT NULL,
  `ts_active_training_boost_expires` int(11) NOT NULL,
  `active_quest_booster_id` varchar(40) NOT NULL,
  `ts_active_quest_boost_expires` int(11) NOT NULL,
  `active_duel_booster_id` varchar(40) NOT NULL,
  `ts_active_duel_boost_expires` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `honor` (`honor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_battle`
--

CREATE TABLE IF NOT EXISTS `guild_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `battle_time` tinyint(1) NOT NULL,
  `ts_attack` int(11) NOT NULL,
  `guild_attacker_id` int(11) NOT NULL,
  `guild_defender_id` int(11) NOT NULL,
  `attacker_character_ids` text NOT NULL,
  `defender_character_ids` text NOT NULL,
  `guild_winner_id` int(11) NOT NULL,
  `attacker_character_profiles` text NOT NULL,
  `defender_character_profiles` text NOT NULL,
  `rounds` text NOT NULL,
  `attacker_rewards` text NOT NULL,
  `defender_rewards` text NOT NULL,
  `initiator_character_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attackerbattle` (`guild_attacker_id`,`status`),
  KEY `defenderbattle` (`guild_defender_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_battle_rewards`
--

CREATE TABLE IF NOT EXISTS `guild_battle_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guild_battle_id` int(11) NOT NULL,
  `character_id` int(111) NOT NULL,
  `game_currency` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attackerreward` (`character_id`,`type`),
  KEY `battlereward` (`guild_battle_id`,`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_dungeon`
--

CREATE TABLE IF NOT EXISTS `guild_dungeon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guild_id` int(11) NOT NULL,
  `npc_team_identifier` varchar(10) NOT NULL,
  `npc_team_character_profiles` text NOT NULL,
  `settings` text NOT NULL,
  `ts_unlock` int(11) NOT NULL,
  `locking_character_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `guild_id` (`guild_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_dungeon_battle`
--

CREATE TABLE IF NOT EXISTS `guild_dungeon_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `battle_time` tinyint(1) NOT NULL,
  `ts_attack` int(11) NOT NULL,
  `guild_id` int(11) NOT NULL,
  `npc_team_identifier` varchar(10) NOT NULL,
  `settings` text NOT NULL,
  `character_ids` text NOT NULL,
  `joined_character_profiles` text NOT NULL,
  `npc_team_character_profiles` text NOT NULL,
  `rounds` text NOT NULL,
  `rewards` text NOT NULL,
  `initiator_character_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_invites`
--

CREATE TABLE IF NOT EXISTS `guild_invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `guild_id` int(11) NOT NULL,
  `ts_creation` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`),
  KEY `guild_id` (`guild_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_logs`
--

CREATE TABLE IF NOT EXISTS `guild_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guild_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `character_name` varchar(32) NOT NULL,
  `type` int(11) NOT NULL,
  `value1` varchar(64) NOT NULL,
  `value2` varchar(64) NOT NULL,
  `value3` varchar(64) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `log` (`guild_id`,`timestamp`,`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guild_messages`
--

CREATE TABLE IF NOT EXISTS `guild_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guild_id` int(11) NOT NULL,
  `character_from_id` int(11) NOT NULL,
  `character_from_name` varchar(32) NOT NULL,
  `character_to_id` int(11) NOT NULL,
  `is_officer` tinyint(1) NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `message` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message` (`guild_id`,`character_to_id`,`is_private`,`is_officer`),
  KEY `tsmessage` (`guild_id`,`timestamp`,`character_from_id`,`character_to_id`,`is_officer`,`is_private`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `mask_item_id` int(11) NOT NULL,
  `cape_item_id` int(11) NOT NULL,
  `suit_item_id` int(11) NOT NULL,
  `belt_item_id` int(11) NOT NULL,
  `boots_item_id` int(11) NOT NULL,
  `weapon_item_id` int(11) NOT NULL,
  `gadget_item_id` int(11) NOT NULL,
  `missiles_item_id` int(11) NOT NULL,
  `missiles1_item_id` int(11) NOT NULL DEFAULT '-1',
  `missiles2_item_id` int(11) NOT NULL DEFAULT '-1',
  `missiles3_item_id` int(11) NOT NULL DEFAULT '-1',
  `missiles4_item_id` int(11) NOT NULL DEFAULT '-1',
  `sidekick_id` int(11) NOT NULL,
  `bag_item1_id` int(11) NOT NULL,
  `bag_item2_id` int(11) NOT NULL,
  `bag_item3_id` int(11) NOT NULL,
  `bag_item4_id` int(11) NOT NULL,
  `bag_item5_id` int(11) NOT NULL,
  `bag_item6_id` int(11) NOT NULL,
  `bag_item7_id` int(11) NOT NULL,
  `bag_item8_id` int(11) NOT NULL,
  `bag_item9_id` int(11) NOT NULL,
  `bag_item10_id` int(11) NOT NULL,
  `bag_item11_id` int(11) NOT NULL,
  `bag_item12_id` int(11) NOT NULL,
  `bag_item13_id` int(11) NOT NULL,
  `bag_item14_id` int(11) NOT NULL,
  `bag_item15_id` int(11) NOT NULL,
  `bag_item16_id` int(11) NOT NULL,
  `bag_item17_id` int(11) NOT NULL,
  `bag_item18_id` int(11) NOT NULL,
  `shop_item1_id` int(11) NOT NULL,
  `shop_item2_id` int(11) NOT NULL,
  `shop_item3_id` int(11) NOT NULL,
  `shop_item4_id` int(11) NOT NULL,
  `shop_item5_id` int(11) NOT NULL,
  `shop_item6_id` int(11) NOT NULL,
  `shop_item7_id` int(11) NOT NULL,
  `shop_item8_id` int(11) NOT NULL,
  `shop_item9_id` int(11) NOT NULL,
  `shop2_item1_id` int(11) NOT NULL,
  `shop2_item2_id` int(11) NOT NULL,
  `shop2_item3_id` int(11) NOT NULL,
  `shop2_item4_id` int(11) NOT NULL,
  `shop2_item5_id` int(11) NOT NULL,
  `shop2_item6_id` int(11) NOT NULL,
  `shop2_item7_id` int(11) NOT NULL,
  `shop2_item8_id` int(11) NOT NULL,
  `shop2_item9_id` int(11) NOT NULL,
  `item_set_data` varchar(64) NOT NULL,
  `sidekick_data` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `quality` tinyint(3) NOT NULL,
  `required_level` smallint(6) NOT NULL,
  `charges` tinyint(4) NOT NULL,
  `item_level` smallint(6) NOT NULL,
  `ts_availability_start` int(11) NOT NULL,
  `ts_availability_end` int(11) NOT NULL,
  `premium_item` tinyint(1) NOT NULL DEFAULT '0',
  `buy_price` mediumint(8) NOT NULL,
  `sell_price` mediumint(8) NOT NULL,
  `stat_stamina` mediumint(8) NOT NULL,
  `stat_strength` mediumint(8) NOT NULL,
  `stat_critical_rating` mediumint(8) NOT NULL,
  `stat_dodge_rating` mediumint(8) NOT NULL,
  `stat_weapon_damage` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_from_id` int(11) NOT NULL,
  `character_to_ids` mediumtext NOT NULL,
  `subject` varchar(80) NOT NULL,
  `message` text NOT NULL,
  `flag` varchar(64) NOT NULL,
  `flag_value` varchar(64) NOT NULL,
  `ts_creation` int(11) NOT NULL,
  `readed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_from_id`),
  FULLTEXT KEY `character_to_id` (`character_to_ids`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `identifier` varchar(32) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `stage` tinyint(3) NOT NULL,
  `level` mediumint(8) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `duration_type` tinyint(3) NOT NULL DEFAULT '1',
  `duration_raw` smallint(6) NOT NULL,
  `duration` smallint(6) NOT NULL,
  `ts_complete` int(11) NOT NULL DEFAULT '0',
  `energy_cost` smallint(6) NOT NULL,
  `fight_difficulty` tinyint(3) NOT NULL DEFAULT '0',
  `fight_npc_identifier` varchar(60) NOT NULL,
  `fight_battle_id` int(11) NOT NULL DEFAULT '0',
  `used_resources` tinyint(3) NOT NULL DEFAULT '0',
  `rewards` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quests` (`character_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slotmachines`
--

CREATE TABLE IF NOT EXISTS `slotmachines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(10) unsigned NOT NULL,
  `slotmachine_reward_quality` tinyint(3) unsigned NOT NULL,
  `slotmachine_slot1` tinyint(3) unsigned NOT NULL,
  `slotmachine_slot2` tinyint(3) unsigned NOT NULL,
  `slotmachine_slot3` tinyint(3) unsigned NOT NULL,
  `reward` text NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `character_id` (`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `training`
--

CREATE TABLE IF NOT EXISTS `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `stat_type` tinyint(1) NOT NULL,
  `ts_creation` int(11) NOT NULL,
  `ts_complete` int(11) NOT NULL,
  `iterations` tinyint(1) NOT NULL,
  `used_resources` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `training` (`character_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_source` varchar(64) NOT NULL DEFAULT 'ref=;subid=;lp=default_newCharacter_25M;',
  `registration_ip` varchar(45) DEFAULT NULL,
  `ts_creation` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_new` varchar(100) NOT NULL,
  `password_hash` varchar(40) NOT NULL,
  `last_login_ip` varchar(45) NOT NULL,
  `login_count` int(11) NOT NULL,
  `ts_last_login` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `session_id_cache1` varchar(32) NOT NULL,
  `session_id_cache2` varchar(32) NOT NULL,
  `session_id_cache3` varchar(32) NOT NULL,
  `session_id_cache4` varchar(32) NOT NULL,
  `session_id_cache5` varchar(32) NOT NULL,
  `premium_currency` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(6) NOT NULL DEFAULT 'pl_PL',
  `network` varchar(10) NOT NULL,
  `geo_country_code` varchar(3) NOT NULL DEFAULT 'PL',
  `geo_country_code3` varchar(3) NOT NULL,
  `geo_country_name` varchar(16) NOT NULL DEFAULT 'Poland',
  `geo_continent_code` varchar(3) NOT NULL DEFAULT 'EU',
  `settings` varchar(250) NOT NULL DEFAULT '{"tos_sep2015":true}',
  `ts_banned` int(11) NOT NULL,
  `trusted` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `login` (`email`,`password_hash`),
  KEY `autologin` (`id`,`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `work_offer_id` varchar(64) NOT NULL,
  `status` smallint(3) NOT NULL,
  `duration` int(11) NOT NULL,
  `ts_complete` int(11) NOT NULL,
  `rewards` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `work` (`character_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
