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

    /**
     * Get all of the players
     * @return BBM\Player
     */
    public function getAllPlayers($limit = 0)
    {
        $query = $this->em->createQuery('SELECT p from BBM\Player p');
        return $query->execute();
    }

    public function getAllPitchers()
    {
        $query = $this->em->createQuery('SELECT p from BBM\Player p WHERE EXISTS(SELECT m.pitching_matchup_id FROM BBM\PitchingMatchup m WHERE m.pitcher = p.player_id)');
        return $query->execute();
    }
}
