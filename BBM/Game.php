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
     * @Id
     * @column(type="string", length="8")
     * @var string
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
     * @xOneToMany(targetEntity="BBM\Statistics\PitcherStats", mappedBy="game")
     * @var BBM\Statistics\PitcherStats
     */
    private $pitcherStats;

    /**
     * The ballpark/site of the game
     * @todo
     */
    private $ballpark;

    /**
     * Was a designated hitter allowed
     */
    private $usedh;

    /**
     * Temperature
     *
     */
    private $temperature;

    /**
     * Attendance
     */
    private $attendance;

    public function xx__construct($id)
    {
        $this->game_id = $id;
    }

    public function setId($id)
    {
        $this->game_id = $id;
    }

    /**
     * Create a Game object
     * @param Team $homeTeam
     * @param Team $awayTeam
     * @param DateTime $gameStart
     * @return void
     */
    public function x__construct(Team $homeTeam, Team $awayTeam, \DateTime $gameStart)
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
        $this->gameStart = $time;
    }

    public function isDivisionGame()
    {
        return ($homeTeam->getDivision() == $awayTeam->getDivision());
    }

    public function setGameEnd(\DateTime $time)
    {
        $this->gameEnd = $time;
    }

    public function setBallpark($todo)
    {
        //TODO
    }

    public function setUseDH($value)
    {
        //TODO
    }

    public function setAttendance($value)
    {
        //TODO
    }

    public function setTemprature($value)
    {
        //TODO
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
