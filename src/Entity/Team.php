<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
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


    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'min' => 5,
            'max' => 10,

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

}
