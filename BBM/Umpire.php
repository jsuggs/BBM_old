<?php

namespace BBM;

/**
 * Umpire
 *
 * @Entity
 * @Table(name="umpires") 
 */
class Umpire
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
