<?php

namespace App\Repository;

use App\Entity\HistoryFixing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryFixing>
 */
class HistoryFixingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryFixing::class);
    }

    public function filteringByPeriod(string $period): array
    {
        $availablePeriods = [
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            'yearly' => 365
        ];

        $period = $availablePeriods[$period];

        $current_date = time();
        $period_date = strtotime("-$period days", $current_date);
        return $this->createQueryBuilder('h')
            ->where('h.OpenTime BETWEEN :start AND :end')
            ->setParameter('start', $period_date)
            ->setParameter('end', $current_date)
            ->orderBy('h.OpenTime', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return HistoryFixing[] Returns an array of HistoryFixing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoryFixing
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
