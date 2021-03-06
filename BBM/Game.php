<?php

namespace BBM;

use BBM\Team,
    BBM\Ballpark,
    BBM\Play,
    BBM\StartingLineup,
    BBM\PitchingMatchup,
    BBM\Statitistics\PitcherStats,
    Zend\View\Helper\Url,
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
     * @column(type="string", length="12")
     * @var string
     */
    private $game_id;

    /** 
     * The home team for the game
     *
     * @ManyToOne(targetEntity="BBM\Team", inversedBy="homeGames")
     * @JoinColumn(name="homeTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $homeTeam;

    /**
     * The home teams's starting lineup
     *
     * @oneToOne(targetEntity="BBM\StartingLineup", cascade={"persist", "remove"}, orphanRemoval=true)
     * @JoinColumn(name="homeStartingLineup", referencedColumnName="startinglineup_id")
     */
    private $homeStartingLineup;

    /** 
     * The away team for the game
     *
     * @ManyToOne(targetEntity="BBM\Team", inversedBy="awayGames")
     * @JoinColumn(name="awayTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $awayTeam;

    /**
     * The away teams's starting lineup
     *
     * @oneToOne(targetEntity="BBM\StartingLineup", cascade={"persist", "remove"}, orphanRemoval=true)
     * @JoinColumn(name="awayStartingLineup", referencedColumnName="startinglineup_id")
     */
    private $awayStartingLineup;

    /** 
     * The start of the gmame
     * @column(type="datetime")
     * @var DateTime 
     */
    private $gameStart;

    /** 
     * The end of the gmame
     * @column(type="datetime", nullable="true")
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
     * @ManyToOne(targetEntity="Ballpark", inversedBy="games")
     * @JoinColumn(name="ballpark_id",referencedColumnName="ballpark_id")
     */
    private $ballpark;

    /**
     * @OneToMany(targetEntity="Play", mappedBy="game", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var BBM\Play
     */
    private $plays;

    /**
     * All of the pitching matchups that occurred during this game
     *
     * @OneToMany(targetEntity="PitchingMatchup", mappedBy="game", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pitchingMatchups;

    /**
     * The home plate umpire
     * @ManyToOne(targetEntity="Umpire", inversedBy="homeplateGames")
     * @JoinColumn(name="homePlateUmpire",referencedColumnName="umpire_id")
     */
    private $homePlateUmpire;

    /**
     * The 1B umpire
     * @ManyToOne(targetEntity="Umpire", inversedBy="firstBaseGames")
     * @JoinColumn(name="firstBaseUmpire",referencedColumnName="umpire_id")
     */
    private $firstBaseUmpire;

    /**
     * The 2B umpire
     * @ManyToOne(targetEntity="Umpire", inversedBy="secondBaseGames")
     * @JoinColumn(name="secondBaseUmpire",referencedColumnName="umpire_id")
     */
    private $secondBaseUmpire;

    /**
     * The 3B umpire
     * @ManyToOne(targetEntity="Umpire", inversedBy="thirdBaseGames")
     * @JoinColumn(name="thirdBaseUmpire",referencedColumnName="umpire_id")
     */
    private $thirdBaseUmpire;

    /**
     * Was a designated hitter allowed
     */
    private $usedh;

    /**
     * Temperature
     * @column(type="decimal", nullable="true")
     */
    private $temperature;

    /**
     * Attendance
     * @column(type="integer", nullable="true")
     */
    private $attendance;

    /**
     * Wind direction
     * @column(type="string", nullable="true")
     */
    private $winddir;

    /**
     * Wind speed
     * @column(type="integer", nullable="true")
     */
    private $windspeed;

    public function __construct()
    {
        $this->plays = new ArrayCollection();
        $this->pitchingMatchups = new ArrayCollection();
        $this->pitcherStats = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->game_id = $id;
    }

    public function getId()
    {
        return $this->game_id;
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
        $this->pitchingMatchups = new ArrayCollection();
        $this->pitcherStats = new ArrayCollection();
    }

    public function setHomeTeam(Team $team)
    {
        $this->homeTeam = $team;
    }

    public function setHomeStartingLineup(StartingLineup $lineup)
    {
        $this->homeStartingLineup = $lineup;
    }

    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    public function setAwayTeam(Team $team)
    {
        $this->awayTeam = $team;
    }

    public function setAwayStartingLineup(StartingLineup $lineup)
    {
        $this->awayStartingLineup = $lineup;
    }

    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    public function addPitchingMatchup(PitchingMatchup $matchup)
    {
        $this->pitchingMatchups[] = $matchup;
    }

    public function getPitchingMatchups()
    {
        return $this->pitchingMatchups;
    }

    public function setGameStart(\DateTime $time)
    {
        $this->gameStart = $time;
    }

    public function addPlay(Play $play)
    {
        $this->plays[] = $play;
        $play->setGame($this);
    }

    public function getPlays()
    {
        return $this->plays;
    }

    public function isDivisionGame()
    {
        return ($homeTeam->getDivision() == $awayTeam->getDivision());
    }

    public function setGameEnd(\DateTime $time)
    {
        $this->gameEnd = $time;
    }

    public function setBallpark(Ballpark $ballpark)
    {
        $this->ballpark = $ballpark;
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

    public function setHomePlateUmpire(Umpire $umpire)
    {
        $this->homePlateUmpire = $umpire;
    }

    public function setFirstBaseUmpire(Umpire $umpire)
    {
        $this->firstBaseUmpire = $umpire;
    }

    public function setSecondBaseUmpire(Umpire $umpire)
    {
        $this->secondBaseUmpire = $umpire;
    }

    public function setThirdBaseUmpire(Umpire $umpire)
    {
        $this->thirdBaseUmpire = $umpire;
    }

    public function setTemperature($value)
    {
        $this->temperature = $value;
    }

    public function setWindDir($value)
    {
        $this->winddir = $value;
    }

    public function setWindSpeed($value)
    {
        $this->windspeed = $value;
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

    public function getViewUrl()
    {
        return Url::direct(
            array(
                'game_id' => $this->game_id,
                'game_name' => $this->homeTeam . 'vs' . $this->awayTeam
            ),
            'game-view'
        );
    }

    public function __toString()
    {
        return $this->game_id;// . ' : ' . $this->homeTeam . ' vs ' . $this->awayTeam;
    }
}
