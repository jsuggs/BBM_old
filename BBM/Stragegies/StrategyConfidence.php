<?php

/**
 * StragecyConfidence
 * @ValueObject
 */
class StrategyConfidence
{
    /**
     * @var StrategyAbstract
     */
    private $strategy;

    /**
     * @var float
     */
    private $confidence;

    public function __construct(Strategy $strategy, $confidence)
    {
        $this->strategy = $strategy;
        $this->confidence = (float)$value;
    }

    public function getConfidence()
    {
        return $this->confidence;
    }

    public function setConfidence($value)
    {
        $this->confidence = (float)$value;
    }

    public function getStrategy()
    {
        return $this->strategy;
    }

    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
}
