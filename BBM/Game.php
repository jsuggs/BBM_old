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
     * @SequenceGenerator(name="game_seq")
     * @var integer
     */
    private $game_id;

    /** @var Team */
    private $homeTeam;

    /** @var Team */
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
