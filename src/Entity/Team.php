<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Faker\Factory;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $creationDate= null;

    #[ORM\Column(length: 255)]
    private ?string $coach = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $sponsor = null;

    #[ORM\OneToMany(mappedBy: 'team_id', targetEntity: Member::class, orphanRemoval: true)]
    private Collection $members;

    #[ORM\ManyToMany(targetEntity: Sponsor::class, mappedBy: 'team')]
    private Collection $sponsors;

    #[ORM\OneToMany(mappedBy: 'team1', targetEntity: Matches::class)]
    private Collection $matches;

    #[ORM\Column(type: 'integer',nullable:false, options: ['default' => 0])]
    private ?int $wins = 0;
    #[ORM\Column(type: 'integer',nullable:false, options: ['default' => 0]), ]
    private ?int $losses = 0;

    #[ORM\Column(type: 'integer',nullable:false, options: ['default' => 0])]
    private ?int $draws = 0;


    #[ORM\ManyToMany(targetEntity: Competition::class, mappedBy: 'teams')]
    private Collection $competitions;

    #[ORM\Column(type:'integer',nullable:true)]
    private ?int $points_scored = 0;

    #[ORM\Column(type:'float',nullable:true)]
    private ?float $goal_average=0 ;

    #[ORM\Column(type: 'integer',nullable:true, options: ['default' => 0])]
    private ?int $CompetitionWins = 0;

    #[ORM\Column(type: 'integer',nullable:true, options: ['default' => 0])]
    private ?int $CompetitionDraws = 0;

    #[ORM\Column(type: 'integer',nullable:true, options: ['default' => 0])]
    private ?int $CompetitionLosses = 0;


    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'min' => 3,
            'max' => 20,
            'minMessage' => 'Your team name must be at least {{ limit }} characters long',
            'maxMessage' => 'Your team name cannot be longer than {{ limit }} characters',
        ]));
//        $metadata->addGetterConstraint('nameinbounds',new Assert\IsTrue([
//            'message' =>'The name must be between {{min}} to {{max}} characters long',
//
//        ]));

    }

//    public function isnameinbounds(): bool
//    {   $namesize =strlen($this->name);
//        return ($namesize>5 &&$namesize<10);
//    }
    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->competitions = new ArrayCollection();

    }

    public function generateShirtNumber($randomNumber,$assignedNumbers)
    {
        while (in_array($randomNumber, $assignedNumbers)) {
            $randomNumber = rand(1, 90);
        }
        return $randomNumber;
    }

    public function generateplayers(EntityManagerInterface $entityManager){
        $faker=Factory::create();
        $gender='male';
        $assignedNumbers=[];
        $randomNumber = rand(1, 90);
//        while(in_array($randomNumber,$assignedNumbers)){
//            $randomNumber = rand(1, 90);
//        }
        $assignedNumbers[] = $randomNumber;
        if(sizeof($this->getMembers())<11){
            $player=new Member();
            $player->setName($faker->name($gender));
            $player->setAge(rand(18,38));
            $player->setRole("Goalkeeper");
            $player->setTeamId($this);
            $player->setShirtNumber(1);
            $entityManager->persist($player);

        for($x=0;$x<4;$x++) {
            $player = new Member();
            $player->setName($faker->name($gender));
            $player->setAge(rand(18, 38));
            $player->setRole("Defender");
            $player->setTeamId($this);
            $player->setShirtNumber($this->generateShirtNumber($randomNumber, $assignedNumbers));
            $assignedNumbers[] = $player->getShirtNumber();
            $entityManager->persist($player);
        }

            for ($x = 0; $x < 3; $x++) {
                $player = new Member();
                $player->setName($faker->name($gender));
                $player->setAge(rand(18, 38));
                $player->setRole("Midfielder");
                $player->setTeamId($this);
                $player->setShirtNumber($this->generateShirtNumber($randomNumber, $assignedNumbers));
                $assignedNumbers[] = $player->getShirtNumber();
                $entityManager->persist($player);
            }
            for ($x = 0; $x < 3; $x++) {
                $player = new Member();
                $player->setName($faker->name($gender));
                $player->setAge(rand(18, 38));
                $player->setRole("Striker");
                $player->setTeamId($this);
                $player->setShirtNumber($this->generateShirtNumber($randomNumber, $assignedNumbers));
                $assignedNumbers[] = $player->getShirtNumber();
                $entityManager->persist($player);
            }


    }}

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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCoach(): ?string
    {
        return $this->coach;
    }

    public function setCoach(string $coach): static
    {
        $this->coach = $coach;

        return $this;
    }

    public function getSponsor(): ?string
    {
        return $this->sponsor;
    }

    public function setSponsor(string $sponsor): static
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setTeamId($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getTeamId() === $this) {
                $member->setTeamId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsor $sponsor): static
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors->add($sponsor);
            $sponsor->addTeam($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): static
    {
        if ($this->sponsors->removeElement($sponsor)) {
            $sponsor->removeTeam($this);
        }

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
            $match->setTeam1($this);
        }

        return $this;
    }

    public function removeMatch(Matches $match): static
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getTeam1() === $this) {
                $match->setTeam1(null);
            }
        }

        return $this;
    }
    public function __tostring()
    {
        return$this->getName();
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(int $wins): static
    {
        $this->wins = $wins;

        return $this;
    }

    public function getLosses(): ?int
    {
        return $this->losses;
    }

    public function setLosses(int $losses): static
    {
        $this->losses = $losses;

        return $this;
    }

    public function getDraws(): ?int
    {
        return $this->draws;
    }

    public function setDraws(int $draws): static
    {
        $this->draws = $draws;

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): static
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->addTeam($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): static
    {
        if ($this->competitions->removeElement($competition)) {
            $competition->removeTeam($this);
        }

        return $this;
    }

    public function getpoints_scored(): ?int
    {
        return $this->points_scored;
    }

    public function setpoints_scored(int $points_scored): static
    {
        $this->points_scored = $points_scored;

        return $this;
    }

    public function getgoal_average(): ?float
    {
        return $this->goal_average;
    }

    public function setgoal_average(float $goal_average): static
    {
        $this->goal_average = $goal_average;

        return $this;
    }

    public function getCompetitionWins(): ?int
    {
        return $this->CompetitionWins;
    }

    public function setCompetitionWins(int $CompetitionWins): static
    {
        $this->CompetitionWins = $CompetitionWins;

        return $this;
    }

    public function getCompetitionDraws(): ?int
    {
        return $this->CompetitionDraws;
    }

    public function setCompetitionDraws(int $CompetitionDraws): static
    {
        $this->CompetitionDraws = $CompetitionDraws;

        return $this;
    }

    public function getCompetitionLosses(): ?int
    {
        return $this->CompetitionLosses;
    }

    public function setCompetitionLosses(int $CompetitionLosses): static
    {
        $this->CompetitionLosses = $CompetitionLosses;

        return $this;
    }
}
