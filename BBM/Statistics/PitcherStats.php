<?php

namespace BBM\Statistics;

use BBM\Game,
    BBM\Pitcher;

/**
 * @Entity
 * @Table(name="pitcher_stats")
 */
class PitcherStats
{
    /**
     * @Id 
     * @Column(type="integer") 
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="pitcher_stat_seq", initialValue=1)
     */
    private $statistic_id;

    /**
     * @ManyToOne(targetEntity="BBM\Game", inversedBy="pitcherStats")
     * @JoinColumn(name="game_id", referencedColumnName="game_id")
     * @var BBM\Game
     */
    private $game;

    /**
     * @ManyToOne(targetEntity="BBM\Pitcher", inversedBy="pitcherStats")
     * @JoinColumn(name="pitcher_id", referencedColumnName="pitcher_id")
     * @var BBM\Pitcher
     */
    private $pitcher;

    /**
     * @column(type="integer")
     */
    private $earned_runs;

    /**
     * @column(type="integer")
     */
    private $walks;

    /**
     * @column(type="integer")
     */
    private $hits;

    /**
     * @column(type="decimal")
     */
    private $innings_pitched;

    /**
     * @column(type="integer")
     */
    private $pitches;
}
