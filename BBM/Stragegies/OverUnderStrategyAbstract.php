<?php

namespace BBM\Strategies;

use BBM\Strategies\AbstractStrategy;

class OverUnderStrategyAbstract extends StrategyAbstract
{
    /** @var int */
    private $line;

    public function __construct(Game $game, $line)
    {
        $this->game = $game;
        $this->line = $line;
    }
}
