<?php

namespace App\Entity;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PariSingulierRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Bool_;

#[ORM\Entity(repositoryClass: PariSingulierRepository::class)]
class PariSingulier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fixture $Id_fixture = null;

    #[ORM\Column(length: 1)]
    private ?string $Choix = null;

    #[ORM\Column]
    private ?bool $resultat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?pari $Id_pari = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFixture(): ?Fixture
    {
        return $this->Id_fixture;
    }

    public function setIdFixture(?Fixture $Id_fixture): self
    {
        $this->Id_fixture = $Id_fixture;

        return $this;
    }

    public function getChoix(): ?string
    {
        return $this->Choix;
    }

    public function setChoix(string $Choix): self
    {
        $this->Choix = $Choix;

        return $this;
    }

    public function isResultat(): ?bool
    {
        return $this->resultat;
    }

    public function setResultat(bool $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getIdPari(): ?pari
    {
        return $this->Id_pari;
    }

    public function setIdPari(?pari $Id_pari): self
    {
        $this->Id_pari = $Id_pari;

        return $this;
    }
    public function getCote():string
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
            'X' => $fixture->getOddsX(),
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
                        "       choix= ".
                        $this->getChoix().
                        "        cout=".
                        $this->getCote();

        return $Match_Details;
    }
    public function UpdateResultat():Bool
    {
        $fixture = $this->getIdFixture();
        if ($fixture->GetWinner() == $this->getChoix()) {
            $this->resultat = 1;
            return 1;
        } else {
            $this->resultat = 0;
            return 0;
        }
    }
}
