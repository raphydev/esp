<?php

namespace Labs\BackBundle\Repository;


/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllPost()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.created', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function getOneArticles($id, $slug)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where(
            $qb->expr()->eq('p.id', ':id'),
            $qb->expr()->eq('p.slug', ':slug')
        );
        $qb->setParameter(':id', $id);
        $qb->setParameter(':slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAllArticles()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.created', 'DESC');
        $qb->setMaxResults(6);
        return $qb->getQuery()->getResult();
    }
}