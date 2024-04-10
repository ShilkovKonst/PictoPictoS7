<?php

namespace App\Entity;

use App\Repository\ConjugationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConjugationRepository::class)]
class Conjugation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $tense = null;

    #[ORM\Column(length: 100)]
    private ?string $firstPersonSingular = null;

    #[ORM\Column(length: 100)]
    private ?string $firstPersonPlurial = null;

    #[ORM\Column(length: 100)]
    private ?string $secondPersonSingular = null;

    #[ORM\Column(length: 100)]
    private ?string $secondPersonPlurial = null;

    #[ORM\Column(length: 100)]
    private ?string $thirdPersonSingular = null;

    #[ORM\Column(length: 100)]
    private ?string $thirdPersonPlurial = null;

    #[ORM\ManyToOne(inversedBy: 'conjugations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Irregular $irregular = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTense(): ?string
    {
        return $this->tense;
    }

    public function setTense(string $tense): static
    {
        $this->tense = $tense;

        return $this;
    }

    public function getFirstPersonSingular(): ?string
    {
        return $this->firstPersonSingular;
    }

    public function setFirstPersonSingular(string $firstPersonSingular): static
    {
        $this->firstPersonSingular = $firstPersonSingular;

        return $this;
    }

    public function getFirstPersonPlurial(): ?string
    {
        return $this->firstPersonPlurial;
    }

    public function setFirstPersonPlurial(string $firstPersonPlurial): static
    {
        $this->firstPersonPlurial = $firstPersonPlurial;

        return $this;
    }

    public function getSecondPersonSingular(): ?string
    {
        return $this->secondPersonSingular;
    }

    public function setSecondPersonSingular(string $secondPersonSingular): static
    {
        $this->secondPersonSingular = $secondPersonSingular;

        return $this;
    }

    public function getSecondPersonPlurial(): ?string
    {
        return $this->secondPersonPlurial;
    }

    public function setSecondPersonPlurial(string $secondPersonPlurial): static
    {
        $this->secondPersonPlurial = $secondPersonPlurial;

        return $this;
    }

    public function getThirdPersonSingular(): ?string
    {
        return $this->thirdPersonSingular;
    }

    public function setThirdPersonSingular(string $thirdPersonSingular): static
    {
        $this->thirdPersonSingular = $thirdPersonSingular;

        return $this;
    }

    public function getThirdPersonPlurial(): ?string
    {
        return $this->thirdPersonPlurial;
    }

    public function setThirdPersonPlurial(string $thirdPersonPlurial): static
    {
        $this->thirdPersonPlurial = $thirdPersonPlurial;

        return $this;
    }

    public function getIrregular(): ?Irregular
    {
        return $this->irregular;
    }

    public function setIrregular(?Irregular $irregular): static
    {
        $this->irregular = $irregular;

        return $this;
    }
}
