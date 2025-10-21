<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ContactData
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:20)]
    private $phone;

    #[ORM\Column(type:"string", length:100)]
    private $email;

    #[ORM\OneToOne(targetEntity: Candidate::class, inversedBy:"contactData")]
    #[ORM\JoinColumn(nullable:false)]
    private $candidate;

    public function getId(): ?int { return $this->id; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getCandidate(): ?Candidate { return $this->candidate; }
    public function setCandidate(Candidate $candidate): self { $this->candidate = $candidate; return $this; }
}
