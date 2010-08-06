<?php

namespace BBM;

use BBM\Player;

class PlayerRepository extends RepositoryAbstract
{
    /**
     * Find an player by its id
     *
     * @param string $player_id
     * @return BBM\Player
     */
    public function findPlayerById($id)
    {
        $query = $this->em->createQuery('SELECT p FROM BBM\Player p WHERE p.player_id = ?1');
        $query->setParameter(1,$id);

        return $query->getSingleResult();
    }
}
