<?php
namespace Schema;

use Srv\Record;

class GuildInvites extends Record{
    protected static $_TABLE = 'guild_invites';
    
    
    protected static $_FIELDS = [
        'id' => 0,
        'character_id' => 0,
        'guild_id' => 0,
        'ts_creation' => 0
    ];
}