<?php

namespace BBM;

use BBM\Umpire;

class UmpireRepository extends RepositoryAbstract
{
    /**
     * Find an umpire by its id
     *
     * @param string $umpire_id
     * @return BBM\Umpire
     */
    public function findUmpireById($id)
    {
        $query = $this->em->createQuery('SELECT u FROM BBM\Umpire u WHERE u.umpire_id = ?1');
        $query->setParameter(1,$id);

        return $query->getSingleResult();
    }
}
