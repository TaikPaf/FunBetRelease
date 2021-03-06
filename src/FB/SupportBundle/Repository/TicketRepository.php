<?php

namespace FB\SupportBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FB\MemberBundle\Entity\User;

/**
 * ticketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    public function findUserTicket(User $user){
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.user = :user')
            ->orderBy('t.id', 'DESC')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }
}
