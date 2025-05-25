<?php

namespace App\Repository;

use App\Entity\Plant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plant>
 */
class PlantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plant::class);
    }

    /**
     * @return Plant[]
     */

    public function findBySearchBar($criteria): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($criteria->getName()) {
            $qb->andWhere('p.name LIKE :name')
                ->setParameter('name', '%' . $criteria->getName() . '%');
        }

        if ($criteria->getCategory()) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $criteria->getCategory());
        }

        if ($criteria->getWaterNeed()) {
            $qb->andWhere('p.waterNeed = :waterNeed')
                ->setParameter('waterNeed', $criteria->getWaterNeed());
        }

        if ($criteria->getSunlightNeed()) {
            $qb->andWhere('p.sunlightNeed = :sunlightNeed')
                ->setParameter('sunlightNeed', $criteria->getSunlightNeed());
        }

        if ($criteria->getSowingPeriodSearch()) {
            $qb->andWhere(':sowingPeriod BETWEEN p.sowingPeriodStart AND p.sowingPeriodEnd')
                ->setParameter('sowingPeriod', $criteria->getSowingPeriodSearch());
        }

        if ($criteria->getPlantingPeriodSearch()) {
            $qb->andWhere(':plantingPeriod BETWEEN p.plantingPeriodStart AND p.plantingPeriodEnd')
                ->setParameter('plantingPeriod', $criteria->getPlantingPeriodSearch());
        }

        if ($criteria->getHarvestPeriodSearch()) {
            $qb->andWhere(':harvestPeriod BETWEEN p.harvestPeriodStart AND p.harvestPeriodEnd')
                ->setParameter('harvestPeriod', $criteria->getHarvestPeriodSearch());
        }

        return $qb->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }


    //    public function findOneBySomeField($value): ?Plant
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
