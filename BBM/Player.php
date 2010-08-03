<?php

namespace BBM;

class Player
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var int */
    private $jerseyNumber;

    /** @var string */
    private $bats;

    /** @var string */
    private $throws;

    /** @var Date */
    private $daateOfBirth;

    public function __construct($firstName,$lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
