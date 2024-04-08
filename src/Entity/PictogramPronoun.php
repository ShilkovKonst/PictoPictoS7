<?php

namespace App\Entity;

use App\Repository\PictogramPronounRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AssociationOverride;
use Doctrine\ORM\Mapping\AssociationOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: PictogramPronounRepository::class)]
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
            name: 'pictogram_pronouns_sentences',
        ),
        // joinColumns: [new JoinColumn(name: 'pictogramPronouns')],
        // inverseJoinColumns: [new JoinColumn(name: 'pictogramPronouns')]
    ),
])]
class PictogramPronoun extends Pictogram
{
    #[ORM\Column(length: 255)]
    private ?string $person = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genre = null;

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(string $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
}
