<?php

namespace BBM;

class RepositoryAbstract
{
    /**
     * Doctrine EntityManager
     */
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }
}
