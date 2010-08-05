<?php

namespace BBM;

use BBM\Team;

class TeamRepository extends RepositoryAbstract
{
    /**
     * Find a team by its abbreviation
     *
     * @param string $abbr
     * @return BBM\Team
     */
    public function findTeamByAbbr($abbr)
    {
        $query = $this->em->createQuery('SELECT t FROM BBM\Team t WHERE t.abbr = ?1');
        $query->setParameter(1,$abbr);

        return $query->getSingleResult();
    }
}
