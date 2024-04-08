<?php

namespace App\Entity;

use App\Repository\PictogramNounRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\AssociationOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: PictogramNounRepository::class)]
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
            name: 'pictogram_nouns_sentences',
        ),
        // joinColumns: [new JoinColumn(name: 'pictogramNouns')],
        // inverseJoinColumns: [new JoinColumn(name: 'pictogramNouns')]
    ),
])]
class PictogramNoun extends Pictogram
{
    #[ORM\Column(length: 100)]
    private ?string $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $singular = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plurial = null;

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getSingular(): ?string
    {
        return $this->singular;
    }

    public function setSingular(string $singular): static
    {
        $this->singular = $singular;

        return $this;
    }

    public function getPlurial(): ?string
    {
        return $this->plurial;
    }

    public function setPlurial(string $plurial): static
    {
        $this->plurial = $plurial;

        return $this;
    }
}
