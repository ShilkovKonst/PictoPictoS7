<?php

namespace App\Entity;

use App\Repository\PictogramAdjectiveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictogramAdjectiveRepository::class)]
class PictogramAdjective extends Pictogram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $SingMasculin = null;

    #[ORM\Column(length: 255)]
    private ?string $SingFeminin = null;

    #[ORM\Column(length: 255)]
    private ?string $PlurMasculin = null;

    #[ORM\Column(length: 255)]
    private ?string $PlurFeminin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSingMasculin(): ?string
    {
        return $this->SingMasculin;
    }

    public function setSingMasculin(string $SingMasculin): static
    {
        $this->SingMasculin = $SingMasculin;

        return $this;
    }

    public function getSingFeminin(): ?string
    {
        return $this->SingFeminin;
    }

    public function setSingFeminin(string $SingFeminin): static
    {
        $this->SingFeminin = $SingFeminin;

        return $this;
    }

    public function getPlurMasculin(): ?string
    {
        return $this->PlurMasculin;
    }

    public function setPlurMasculin(string $PlurMasculin): static
    {
        $this->PlurMasculin = $PlurMasculin;

        return $this;
    }

    public function getPlurFeminin(): ?string
    {
        return $this->PlurFeminin;
    }

    public function setPlurFeminin(string $PlurFeminin): static
    {
        $this->PlurFeminin = $PlurFeminin;

        return $this;
    }
}
