<?php

namespace App\Repository;

use App\Entity\MotorTechnologies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotorTechnologies>
 *
 * @method MotorTechnologies|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotorTechnologies|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotorTechnologies[]    findAll()
 * @method MotorTechnologies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotorTechnologiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotorTechnologies::class);
    }

//    /**
//     * @return MotorTechnologies[] Returns an array of MotorTechnologies objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MotorTechnologies
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
