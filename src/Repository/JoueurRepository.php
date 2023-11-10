<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Joueur>
 *
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }



    public function showJoveurs(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.equipe=:val')
            ->setParameter('val', 'Tunisie')
            ->orderBy('j.nom', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
    }


    public function getSommeVoteByJoueur($id)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery("SELECT SUM(v.noteVote) AS somme FROM App\Entity\Vote v JOIN v.joueur j WHERE j.id = :id")
            ->setParameter('id', $id);
        return $query->getSingleScalarResult();
    }
}

//    /**
//     * @return Joueur[] Returns an array of Joueur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Joueur
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
