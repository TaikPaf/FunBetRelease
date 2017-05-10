<?php

namespace FB\StatsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DayStatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DayStatRepository extends EntityRepository
{

    public function findNbUser(){
        return $this->createQueryBuilder('d')
            ->select('SUM(d.nbUser)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findNbBet(){
        return $this->createQueryBuilder('d')
            ->select('SUM(d.nbBet)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findNbAmount(){
        return $this->createQueryBuilder('d')
            ->select('SUM(d.nbAmountBet)')
            ->getQuery()
            ->getSingleScalarResult();
    }


}
