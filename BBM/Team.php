<?php

namespace BBM;

use BBM\Game;
use BBM\StartingLineup;

/**
 * A Model for a baseball team
 */
class Team
{
    /** @var string */
    private $teamName;

    /** @var string */
    private $abbr;

    /** @var string */
    private $division;

    /** @var Game */
    private $games;

    /** @var StartingLineup */
    private $startingLineup;

    public function __construct($abbr,$teamName,$division)
    {
        $this->setAbbr($abbr);
        $this->setTeamName($teamName);
        $this->setDivision($division);
    }

    public function getDivision()
    {
        return $this->division;
    }

    public function setDivision($division)
    {
        if (!($division === 'NL' || $division === 'AL'))
        {
            throw new \Exception('Invalid Division');
        }

        $this->division = $division;
    }

    public function setAbbr($abbr)
    {
        if (!is_string($abbr) || strlen($abbr) > 4)
        {
            throw new \Exception('Invalid Abbreviation');
        }

        $this->abbr = $abbr;
    }

    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;
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
