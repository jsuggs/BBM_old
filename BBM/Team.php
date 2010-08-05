<?php

namespace BBM;

use BBM\Game,
    BBM\Roster,
    BBM\StartingLineup;

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
     * @column(type="string", length="3")
     * @var string 
     */
    private $abbr;

    /** 
     * @column(type="string")
     * @var string 
     */
    private $nickname;

    /**
     * @column(type="string", length="2")
     * @var string
     */
    private $league;

    /** 
     * @column(type="string", length="1", nullable="true")
     * @var string 
     */
    private $division;

    /**
     * @column(type="string", nullable="true")
     * @var string
     */
    private $city;

    /**
     * @column(type="string", length="2", nullable="true")
     * @var string
     */
    private $state;

    /**
     * @column(type="string", length="5", nullable="true")
     * @var string
     */
    private $zip;

    /** @var Game */
    private $games;

    /** @var StartingLineup */
    private $startingLineup;

    public function __construct($abbr)
    {
        $this->setAbbr($abbr);
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
     *
     * @param string $league
     * @return void
     */
    public function setLeague($league)
    {
        /*if (!($league === 'AL' || $league === 'NL' || $league === 'NA' || $league === 'AA'))
        {
            throw new \Exception('Invalid League');
        }*/

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

    public function setNickname($value)
    {
        $this->nickname = $value;
    }

    public function setAddress($city,$state,$zip)
    {
        $this->setCity($city);
        $this->state = $state;
        $this->zip = $zip;
    }

    public function setCity($value)
    {
        $this->city = $value;
    }

    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;
    }

    public function __toString()
    {
        return $this->abbr . ' - ' . $this->nickname;
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
