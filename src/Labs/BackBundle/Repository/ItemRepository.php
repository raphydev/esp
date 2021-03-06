<?php

namespace Labs\BackBundle\Repository;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOne($entity)
    {
        $qb = $this->createQueryBuilder('it');
        $qb->where($qb->expr()->eq('it.id', ':id'));
        $qb->setParameter(':id', $entity);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
