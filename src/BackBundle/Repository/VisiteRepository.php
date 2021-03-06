<?php

namespace BackBundle\Repository;

/**
 * VisiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByStageId($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('v')
            ->from($this->_entityName, 'v')
            ->LeftJoin('v.leStage', 's')
            ->where('s.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }
}
