<?php

namespace BBM;

use BBM\Game;
use BBM\StartingLineup;

/**
 * A Model for a baseball team
 *
 * @Entity
 * @Table(name="teams")
 */
class Team
{
    /** 
     * The team abbreviation
     *
     * @Id
     * @column(type="string",length="3")
     * @var string 
     */
    private $abbr;

    /** 
     * @column(type="string")
     * @var string 
     */
    private $teamName;

    /**
     * @column(type="string",length="2")
     * @var string
     */
    private $league;

    /** 
     * @column(type="string",length="1")
     * @var string 
     */
    private $division;

    /**
     * @column(type="string")
     * @var string
     */
    private $city;

    /**
     * @column(type="string", length="2")
     * @var string
     */
    private $state;

    /**
     * @column(type="string", length="5")
     * @var string
     */
    private $zip;

    /** @var Game */
    private $games;

    /** @var StartingLineup */
    private $startingLineup;

    public function __construct($abbr,$teamName,$league,$division)
    {
        $this->setAbbr($abbr);
        $this->setTeamName($teamName);
        $this->setLeague($league);
        $this->setDivision($division);
    }

    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set the division
     * Must by E|W|C
     *
     * @param string $division
     * @return void
     */
    public function setDivision($division)
    {
        if (!($division === 'E' || $division === 'W' || $division === 'C'))
        {
            throw new \Exception('Invalid Division');
        }

        $this->division = $division;
    }

    /**
     * Set the league
     * Must be AL or NL
     *
     * @param string $league
     * @return void
     */
    public function setLeague($league)
    {
        if (!($league === 'AL' || $league === 'NL'))
        {
            throw new \Exception('Invalid League');
        }

        $this->league = $league;
    }

    public function setAbbr($abbr)
    {
        if (!is_string($abbr) || strlen($abbr) > 3)
        {
            throw new \Exception('Invalid Abbreviation');
        }

        $this->abbr = $abbr;
    }

    public function setAddress($city,$state,$zip)
    {
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;
    }

    public function __toString()
    {
        return $this->abbr . ' - ' . $this->teamName . ' (' . $this->league . '-' . $this->division . ') ' . $this->city . ',' . $this->state . ' ' . $this->zip;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function addGame(Game $game)
    {
        $this->games[] = $game;
    }

    public function setStartingLineup(StartingLineup $lineup)
    {
        $this->startingLineup = $lineup;
    }
}
