<?php

namespace FB\StatsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * JackpotRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JackpotRepository extends EntityRepository
{
    public function getLastWinner(){
        $qb = $this->createQueryBuilder('j');
        $qb->orderBy('j.id', 'DESC')
        ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }
}