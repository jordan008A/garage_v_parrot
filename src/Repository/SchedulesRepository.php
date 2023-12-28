<?php

namespace App\Repository;

use App\Entity\Schedules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedules>
 *
 * @method Schedules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedules[]    findAll()
 * @method Schedules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchedulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedules::class);
    }

    public function findSchedulesOrdered()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('CASE 
                WHEN s.day = \'Lundi\' THEN 1
                WHEN s.day = \'Mardi\' THEN 2
                WHEN s.day = \'Mercredi\' THEN 3
                WHEN s.day = \'Jeudi\' THEN 4
                WHEN s.day = \'Vendredi\' THEN 5
                WHEN s.day = \'Samedi\' THEN 6
                WHEN s.day = \'Dimanche\' THEN 7
                ELSE 8
            END', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Schedules[] Returns an array of Schedules objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Schedules
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
