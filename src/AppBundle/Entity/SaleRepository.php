<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * SaleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaleRepository extends EntityRepository
{
    public function findLastFifteen()
    {
        $qb = $this->createQueryBuilder('sale')
            ->orderBy('sale.id', 'DESC')
            ->setMaxResults(15)
            ;

        return $qb->getQuery()->execute();

    }

    public function findByDate($form){
        $cash = $form->get('cash')->getData();
        $person = $form->get('person')->getData();

        $qb = $this->createQueryBuilder('sale');

        $qb
            ->where($qb->expr()->between('sale.createdAt', ':initDate', ':endDate'))
            ->setParameter('initDate', $form->get('initDate')->getData())
            ->setParameter('endDate', $form->get('endDate')->getData());

        if ($cash != 1) {
            $qb
            ->andWhere($qb->expr()->eq('sale.cash', ':cash'))
                ->setParameter('cash', $cash == 2);
        }
        if ($person !== null) {
            $qb->andWhere($qb->expr()->eq('sale.person', ':person'))
                ->setParameter('person', $person);
        }

        return $qb->getQuery()->execute();

    }



}
