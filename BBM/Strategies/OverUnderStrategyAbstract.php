<?php

namespace BBM\Strategies;

use BBM\Strategies\StrategyAbstract;

abstract class OverUnderStrategyAbstract extends StrategyAbstract
{
    /** @var int */
    private $line;

    public function setArgs(Game $game, $line)
    {
        $this->game = $game;
        $this->line = $line;
    }
}
