<?php

namespace App\Entity;

use App\Repository\PariSingulierRepository;
use Doctrine\ORM\Mapping as ORM;

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

}
