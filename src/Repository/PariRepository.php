<?php

namespace App\Repository;

use App\Entity\Pari;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pari>
 *
 * @method Pari|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pari|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pari[]    findAll()
 * @method Pari[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PariRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pari::class);
    }

    public function save(Pari $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pari $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Pari[] Returns an array of Pari objects
//     */
    public function findByUserId($UserId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Id_user = :val')
            ->setParameter('val', $UserId)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /*public function getPariSinguliers(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
        FROM src\Entity\PariSingulier p
        WHERE p.pariPrincipal = :idPariPrincipal'
        )->setParameter('idPariPrincipal', $this->id);

        return $query->getResult();
    }*/


//    public function findOneBySomeField($value): ?Pari
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
