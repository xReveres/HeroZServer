<?php
define('IN_INDEX',TRUE);
//
$start = '2018-08-12 17:00';

if(time() < (strtotime($start)-7200))
    include('countdown.php');
else
    include('game.php');