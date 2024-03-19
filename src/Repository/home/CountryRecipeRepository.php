<?php

namespace App\Repository\home;

use App\Entity\home\CountryRecipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CountryRecipe>
 *
 * @method CountryRecipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryRecipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryRecipe[]    findAll()
 * @method CountryRecipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CountryRecipe::class);
    }

//    /**
//     * @return CountryRecipe[] Returns an array of CountryRecipe objects
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

//    public function findOneBySomeField($value): ?CountryRecipe
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
