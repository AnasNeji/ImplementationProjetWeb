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
    public function findByResultat($resultat): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.resultat = :val')
            ->setParameter('val', $resultat)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getCote()
    {
        /*$entityManager = $this->getEntityManager();
        $fixture = $entityManager->createQuery(
            'SELECT f
            FROM App\Entity\Fixture f
            WHERE f.id = :idFixture'
        )->setParameter('idFixture', $this->Id_fixture)->getSingleResult();
*/
        $fixture=$this->Id_fixture;

        return match ($this->Choix) {
            '1' => $fixture->getOdds1(),
            'x' => $fixture->getOddsX(),
            '2' => $fixture->getOdds2(),
            default => null,
        };
    }
    public function getPariSingulierDetails()
    {
        /*$entityManager = $this->getEntityManager();
        $fixture = $entityManager->createQuery(
            'SELECT f
        FROM src\Entity\Fixture f
        WHERE f.id = :idFixture'
        )->setParameter('idFixture', $this->Id_fixture)->getSingleResult();*/
        $fixture=$this->Id_fixture;

        $Match_Details=$fixture->getEquipe1()->getAbreviation().
            "   vs    ".
            $fixture->getEquipe2()->getAbreviation().
            $this->getCote().
            "       choix= ".
            $this->getChoix();
        return $Match_Details;
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
