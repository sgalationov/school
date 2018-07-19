<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 10.07.2018
 * Time: 18:32
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class LectureRepository extends EntityRepository
{
    public function getPublishedLecture(){
        $qb = $this->createQueryBuilder('l');
        $qb->andWhere('l.status = :ls');

        $qb->leftJoin('l.subject', 'lsu');
        $qb->andWhere('lsu.name = :lsun');

        $qb->setParameter(':ls', "Идет");
        $qb->setParameter(':lsun', 'название');
        $qb->getQuery()->getSQL();
        return $qb->getQuery()->getResult();
    }
}