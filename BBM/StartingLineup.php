<?php

namespace BBM;

class StartingLineup
{
    /** @var Pitcher */
    private $startingPitcher;

    /**
     * Set the Starting Pitcher
     * @return Pitcher
     */
    public function getStartingPitcher()
    {
        return $this->startingPitcher;
    }

    /**
     * Set the starting pitcher
     * @param Pitcher
     */
    public function setStartingPitcher(Pitcher $pitcher)
    {
        $this->startingPitcher = $pitcher;
    }
}
