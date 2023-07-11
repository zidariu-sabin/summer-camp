<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team1 = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team2 = null;

    #[ORM\Column]
    private ?int $score1 = null;

    #[ORM\Column]
    private ?int $score2 = null;

    #[ORM\ManyToMany(targetEntity: Referees::class, inversedBy: 'matches')]
    private Collection $referees;

    public function __construct()
    {
        $this->referees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?Team
    {
        return $this->team1;
    }

    public function setTeam1(?Team $team1): static
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->team2;
    }

    public function setTeam2(?Team $team2): static
    {
        $this->team2 = $team2;

        return $this;
    }

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(int $score1): static
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }

    public function setScore2(int $score2): static
    {
        $this->score2 = $score2;

        return $this;
    }

    /**
     * @return Collection<int, Referees>
     */

    public function getReferees(): Collection
    {
        return $this->referees;
    }


    public function addReferee(Referees $referee): static
    {
        if (!$this->referees->contains($referee)) {
            $this->referees->add($referee);
        }

        return $this;
    }

    public function removeReferee(Referees $referee): static
    {
        $this->referees->removeElement($referee);

        return $this;
    }
    public function getName(): string
    {
        return $this->team1->getName() . ' vs ' . $this->team2->getName();
    }

    public function __tostring()
    {
        return$this->getName();
    }
}
