<?php

namespace BBM;

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
    }

    public function setName($firstName,$lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
