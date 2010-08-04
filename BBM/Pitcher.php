<?php

namespace BBM;

use BBM\Player,
    BBM\Statistics\PitcherStats;

/**
 * @Entity
 * @Table(name="pitchers")
 */
class Pitcher extends Player
{
    /**
     * @Id
     * @Column(type="integer")
     */
    private $pitcher_id;

    /**
     * @OneToMany(targetEntity="BBM\Statistics\PitcherStats", mappedBy="pitcher")
     */
    private $pitcherStats;

    public function getERA()
    {
        // Compute
        return 1.5;
    }

    public function getTotalWalks()
    {
        return 20;
    }

    public function getTotalHits()
    {
        return 5;
    }

    public function getTotalInningsPitched()
    {
        return 40;
    }

    public function getWHIP()
    {
        // Walks + Hits / Innings Pitched
        $totalWalks = $this->getTotalWalks();
        $totalHits = $this->getTotalHits();
        $totalInningsPitched = $this->getTotalInningsPitched();

        return (($totalWalks + $totalHits) / $totalInningsPitched);
    }

    public function getWHIPforPreviousGames($numberOfGames)
    {
        // Get games
        // Do computation
    }
}
