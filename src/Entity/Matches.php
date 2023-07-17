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

    #[ORM\Column( nullable:true)]
    private ?int $score1 = null;

    #[ORM\Column( nullable:true)]
    private ?int $score2 =null;

    #[ORM\ManyToMany(targetEntity: Referees::class, inversedBy: 'matches')]
    private Collection $referees;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    private ?Competition $competition = null;

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

//    public function setScore1(int $score1): static
//    {
//        if ($this->getTeam1() !== null/*&&$this->team1->getWins!==null&&$this->team1->getLosses!==null&&$this->team1->getLosse!==null*/) {
//            $this->score1 = $score1;
//            if ($score1 > $this->score2) {
//                $this->team1->setWins($this->team1->getWins() + 1);
//              //  $this->team2->setLosses($this->team2->getLosses() + 1);
//            } elseif ($score1 == $this->score2) {
//                $this->team1->setDraws($this->team1->getDraws() + 1);
//             //   $this->team2->setDraws($this->team2->getDraws() + 1);
//            } elseif ($score1 < $this->score2) {
//                $this->team1->setLosses($this->team1->getLosses() + 1);
//              //  $this->team2->setWins($this->team2->getWins() + 1);
//            }
//        }
//
//        return $this;
//    }

//    public function setScore2(int $score2): static
//    {   if($this->getTeam2() !== null) {
//        $this->score2 = $score2;
//        if ($this->score1 > $score2) {
//            //  $this->team1->setWins($this->team1->getWins()+1);
//            $this->team2->setLosses($this->team2->getLosses() + 1);
//        } elseif ($this->score1 == $score2) {
//            //   $this->team1->setDraws($this->team1->getDraws()+1);
//            $this->team2->setDraws($this->team2->getDraws() + 1);
//        } elseif ($this->score1 < $score2) {
//            //$this->team1->setLosses($this->team1->getLosses()+1);
//            $this->team2->setWins($this->team2->getWins() + 1);
//        }
//    }
//
//        return $this;
//    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }
    public function setScore1(int $score1): static
    {
        $this->score1 = $score1;

        return $this;
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

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }
}
