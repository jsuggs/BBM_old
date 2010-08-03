<?php

namespace BBM;

class BettingPlanService
{
    /** @var Game */
    private $games;

    /** @var StrategyAbstract */
    private $strategies;

    public function __construct($games,$strategies)
    {
        $this->games = $games;
        $this->strategies = $strategies;
    }

    public function __toString()
    {
        return 'ttt';
    }
}
