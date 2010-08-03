<?php

namespace BBM\Strategies;

use BBM\Game;

abstract class StrategyAbstract
{
    /**
     * The Game the strategy is applied to
     * @var Game
     */
    private $game;

    /**
     * Return the Strategy Name
     * @return string
     */
    abstract function StrategyName();

    /**
     * Apply the strategy
     *
     * Implement the algorithm and return a float between -1 and 1
     * corresponding to the confidence of the algorithm to be successful
     * Boolean algorithms will return -1 or 1
     *
     * @return float
     */
    abstract function applyStrategy();

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * If there is another game
     * @todo
     */
    public function hasGameResult()
    {
        return false;
    }

    public function strategyWorked()
    {
        if (!$this->hasGameResult())
        {
            throw new Exception('Game result not available');
        }

        return 
        (
            $this->company->getStockPrice($this->period) 
            ($this->applyStrategy() > 0) ? > : < 
            $this->company->getStockPrice($this->company->getNextPeriod($this->period))
        ) ? true : false
    }
}
