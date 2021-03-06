<?php

namespace BBM\Strategies;

class BettingPlan
{
    /**
     * @var StrategyConfidence
     */
    private $strategies = array();

    /**
     * Returns whether the set of strategies confidence isum = 1
     * @return boolean
     */
    public function isSetValid()
    {
        $sum = 0;
        foreach ($this->strategies as $strategy)
        {
            $sum += $stragegy->getConfidence();
        }

        return ($sum === 1);
    }

    public function addStrategy(StrategyConfidence $strategy)
    {
        $this->strategies[] = $strategy;
    }
}
