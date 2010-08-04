<?php

namespace BBM;

use BBM\Team,
    BBM\Statitistics\PitcherStats,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * A baseball game
 *
 * @Entity
 * @Table(name="games")
 */
class Game
{
    /** 
     * The identity column for a specific game
     *
     * @column(type="integer")
     * @Id
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="game_seq", initialValue=1)
     * @var integer
     */
    private $game_id;

    /** 
     * The home team for the game
     *
     * @OneToOne(targetEntity="BBM\Team")
     * @JoinColumn(name="homeTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $homeTeam;


    /** 
     * The away team for the game
     *
     * @OneToOne(targetEntity="BBM\Team")
     * @JoinColumn(name="awayTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $awayTeam;

    /** 
     * The start of the gmame
     * @column(type="datetime")
     * @var DateTime 
     */
    private $gameStart;

    /** 
     * The end of the gmame
     * @column(type="datetime")
     * @var DateTime 
     */
    private $gameEnd;

    /**
     * The pitching stats for this game
     * 
     * @OneToMany(targetEntity="BBM\Statistics\PitcherStats", mappedBy="game")
     * @var BBM\Statistics\PitcherStats
     */
    private $pitcherStats;

    /**
     * Create a Game object
     * @param Team $homeTeam
     * @param Team $awayTeam
     * @param DateTime $gameStart
     * @return void
     */
    public function __construct(Team $homeTeam, Team $awayTeam, \DateTime $gameStart)
    {
        $this->setHomeTeam($homeTeam);
        $this->setAwayTeam($awayTeam);
        $this->setGameStart($gameStart);

        // Initialize Colections
        $this->pitcherStats = new ArrayCollection();
    }

    public function setHomeTeam(Team $team)
    {
        $this->homeTeam = $team;
    }

    public function setAwayTeam(Team $team)
    {
        $this->awayTeam = $team;
    }

    public function setGameStart(\DateTime $time)
    {
        $this->gameTime = $time;
    }

    public function isDivisionGame()
    {
        return ($homeTeam->getDivision() == $awayTeam->getDivision());
    }

    public function setGameEnd(\DateTime $time)
    {
        $this->gameEnd = $time;
    }

    /**
     * Get the time the game took
     * @return DateInterval
     */
    public function getGameLength()
    {
        if (!(isset($this->gameStart) && isset($this->gameEnd))) {
            // The end time of the game is unknown
            return null;
        }

        return $this->gameStart->diff($this->gameEnd);
    }
}
