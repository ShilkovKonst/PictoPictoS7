<?php

namespace App\Entity;

use App\Repository\PictogramNomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictogramNomRepository::class)]
class PictogramNoun extends Pictogram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $singular = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plurial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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
