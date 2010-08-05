<?php

namespace BBM;

class FactoryAbstract
{
    /**
     * Doctrine EntityManager
     * @var EntityManager
     */
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }
}
