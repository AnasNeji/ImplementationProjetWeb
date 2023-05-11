<?php

namespace App\Entity;

use App\Repository\FixtureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FixtureRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Fixture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Heure = null;

    #[ORM\Column]
    private ?bool $Encours = null;

    #[ORM\Column]
    private ?bool $Termine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $Equipe1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $Equipe2 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $Odds_1 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $Odds_x = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $Odds_2 = null;

    #[ORM\Column]
    private ?int $Goals_Equipe1 = null;

    #[ORM\Column]
    private ?int $Goals_Equipe2 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competition $Id_competition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function isEncours(): ?bool
    {
        return $this->Encours;
    }

    public function setEncours(bool $Encours): self
    {
        $this->Encours = $Encours;

        return $this;
    }

    public function isTermine(): ?bool
    {
        return $this->Termine;
    }

    public function setTermine(bool $Termine): self
    {
        $this->Termine = $Termine;

        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->Equipe1;
    }

    public function setEquipe1(?Equipe $Equipe1): self
    {
        $this->Equipe1 = $Equipe1;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->Equipe2;
    }

    public function setEquipe2(?Equipe $Equipe2): self
    {
        $this->Equipe2 = $Equipe2;

        return $this;
    }

    public function getOdds1(): ?string
    {
        return $this->Odds_1;
    }

    public function setOdds1(string $Odds_1): self
    {
        $this->Odds_1 = $Odds_1;

        return $this;
    }

    public function getOddsX(): ?string
    {
        return $this->Odds_x;
    }

    public function setOddsX(string $Odds_x): self
    {
        $this->Odds_x = $Odds_x;

        return $this;
    }

    public function getOdds2(): ?string
    {
        return $this->Odds_2;
    }

    public function setOdds2(string $Odds_2): self
    {
        $this->Odds_2 = $Odds_2;

        return $this;
    }

    public function getGoalsEquipe1(): ?int
    {
        return $this->Goals_Equipe1;
    }

    public function setGoalsEquipe1(int $Goals_Equipe1): self
    {
        $this->Goals_Equipe1 = $Goals_Equipe1;

        return $this;
    }

    public function getGoalsEquipe2(): ?int
    {
        return $this->Goals_Equipe2;
    }

    public function setGoalsEquipe2(int $Goals_Equipe2): self
    {
        $this->Goals_Equipe2 = $Goals_Equipe2;

        return $this;
    }

    public function getIdCompetition(): ?Competition
    {
        return $this->Id_competition;
    }

    public function setIdCompetition(?Competition $Id_competition): self
    {
        $this->Id_competition = $Id_competition;

        return $this;
    }
    public function GetWinner():string
    {

        if ($this->Goals_Equipe1>$this->Goals_Equipe2)
            return '1';
        else if ($this->Goals_Equipe1<$this->Goals_Equipe2)
            return '2';
        else return 'X';

    }
}
