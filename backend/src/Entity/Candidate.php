<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Candidate
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private $id;

    #[ORM\OneToOne(targetEntity: BasicData::class, mappedBy:"candidate", cascade:["persist", "remove"])]
    private $basicData;

    #[ORM\OneToOne(targetEntity: ContactData::class, mappedBy:"candidate", cascade:["persist", "remove"])]
    private $contactData;


    #[ORM\OneToMany(targetEntity: Experience::class, mappedBy:"candidate", cascade:["persist", "remove"])]
    private $experiences;


    public function __construct()
    {
        $this->experiences = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getBasicData(): ?BasicData { return $this->basicData; }
    public function setBasicData(BasicData $basicData): self {
        $this->basicData = $basicData;
        if($basicData->getCandidate() !== $this) $basicData->setCandidate($this);
        return $this;
    }

    public function getContactData(): ?ContactData { return $this->contactData; }
    public function setContactData(ContactData $contactData): self {
        $this->contactData = $contactData;
        if($contactData->getCandidate() !== $this) $contactData->setCandidate($this);
        return $this;
    }

    public function getExperiences(): Collection { return $this->experiences; }
    public function addExperience(Experience $exp): self {
        if(!$this->experiences->contains($exp)) {
            $this->experiences[] = $exp;
            $exp->setCandidate($this);
        }
        return $this;
    }
}
