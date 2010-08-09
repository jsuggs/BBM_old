<?php

set_include_path(realpath(dirname(__FILE__)));

use BBM\Pitcher,
    BBM\StartingLineup,
    BBM\Team,
    BBM\Game,
    BBM\GameRepository,
    BBM\BettingPlanService,
    BBM\Strategies\RecentGameStrategy;

$gameRepository = new GameRepository();

// Create a set of games
$games = $gameRepository->getAllGames();

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
