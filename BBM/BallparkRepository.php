<?php

namespace BBM;

use BBM\Ballpark;

class BallparkRepository extends RepositoryAbstract
{
    /**
     * Find a ballpark by its id
     *
     * @param string $ballpark_id
     * @return BBM\Ballpark
     */
    public function findBallparkById($id)
    {
        $query = $this->em->createQuery('SELECT b from BBM\Ballpark b where b.ballpark_id = ?1');
        $query->setParameter(1,$id);

        return $query->getSingleResult();
    }
}
