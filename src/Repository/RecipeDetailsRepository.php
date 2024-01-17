<?php

namespace App\Repository;

use App\Entity\RecipeDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeDetails>
 *
 * @method RecipeDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeDetails[]    findAll()
 * @method RecipeDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeDetails::class);
    }

//    /**
//     * @return RecipeDetails[] Returns an array of RecipeDetails objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeDetails
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
