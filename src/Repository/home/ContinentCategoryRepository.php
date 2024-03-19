<?php

namespace App\Repository\home;

use App\Entity\home\ContinentCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContinentCategory>
 *
 * @method ContinentCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContinentCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContinentCategory[]    findAll()
 * @method ContinentCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContinentCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContinentCategory::class);
    }

//    /**
//     * @return ContinentCategory[] Returns an array of ContinentCategory objects
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

//    public function findOneBySomeField($value): ?ContinentCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
