<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Experience
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:100)]
    private $company;

    #[ORM\Column(type:"string", length:100)]
    private $position;

    #[ORM\Column(type:"date")]
    private $dateFrom;

    #[ORM\Column(type:"date", nullable:true)]
    private $dateTo;

    #[ORM\ManyToOne(targetEntity:Candidate::class, inversedBy:"experiences")]
    #[ORM\JoinColumn(nullable:false)]
    private $candidate;

    public function getId(): ?int { return $this->id; }

    public function getCompany(): ?string { return $this->company; }
    public function setCompany(string $company): self { $this->company = $company; return $this; }

    public function getPosition(): ?string { return $this->position; }
    public function setPosition(string $position): self { $this->position = $position; return $this; }

    public function getDateFrom(): ?\DateTimeInterface { return $this->dateFrom; }
    public function setDateFrom(\DateTimeInterface $dateFrom): self { $this->dateFrom = $dateFrom; return $this; }

    public function getDateTo(): ?\DateTimeInterface { return $this->dateTo; }
    public function setDateTo(?\DateTimeInterface $dateTo): self { $this->dateTo = $dateTo; return $this; }

    public function getCandidate(): ?Candidate { return $this->candidate; }
    public function setCandidate(Candidate $candidate): self { $this->candidate = $candidate; return $this; }
}
