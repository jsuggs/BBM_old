<?php

namespace BBM\Strategies;

use  BBM\Strategies\OverUnderStrategyAbstract;

/**
 * Simple Stragegy that returns whether the market cap is increasing
 *
 */
class RecentGameStrategy extends OverUnderStrategyAbstract
{
    public function StrategyName()
    {
        return 'RecentGame';
    }

    /**
     * If the two teams have both played recently
     * Then reduce the likelyhood that they will hit the over
     *
     * @see StrategyAbstract::applyStrategy()
     */
    public function applyStrategy()
    {
        // Find all the most recent game played between the two teams
        $lastGame = FindLastGamePlayed(
            $this->game->homeTeam,
            $this->game->awayTeam
        );

        if (!isset($lastGame) || dateDiff($lastGame,$this->game) > '24 hours') {
            return new Exception('No recent game between the two teams');
        }

        // There was a recent game, so return true
        return 1; 
    }
}
