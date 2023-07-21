<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'competitions')]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Matches::class)]
    private Collection $matches;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }
    public function generateMatches()
    {
        // Clear existing matches
        $this->matches->clear();

        // Generate new matches based on the number of teams
        $teamsCount = count($this->teams);
        for ($i = 0; $i < $teamsCount - 1; $i++) {
            for ($j = $i + 1; $j < $teamsCount; $j++) {
                $match = new Matches();
                $match->setCompetition($this);
                $match->setTeam1($this->teams[$i]);
                $match->setTeam2($this->teams[$j]);
                $this->matches->add($match);
            }
        }
    }
    public function calculateGoalAverage()
    {
        foreach ($this->teams as $team) {
            $totalGoalsScored = 0;
            $totalGoalsConceded = 0;
            $totalMatchesPlayed = 0;

            foreach ($this->matches as $match) {
                if ($match->getTeam1() === $team) {
                    $totalGoalsScored += $match->getScore1();
                    $totalGoalsConceded += $match->getScore2();
                    $totalMatchesPlayed++;
                }
                elseif($match->getTeam2()===$team){
                    $totalGoalsScored +=$match->getScore2();
                    $totalGoalsConceded +=$match->getScore1();
                    $totalMatchesPlayed++;
                }
            }

            if ($totalMatchesPlayed > 0) {
                $goalAverage = ($totalGoalsScored - $totalGoalsConceded) / $totalMatchesPlayed;
                $team->setgoal_average($goalAverage);
            } else {
                $team->setgoal_average(0);
            }
        }
    }
    public function calculatepoints(){
        foreach($this->teams as $team){
            $totalpoints=0;
//            $totalpoints+=$team->getWins()*2+$team->getDraws();
            foreach ($this->matches as $match) {
                $score1=$match->getScore1();
                $score2=$match->getScore2();
                if($score1!==null&&$score2!==null){
                    if ($match->getTeam1() === $team) {
                        if ($score1 > $score2) {
                            $totalpoints += 2;
                        } elseif ($score1 == $score2) {
                            $totalpoints += 1;
                        }
                    } elseif ($match->getTeam2() === $team) {
                        if ($score2 > $score1) {
                            $totalpoints += 2;
                        } elseif ($score2 == $score1) {
                            $totalpoints += 1;
                        }
                    }
                }
            }
            $team->setpoints_scored($totalpoints);
                }
        }
        public function calculatestats(){
            foreach($this->teams as $team){
                $totalpoints=0;
                $totalwins=0;
                $totaldraws=0;
                $totallosses=0;
//            $totalpoints+=$team->getWins()*2+$team->getDraws();
                foreach ($this->matches as $match) {
                    $score1=$match->getScore1();
                    $score2=$match->getScore2();
                    if($score1!==null&&$score2!==null){
                        if ($match->getTeam1() === $team) {
                            if ($score1 > $score2) {
                                $totalwins++;
                            } elseif ($score1 == $score2) {
                                $totaldraws++;
                            } elseif ($score1 < $score2) {
                                $totallosses++;
                            }
                        } elseif ($match->getTeam2() === $team) {
                            if ($score2 > $score1) {
                                $totalwins++;
                            } elseif ($score2 == $score1) {
                                $totaldraws++;
                            } elseif ($score2 < $score1) {
                                $totallosses++;
                            }
                        }
                    }
                }
                $team->setCompetitionWins($totalwins);
                $team->setCompetitionDraws($totaldraws);
                $team->setCompetitionLosses($totallosses);
            }
        }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        $this->teams->removeElement($team);

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matches $match): static
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);
            $match->setCompetition($this);
        }

        return $this;
    }

    public function removeMatch(Matches $match): static
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getCompetition() === $this) {
                $match->setCompetition(null);
            }
        }

        return $this;
    }
    public function __tostring()
    {
        return$this->getName();
    }
}
