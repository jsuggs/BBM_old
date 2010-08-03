<?php

set_include_path(realpath(dirname(__FILE__)));

use BBM\Pitcher,
    BBM\StartingLineup,
    BBM\Team,
    BBM\Game;

$royH = new Pitcher('Roy','Halladay');
$ccSab = new Pitcher('CC','Sabathia');

$lineup1 = new StartingLineup();
$lineup2 = new StartingLineup();

$lineup1->setStartingPitcher($royH);
$lineup2->setStartingPitcher($ccSab);

$cle = new Team('CLE','Indians','AL');
$phi = new Team('NYY','Yankees','AL');

$phi->setStartingLineup($lineup1);
$cle->setStartingLineup($lineup2);

$game = new Game($phi,$cle,new DateTime());

//echo $royH . "\n";

function __autoload($class)
{
    $className = str_replace('\\','/',$class);
    require_once $className . '.php';
}
