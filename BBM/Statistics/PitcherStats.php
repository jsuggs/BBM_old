<?php

namespace BBM\Statistics;

use BBM\Game,
    BBM\Pitcher;

/**
 * @xEntity
 * @xTable(name="pitcher_stats")
 */
class PitcherStats
{
    /**
     * @xId 
     * @xColumn(type="integer") 
     * @xGeneratedValue(strategy="SEQUENCE")
     * @xSequenceGenerator(sequenceName="pitcher_stat_seq", initialValue=1)
     */
    private $statistic_id;

    /**
     * @xManyToOne(targetEntity="BBM\Game", inversedBy="pitcherStats")
     * @xJoinColumn(name="game_id", referencedColumnName="game_id")
     * @var BBM\Game
     */
    private $game;

    /**
     * @xManyToOne(targetEntity="BBM\Pitcher", inversedBy="pitcherStats")
     * @xJoinColumn(name="pitcher_id", referencedColumnName="pitcher_id")
     * @var BBM\Pitcher
     */
    private $pitcher;

    /**
     * @xcolumn(type="integer")
     */
    private $earned_runs;

    /**
     * @xcolumn(type="integer")
     */
    private $walks;

    /**
     * @xcolumn(type="integer")
     */
    private $hits;

    /**
     * @xcolumn(type="decimal")
     */
    private $innings_pitched;

    /**
     * @xcolumn(type="integer")
     */
    private $pitches;
}
