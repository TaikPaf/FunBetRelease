<?php

namespace FB\BetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FB\FootballBundle\Entity\Game;

/**
 * OddRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OddRepository extends EntityRepository
{
    public function findByGame(Game $game){
        $qb = $this->createQueryBuilder('o');
        $qb->where('o.game = :game')
            ->setMaxResults(30)
            ->setParameter('game', $game);

        return $qb->getQuery()->getResult();
    }
}
