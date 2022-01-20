<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function findIrelevantAds($score): float|int|array|string
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.score < :val')
            ->setParameter('val', $score)
            ->getQuery()
            ->getResult();
    }

    public function findRelevantAds($score): float|int|array|string
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.score >= :val')
            ->setParameter('val', $score)
            ->getQuery()
            ->getResult();
    }
}
