<?php

namespace App\Repository;

use App\Entity\Fixture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fixture>
 *
 * @method Fixture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fixture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fixture[]    findAll()
 * @method Fixture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FixtureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fixture::class);
    }

    public function save(Fixture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fixture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByDatePlayoff($Date, $orderBy = 'ASC')
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.Date = :Date')
            ->setParameter('Date', $Date)
            ->andWhere('f.Id_competition = 1')
            ->orderBy('f.Heure', $orderBy)
            ->getQuery()
            ->getResult();
    }

    public function findByDatePlayout($Date, $orderBy = 'ASC')
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.Date = :Date')
            ->setParameter('Date', $Date)
            ->andWhere('f.Id_competition = 2')
            ->orderBy('f.Heure', $orderBy)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Fixture[] Returns an array of Fixture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fixture
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
