<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function getBlogCategories()
    {
        return $this->createQueryBuilder('gbc')
            ->andWhere('gbc.parentCategory = :val')
            ->setParameter('val', 3)
            ->orderBy('gbc.name', 'ASC');
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function getProductCategories()
    {
        return $this->createQueryBuilder('gpc')
            ->andWhere('gpc.parentCategory = :val')
            ->setParameter('val', 2)
            ->orderBy('gpc.name', 'ASC');
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Category[]
     */
    public function findLastThree()
    {
        return $this->createQueryBuilder('cat')
            ->andWhere('cat.id >= :val', 'cat.id < :value')
            ->setParameter('val', 15)
            ->setParameter('value', 18)
            ->orderBy('cat.id', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Category[] 
    //  */
}
