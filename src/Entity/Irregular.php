<?php

namespace App\Entity;

use App\Repository\IrregularRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IrregularRepository::class)]
class Irregular
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $feminin = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $pastParticiple = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $plurial = null;

    #[ORM\OneToMany(targetEntity: Conjugation::class, mappedBy: 'irregular', orphanRemoval: true)]
    private Collection $conjugations;

    public function __construct()
    {
        $this->conjugations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeminin(): ?string
    {
        return $this->feminin;
    }

    public function setFeminin(?string $feminin): static
    {
        $this->feminin = $feminin;

        return $this;
    }

    public function getPastParticiple(): ?string
    {
        return $this->pastParticiple;
    }

    public function setPastParticiple(?string $pastParticiple): static
    {
        $this->pastParticiple = $pastParticiple;

        return $this;
    }

    public function getPlurial(): ?string
    {
        return $this->plurial;
    }

    public function setPlurial(?string $plurial): static
    {
        $this->plurial = $plurial;

        return $this;
    }

    /**
     * @return Collection<int, Conjugation>
     */
    public function getConjugations(): Collection
    {
        return $this->conjugations;
    }

    public function addConjugation(Conjugation $conjugation): static
    {
        if (!$this->conjugations->contains($conjugation)) {
            $this->conjugations->add($conjugation);
            $conjugation->setIrregular($this);
        }

        return $this;
    }

    public function removeConjugation(Conjugation $conjugation): static
    {
        if ($this->conjugations->removeElement($conjugation)) {
            // set the owning side to null (unless already changed)
            if ($conjugation->getIrregular() === $this) {
                $conjugation->setIrregular(null);
            }
        }

        return $this;
    }
}
