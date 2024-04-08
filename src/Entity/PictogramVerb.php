<?php

namespace App\Entity;

use App\Repository\PictogramVerbRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\AssociationOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: PictogramVerbRepository::class)]
#[AttributeOverrides([
    new AttributeOverride(
        name: 'id',
        column: new Column()
    ),
])]
#[AssociationOverrides([
    new AssociationOverride(
        name: 'sentences',
        joinTable: new JoinTable(
            name: 'pictogram_verbs_sentences',
        ),
        // joinColumns: [new JoinColumn(name: 'pictogramVerbs')],
        // inverseJoinColumns: [new JoinColumn(name: 'pictogramVerbs')]
    ),
])]
class PictogramVerb extends Pictogram
{
    #[ORM\Column(length: 255)]
    private ?string $singPremPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $singPremFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $singPremPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $singDeuxPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $singDeuxFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $singDeuxPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $singTroisPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $singTroisFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $singTroisPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $plurPremPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $plurPremFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $plurPremPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $plurDeuxPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $plurDeuxFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $plurDeuxPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $plurTroisPresent = null;

    #[ORM\Column(length: 255)]
    private ?string $plurTroisFutur = null;

    #[ORM\Column(length: 255)]
    private ?string $plurTroisPasse = null;

    public function getSingPremPresent(): ?string
    {
        return $this->singPremPresent;
    }

    public function setSingPremPresent(string $singPremPresent): static
    {
        $this->singPremPresent = $singPremPresent;

        return $this;
    }

    public function getSingPremFutur(): ?string
    {
        return $this->singPremFutur;
    }

    public function setSingPremFutur(string $singPremFutur): static
    {
        $this->singPremFutur = $singPremFutur;

        return $this;
    }

    public function getSingPremPasse(): ?string
    {
        return $this->singPremPasse;
    }

    public function setSingPremPasse(string $singPremPasse): static
    {
        $this->singPremPasse = $singPremPasse;

        return $this;
    }

    public function getSingDeuxPresent(): ?string
    {
        return $this->singDeuxPresent;
    }

    public function setSingDeuxPresent(string $singDeuxPresent): static
    {
        $this->singDeuxPresent = $singDeuxPresent;

        return $this;
    }

    public function getSingDeuxFutur(): ?string
    {
        return $this->singDeuxFutur;
    }

    public function setSingDeuxFutur(string $singDeuxFutur): static
    {
        $this->singDeuxFutur = $singDeuxFutur;

        return $this;
    }

    public function getSingDeuxPasse(): ?string
    {
        return $this->singDeuxPasse;
    }

    public function setSingDeuxPasse(string $singDeuxPasse): static
    {
        $this->singDeuxPasse = $singDeuxPasse;

        return $this;
    }

    public function getSingTroisPresent(): ?string
    {
        return $this->singTroisPresent;
    }

    public function setSingTroisPresent(string $singTroisPresent): static
    {
        $this->singTroisPresent = $singTroisPresent;

        return $this;
    }

    public function getSingTroisFutur(): ?string
    {
        return $this->singTroisFutur;
    }

    public function setSingTroisFutur(string $singTroisFutur): static
    {
        $this->singTroisFutur = $singTroisFutur;

        return $this;
    }

    public function getSingTroisPasse(): ?string
    {
        return $this->singTroisPasse;
    }

    public function setSingTroisPasse(string $singTroisPasse): static
    {
        $this->singTroisPasse = $singTroisPasse;

        return $this;
    }

    public function getPlurPremPresent(): ?string
    {
        return $this->plurPremPresent;
    }

    public function setPlurPremPresent(string $plurPremPresent): static
    {
        $this->plurPremPresent = $plurPremPresent;

        return $this;
    }

    public function getPlurPremFutur(): ?string
    {
        return $this->plurPremFutur;
    }

    public function setPlurPremFutur(string $plurPremFutur): static
    {
        $this->plurPremFutur = $plurPremFutur;

        return $this;
    }

    public function getPlurPremPasse(): ?string
    {
        return $this->plurPremPasse;
    }

    public function setPlurPremPasse(string $plurPremPasse): static
    {
        $this->plurPremPasse = $plurPremPasse;

        return $this;
    }

    public function getPlurDeuxPresent(): ?string
    {
        return $this->plurDeuxPresent;
    }

    public function setPlurDeuxPresent(string $plurDeuxPresent): static
    {
        $this->plurDeuxPresent = $plurDeuxPresent;

        return $this;
    }

    public function getPlurDeuxFutur(): ?string
    {
        return $this->plurDeuxFutur;
    }

    public function setPlurDeuxFutur(string $plurDeuxFutur): static
    {
        $this->plurDeuxFutur = $plurDeuxFutur;

        return $this;
    }

    public function getPlurDeuxPasse(): ?string
    {
        return $this->plurDeuxPasse;
    }

    public function setPlurDeuxPasse(string $plurDeuxPasse): static
    {
        $this->plurDeuxPasse = $plurDeuxPasse;

        return $this;
    }

    public function getPlurTroisPresent(): ?string
    {
        return $this->plurTroisPresent;
    }

    public function setPlurTroisPresent(string $plurTroisPresent): static
    {
        $this->plurTroisPresent = $plurTroisPresent;

        return $this;
    }

    public function getPlurTroisFutur(): ?string
    {
        return $this->plurTroisFutur;
    }

    public function setPlurTroisFutur(string $plurTroisFutur): static
    {
        $this->plurTroisFutur = $plurTroisFutur;

        return $this;
    }

    public function getPlurTroisPasse(): ?string
    {
        return $this->plurTroisPasse;
    }

    public function setPlurTroisPasse(string $plurTroisPasse): static
    {
        $this->plurTroisPasse = $plurTroisPasse;

        return $this;
    }
}
