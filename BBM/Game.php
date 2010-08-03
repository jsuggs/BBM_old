<?php

namespace BBM;

use BBM\Team;

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
     * @OneToOne(targetEntity="Team")
     * @JoinColumn(name="homeTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $homeTeam;


    /** 
     * The away team for the game
     *
     * @OneToOne(targetEntity="Team")
     * @JoinColumn(name="awayTeam",referencedColumnName="abbr")
     * @var Team 
     */
    private $awayTeam;

    /** @var DateTime */
    private $gameTime;

    public function __construct(Team $homeTeam, Team $awayTeam, \DateTime $gameTime)
    {
        $this->setHomeTeam($homeTeam);
        $this->setAwayTeam($awayTeam);
        $this->setGameTime($gameTime);
    }

    public function setHomeTeam(Team $team)
    {
        $this->homeTeam = $team;
    }

    public function setAwayTeam(Team $team)
    {
        $this->awayTeam = $team;
    }

    public function setGameTime(\DateTime $time)
    {
        $this->gameTime = $time;
    }

    public function isDivisionGame()
    {
        return ($homeTeam->getDivision() == $awayTeam->getDivision());
    }
}
