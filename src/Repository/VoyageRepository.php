<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Voyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyage[]    findAll()
 * @method Voyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Voyage::class);
    }
    //Dans voyageRepository on faire jointure à partir table voyage
    public function findOneWithCategory(int $id): ?Voyage
    {

        $query =$this->createQueryBuilder('v') //alias 'v' sigifie table voyage
            ->join('v.category','c')// jointure de table voyage et category  note c
            ->addSelect('c')//ajoute la table c

            ->setParameter(":id",$id)// recupere id de voyage que on veut
            ->Where('v.id=:id')//on dit la condition que on veut :ici id de voyatge selectionné egale celui dans la  table

            ->leftjoin('v.commentaires','co')//join pour les cote  leftjoin  on gared celui gauche et ajoute facultatifement droite  ici la table voyage est cote gauche
            ->addSelect('co')
            ->getQuery()
        ;
        try{return $query->getOneOrNullResult();}

        catch(\Exception $e){
            //throw new\Exception('probleme dans VoyageRepository::findOneWithCategory'.$e->getMessage()/*.
             //   var_dump($e)*/);
        }

    }

    /**
     * Récupère les voyages d'une catégorie donnée
     * @param int $id
     * @return Query (le use pour la Query ; use Doctrine\ORM\Query;)
     */
    public function findByCategory(int $id): Query
    {
        return $this->createQueryBuilder('v')
            ->join('v.category', 'c')
            ->addSelect('c')
            ->where('v.category = :id')->setParameter(":id", $id)
            ->getQuery()
            ;
    }




//    /**
//     * @return Voyage[] Returns an array of Voyage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voyage
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
