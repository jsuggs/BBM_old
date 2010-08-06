<?php

namespace BBM;

use \Doctrine\Common\Collections\ArrayCollection;

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
    private $umpire_id;

    /**
     * @column(type="string", length="")
     */
    private $firstName;

    /**
     * @column(type="string", length="")
     */
    private $lastName;

    /**
     * @OneToMany(targetEntity="Game", mappedBy="homePlateUmpire")
     */
    private $homeplateGames;

    /**
     * @OneToMany(targetEntity="Game", mappedBy="firstBaseUmpire")
     */
    private $firstBaseGames;

    /**
     * @OneToMany(targetEntity="Game", mappedBy="secondBaseUmpire")
     */
    private $secondBaseGames;

    /**
     * @OneToMany(targetEntity="Game", mappedBy="thirdBaseUmpire")
     */
    private $thirdBaseGames;

    public function __construct($player_id)
    {
        $this->umpire_id = $player_id;
    }

    public function setName($firstName,$lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        // Initialize Collections
        $this->homePlateGames = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
