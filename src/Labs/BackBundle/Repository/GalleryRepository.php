<?php

namespace Labs\BackBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Labs\BackBundle\Entity\Gallery;
use Labs\BackBundle\Entity\Users;

/**
 * DossierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Users $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDraftUser(Users $user)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where(
            $qb->expr()->eq('f.user', ':user'),
            $qb->expr()->eq('f.draft', -1)
        );
        $qb->setParameter('user', $user);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.draft <> -1');
        $qb->orderBy('f.created', 'Desc');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param Users $user
     * @param Gallery $gallery
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * Recupere le Gallery de l'utilisateur couramment connecté avec l'id passé en paramètre
     */
    public function getGalleryForUser(Users $user, Gallery $gallery)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->leftJoin('f.user', 'u');
        $qb->addSelect('u');
        $qb->where(
            $qb->expr()->eq('f.id', ':gallery'),
            $qb->expr()->eq('u.id', ':user')
        );
        $qb->setParameter('gallery', $gallery);
        $qb->setParameter('user', $user);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Gallery $gallery
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * Recupere le Gallery avec l'id passé en paramètre
     */
    public function getGallerys(Gallery $gallery)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where(
            $qb->expr()->eq('f.id', ':gallery')
        );
        $qb->setParameter('Gallery', $gallery);
        return $qb->getQuery()->getOneOrNullResult();
    }


    public function getGallerysArticles(Gallery $gallery, $user)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where(
            $qb->expr()->eq('p.id', ':gallery'),
            $qb->expr()->eq('p.user', ':user')
        );
        $qb->setParameter('gallery', $gallery);
        $qb->setParameter('user', $user);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $max
     * @return array
     */
    public function findGalleryNum($max = null)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->leftJoin('f.medias', 'm');
        $qb->addSelect('m');
        $qb->leftJoin('f.item', 'i');
        $qb->addSelect('i');
        $qb->where(
            $qb->expr()->eq('f.online', 1),
            $qb->expr()->eq('f.draft', 1),
            $qb->expr()->eq('m.actived', 1)
        );
        $qb->andWhere($qb->expr()->eq('m.actived', 1));
        $qb->orderBy('f.created', 'Desc');
        if(null !== $max){
            $qb->setMaxResults($max);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param Gallery $gallery
     * @param $slug
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDossierSlug(Gallery $gallery, $slug)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->leftJoin('d.medias','m');
        $qb->addSelect('m');
        $qb->leftJoin('d.item','i');
        $qb->addSelect('i');
        $qb->leftJoin('i.section','s');
        $qb->addSelect('s');
        $qb->where(
            $qb->expr()->eq('d.id', ':gallery'),
            $qb->expr()->eq('d.slug', ':slug'),
            $qb->expr()->eq('m.actived', 1),
            $qb->expr()->eq('d.draft', 1),
            $qb->expr()->eq('d.online', 1)
        );
        $qb->setParameter('gallery', $gallery);
        $qb->setParameter('slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $min
     * @param null $max
     * @return array
     */
    public function OldDossier($min ,$max)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->leftJoin('d.medias','m');
        $qb->addSelect('m');
        $qb->leftJoin('d.item','i');
        $qb->addSelect('i');
        $qb->where(
            $qb->expr()->neq('d.id', ':min'),
            $qb->expr()->eq('d.draft', 1),
            $qb->expr()->eq('d.online', 1),
            $qb->expr()->eq('m.actived',1)
        );
        $qb->orderBy('d.created', 'DESC');
        $qb->setMaxResults($max);
        $qb->setParameter('min', $min);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMediaByGalleryId($id)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->leftJoin('f.medias', 'm')
            ->addSelect('m');
        $qb->where(
            $qb->expr()->eq('f.id', ':id')
        );
        $qb->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }
}