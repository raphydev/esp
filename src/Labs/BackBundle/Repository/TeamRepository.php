<?php

namespace Labs\BackBundle\Repository;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOne($entity)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where($qb->expr()->eq('t.id', ':id'));
        $qb->setParameter(':id', $entity);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findLimit($num = 7)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->setMaxResults($num);
        return $qb->getQuery()->getResult();
    }

    public function findAllName()
    {
        $qb = $this->createQueryBuilder('t');
        $qb->orderBy('t.position', 'ASC');
        return $qb->getQuery()->getResult();
    }

}
