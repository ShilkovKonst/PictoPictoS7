<?php

namespace App\Entity;

use App\Repository\InstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstitutionRepository::class)]
class Institution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: Therapist::class, mappedBy: 'institution')]
    private Collection $therapists;

    public function __construct()
    {
        $this->therapists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Therapist>
     */
    public function getTherapists(): Collection
    {
        return $this->therapists;
    }

    public function addTherapists(Therapist $therapist): static
    {
        if (!$this->therapists->contains($therapist)) {
            $this->therapists->add($therapist);
            $therapist->setInstitution($this);
        }

        return $this;
    }

    public function removeTherapist(Therapist $therapist): static
    {
        if ($this->therapists->removeElement($therapist)) {
            // set the owning side to null (unless already changed)
            if ($therapist->getInstitution() === $this) {
                $therapist->setInstitution(null);
            }
        }

        return $this;
    }
}
