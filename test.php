<?php

set_include_path(realpath(dirname(__FILE__)));

use BBM\Pitcher,
    BBM\StartingLineup,
    BBM\Team,
    BBM\Game,
    BBM\BettingPlanService,
    BBM\Strategies\RecentGameStrategy;

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

$game1 = new Game($phi,$cle,new DateTime('2010-09-01'));
$game2 = new Game($phi,$cle,new DateTime('2010-09-02'));
$game3 = new Game($phi,$cle,new DateTime('2010-09-04'));

// Create a set of games
$games = array($game1,$game2,$game3);
$strategies = array(new RecentGameStrategy());

// Return a Betting Plan
$plan = new BBM\BettingPlanService($games,$strategies);

// Apply the betting plan
$plan->applyToGames($games);

//echo $royH . "\n";

function __autoload($class)
{
    $className = str_replace('\\','/',$class);
    require_once $className . '.php';
}
