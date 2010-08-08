<?php

namespace BBM;

use BBM\Game;

class GameRepository extends RepositoryAbstract
{
    /**
     * Find an game by its id
     *
     * @param string $game_id
     * @return BBM\Game
     */
    public function findGameById($id)
    {
        $query = $this->em->createQuery('SELECT g FROM BBM\Game g WHERE g.game_id = ?1');
        $query->setParameter(1,$id);

        return $query->getSingleResult();
    }

    public function getAllGames($limit = 0)
    {
        $query = $this->em->createQuery('SELECT g from BBM\Game g');
        if ($limit > 0) {
            $query->setMaxResults($limit);
        }
        return $query->getResult();
    }
}
