<?php

namespace App\Repository;

use App\Entity\PariSingulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PariSingulier>
 *
 * @method PariSingulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method PariSingulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method PariSingulier[]    findAll()
 * @method PariSingulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PariSingulierRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, PariSingulier::class);
    }

    public function save(PariSingulier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PariSingulier $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PariSingulier[] Returns an array of PariSingulier objects
//     */
    public function findByPariId($PariId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Id_pari = :val')
            ->setParameter('val', $PariId)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getTotalOdds($IdPari): float
    {

        $PariSinguliers = $this->findByPariId($IdPari);
        $totalOdds = 1.0;
        foreach ($PariSinguliers as $PariSingulier) {
            $totalOdds *= $PariSingulier->getCote();
        }
        return $totalOdds;

//    public function findOneBySomeField($value): ?PariSingulier
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    }
}
