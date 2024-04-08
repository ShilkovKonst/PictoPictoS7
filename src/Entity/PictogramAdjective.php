<?php

namespace App\Entity;

use App\Repository\PictogramAdjectiveRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\AssociationOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: PictogramAdjectiveRepository::class)]
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
            name: 'pictogram_adjectives_sentences',
        ),
    ),
])]
class PictogramAdjective extends Pictogram
{
    #[ORM\Column(length: 255)]
    private ?string $singMasculin = null;

    #[ORM\Column(length: 255)]
    private ?string $singFeminin = null;

    #[ORM\Column(length: 255)]
    private ?string $plurMasculin = null;

    #[ORM\Column(length: 255)]
    private ?string $plurFeminin = null;

    public function getSingMasculin(): ?string
    {
        return $this->singMasculin;
    }

    public function setSingMasculin(string $singMasculin): static
    {
        $this->singMasculin = $singMasculin;

        return $this;
    }

    public function getSingFeminin(): ?string
    {
        return $this->singFeminin;
    }

    public function setSingFeminin(string $singFeminin): static
    {
        $this->singFeminin = $singFeminin;

        return $this;
    }

    public function getPlurMasculin(): ?string
    {
        return $this->plurMasculin;
    }

    public function setPlurMasculin(string $plurMasculin): static
    {
        $this->plurMasculin = $plurMasculin;

        return $this;
    }

    public function getPlurFeminin(): ?string
    {
        return $this->plurFeminin;
    }

    public function setPlurFeminin(string $plurFeminin): static
    {
        $this->plurFeminin = $plurFeminin;

        return $this;
    }
}
