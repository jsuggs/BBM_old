<?php

namespace BBM\Strategies;

use BBM\Strategies\OverUnderStrategyAbstract;

/**
 * Simple Stragegy that returns whether the market cap is increasing
 *
 */
class Team5GameAverageRunsStrategy extends OverUnderStrategyAbstract
{
    public function StrategyName()
    {
        return 'PreviousMatchups';
    }

    /**
     * See if the last 5 game run average is greater
     * than the current line
     *
     * @see StrategyAbstract::applyStrategy()
     */
    public function applyStrategy()
    {
        // Find all of the games where the two staring picthers have faced each other
        $homeTeamGames = FindPreviousGames($this->game->homeTeam,5);
        $awayTeamGames = FindPreviousGames($this->game->awayTeam,5);

        if (sizeof($homeTeamGames) < 5 || sizeof($awayTeamGames) < 5) {
            return new Exception('Both teams don\'t have 5 previous games');
        }

        $totalScore = 0;
        foreach ($homeTeamGames as $game)
        {
            $totalScore += $game->getResult()->getTotalScore();
        }

        foreach ($awayTeamGames as $game)
        {
            $totalScore += $game->getResult()->getTotalScore();
        }

        $avgScore = $totalScore / 10;

        return ($avgScore <= $this->line) ? 1 : -1;
    }
}
