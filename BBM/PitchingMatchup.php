<?php

namespace BBM;

use BBM\Player,
    BBM\Game;

/**
 * A pitching matchup and its outcome
 *
 * @Entity
 * @Table(name="pitching_matchups")
 */
class PitchingMatchup
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="pitching_matchup_seq", initialValue=1)
     * @var integer
     */
    private $pitching_matchup_id;

    /**
     * The pitcher
     * @ManyToOne(targetEntity="Player", inversedBy="pitchingMatchupsAsPitcher")
     * @JoinColumn(name="pitcher_id", referencedColumnName="player_id")
     */
    private $pitcher;

    /**
     * The batter
     * @ManyToOne(targetEntity="Player", inversedBy="pitchingMatchupsAsBatter")
     * @JoinColumn(name="batter_id", referencedColumnName="player_id")
     */
    private $batter;

    /**
     * The game this matchup occurred
     * @ManyToOne(targetEntity="Game", inversedBy="pitchingMatchups")
     * @JoinColumn(name="game_id", referencedColumnName="game_id")
     */
    private $game;

    /**
     * The outcome of the matchup
     * @column(type="string", length="10")
     * @var string
     */
    private $outcome;

    public function __toString()
    {
        return $this->game . ' ' . $this->pitcher . ' vs ' . $this->batter . ' = ' . $this->outcome;
    }

    public function setPitcher(Player $pitcher)
    {
        $this->pitcher = $pitcher;
    }

    public function setBatter(Player $batter)
    {
        $this->batter = $batter;
    }

    public function setGame(Game $game)
    {
        $this->game = $game;
    }

    public function setOutcome($value)
    {
        $this->outcome = $value;
    }
}
