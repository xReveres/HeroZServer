<?php
namespace Cls\Utils;

class GuildLogType{
    const Unknown = 0;
    const MemberJoined = 1; //
    const MemberLeft = 2; //
    const MemberKicked = 3; //
    const MemberNewRank = 4; //
    const MemberDonated = 5; //
    const GuildStatChanged = 6; //
    const DescriptionChanged = 7;//
    const NoteChanged = 8;//
    const EmblemChanged = 9;//
    const MemberDeleted = 10; //nwm po co to :/ jak jest MemberLeft
    const MissilesRecharged = 11; // 
    const NameChanged = 12; //
    const ArenaChanged = 13; //
    const AutoJoinsRecharged = 14; //
    const GuildBattle_Attack = 101;
    const GuildBattle_Defense = 102;
    const GuildBattle_JoinedAttack = 103;
    const GuildBattle_JoinedDefense = 104;
    const GuildBattle_BattleWon = 105;
    const GuildBattle_BattleLost = 106;
    const GuildBattle_ArtifactWon = 107;
    const GuildBattle_ArtifactLost = 108;
    const GuildBattle_AbortedAttack = 109;
    const GuildBattle_AbortedDefense = 110;
    const GuildBattle_PremiumCurrencyReward = 111;
    const GuildDungeonBattle_Attack = 201;
    const GuildDungeonBattle_Attack_Revenge = 202;
    const GuildDungeonBattle_Joined = 203;
    const GuildDungeonBattle_BattleWon = 204;
    const GuildDungeonBattle_BattleWon_FirstTry = 205;
	const GuildDungeonBattle_BattleLost = 206;
    const GuildDungeonBattle_ImprovementPoint_Rewarded = 207;
    const GuildDungeonBattle_Missiles_Rewarded = 208;
    const GuildDungeonBattle_PremiumCurrency_Rewarded = 209;
    const GuildLeaderVote_Init = 301;
    const GuildLeaderVote_Finished_SameLeader = 302;
    const GuildLeaderVote_Finished_NewLeader = 303;
    const SlotmachineSpin_Coins_Reward = 401;
    const SlotmachineSpin_Item_Reward = 402;
    const SlotmachineSpin_Booster_Reward = 403;
    const SlotmachineSpin_StatPoints_Reward = 404;
    const SlotmachineSpin_Xp_Reward = 405;
    const SlotmachineSpin_Energy_Reward = 406;
    const SlotmachineSpin_Training_Reward = 407;
    const GuildBooster_Bought = 501;
    const GuildBooster_Extended = 502;
    const GuildBooster_Expired = 503;
}