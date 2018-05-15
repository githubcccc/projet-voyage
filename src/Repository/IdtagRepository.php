<?php

namespace App\Repository;

use App\Entity\Idtag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Idtag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idtag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idtag[]    findAll()
 * @method Idtag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdtagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Idtag::class);
    }

//    /**
//     * @return Idtag[] Returns an array of Idtag objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Idtag
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
