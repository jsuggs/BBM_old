<?php

namespace BBM;

use BBM\PitchingMatchup,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * A Player
 *
 * @Entity
 * @Table(name="players")
 */
class Player
{
    /** 
     * @Id 
     * @column(type="string", length="8")
     * @var string 
     */
    private $player_id;

    /**
     * @column(type="string", length="")
     */
    private $firstName;

    /**
     * @column(type="string", length="")
     */
    private $lastName;

    /**
     * All of the pitching matchups this player has been a pitcher for
     * If this player has been a pitcher, then this is a set of all of the
     * pitching matchups
     *
     * @OneToMany(targetEntity="PitchingMatchup", mappedBy="pitcher", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pitchingMatchupsAsPitcher;

    /**
     * All of the pitching matchups this player has been the batter for
     * If this player has been a batter, then this is a set of all of the
     * pitching matchups
     *
     * @OneToMany(targetEntity="PitchingMatchup", mappedBy="batter", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $pitchingMatchupsAsBatter;

    /**
     * All of the plays this player has been involved with as a batter
     *
     * @oneToMany(targetEntity="Play", mappedBy="batter")
     */
    private $battingPlays;

    /**
     * All of the plays this player has been involved with as a pitcher
     *
     * @OneToMany(targetEntity="Play", mappedBy="pitcher")
     */
    private $pitchingPlays;

    /**
     * @column(type="string", length="1", nullable="true")
     */
    private $throwingHand;

    /**
     * @column(type="string", length="1", nullable="true")
     */
    private $battingHand;

    /** 
     * Date of Birth
     * @column (type="date", nullable="true")
     * @var Date 
     */
    private $daateOfBirth;

    public function __construct($player_id)
    {
        $this->player_id = $player_id;
        $this->battingPlays = new ArrayCollection();
        $this->pitchingPlays = new ArrayCollection();
        $this->pitchingMatchupsAsPitcher = new ArrayCollection();
        $this->pitchingMatchupsAsBatter = new ArrayCollection();
    }

    public function getPlayerId()
    {
        return $this->player_id;
    }

    public function setName($firstName,$lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function addBattingMatchup(PitchingMatchup $matchup)
    {
        $this->pitchingMatchupsAsBatter[] = $matchup;
    }

    public function addPitchingMatchup(PitchingMatchup $matchup)
    {
        $this->pitchingMatchupsAsPitcher[] = $matchup;
    }

    public function getPitchingMatchupsAsPitcher()
    {
        return $this->pitchingMatchupsAsPitcher;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
