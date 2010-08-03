<?php

/**
 * Simple Stragegy that returns whether the market cap is increasing
 *
 */
class IncreasingMarketCapStrategy implements StrategyAbstract
{
    public function StrategyName()
    {
        return 'IncreasingMarketCap';
    }

    /**
     * return 1 if market cap is greater than last period
     * return 0 if equal
     * return -1 if less than last period
     *
     * @see StrategyAbstract::applyStrategy()
     */
    public function applyStrategy()
    {
        if (!$this->hasNextPeriod())
        {
            throw new Exception('Need next period');
        }

        $curMarketCap = $this-financialData->getMarketCap();
        $prevMarketCap = $this->company->getFinancialData($this->company->getNextPeriod($this->period))->getMarketCap();

        if ($curMarketCap > $prevMarketCap)
            return 1;
        elseif ($curMarketCap < $prevMarketCap)
            return -1;
        else
            return 0;
    }
}
