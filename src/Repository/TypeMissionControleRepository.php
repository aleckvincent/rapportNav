<?php

namespace App\Repository;

use App\Entity\TypeMissionControle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeMissionControle|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMissionControle|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMissionControle[]    findAll()
 * @method TypeMissionControle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMissionControleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeMissionControle::class);
    }

    // /**
    //  * @return TypeMissionControle[] Returns an array of TypeMissionControle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeMissionControle
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
