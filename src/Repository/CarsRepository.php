<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cars>
 *
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function findCarsWithPrimaryPicture()
    {
        // Construire une requête pour obtenir des voitures avec leur image principale, leur marque et leur technologie moteur
        return $this->createQueryBuilder('c')
            ->addSelect('p', 'b', 'm') // Ajouter des sélections pour les images, les marques et les technologies moteur
            ->leftJoin('c.pictures', 'p', 'WITH', 'p.is_primary = true') // Joindre les images principales
            ->leftJoin('c.brand', 'b') // Joindre la marque
            ->leftJoin('c.motorTechnologie', 'm') // Joindre la technologie moteur
            ->getQuery()
            ->getResult();
    }

    public function findFilteredCars($yearMin, $yearMax, $kmMin, $kmMax, $priceMin, $priceMax)
    {
        $qb = $this->createQueryBuilder('c');

        if ($yearMin) {
            $qb->andWhere('c.year >= :yearMin')
               ->setParameter('yearMin', $yearMin);
        }

        if ($yearMax) {
            $qb->andWhere('c.year <= :yearMax')
               ->setParameter('yearMax', $yearMax);
        }

        if ($kmMin) {
            $qb->andWhere('c.mileage >= :kmMin')
               ->setParameter('kmMin', $kmMin);
        }

        if ($kmMax) {
            $qb->andWhere('c.mileage <= :kmMax')
               ->setParameter('kmMax', $kmMax);
        }

        if ($priceMin) {
            $qb->andWhere('c.price >= :priceMin')
               ->setParameter('priceMin', $priceMin);
        }

        if ($priceMax) {
            $qb->andWhere('c.price <= :priceMax')
               ->setParameter('priceMax', $priceMax);
        }

        $qb->leftJoin('c.pictures', 'p')
           ->addSelect('p')
           ->andWhere('p.is_primary = true');

        $qb->leftJoin('c.brand', 'b');

        $qb->leftJoin('c.motorTechnologie', 'm');

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Cars[] Returns an array of Cars objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
