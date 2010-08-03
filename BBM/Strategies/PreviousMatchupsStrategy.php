<?php

namespace BBM\Strategies;

use BBM\Strategies\OverUnderStrategyAbstract;

/**
 * Simple Stragegy that returns whether the market cap is increasing
 *
 */
class PrevoiusMatchupsStrategy extends OverUnderStrategyAbstract
{
    public function StrategyName()
    {
        return 'PreviousMatchups';
    }

    /**
     * If the two starting pitchers have faced each other
     * then see if their prevoius matchups are above or
     * the current line for the game
     *
     * @see StrategyAbstract::applyStrategy()
     */
    public function applyStrategy()
    {
        // Find all of the games where the two staring picthers have faced each other
        $games = FindGamesWithStartingPitchers(
            $this->game->homeTeam->roster->getStartingPitcher(),
            $this->game->awayTeam->rowser->getStartingPitcher()
        );

        if (sizeof($games) == 0) {
            return new Exception('No previous games between starting pitchers');
        }

        $totalScore = 0;
        $numGames = 0;
        foreach ($games as $game)
        {
            $totalScore += $game->getResult()->getTotalScore();
            $numGames++;
        }

        $avgScore = $totalScore / $numGames;

        return ($avgScore <= $this->line) ? 1 : -1;
    }
}
