<?php

namespace App\Entity;

use App\Entity\Trait\IllustrationFilenameTrait;
use App\Entity\Trait\NameTrait;
use App\Entity\Trait\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Pictogram
{
    use NameTrait;
    use IllustrationFilenameTrait;
    use UpdatedAtTrait;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    private ?Therapist $therapist = null;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    private ?Sentence $sentences = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTherapist(): ?Therapist
    {
        return $this->therapist;
    }

    public function setTherapist(?Therapist $therapist): static
    {
        $this->therapist = $therapist;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSentences(): ?Sentence
    {
        return $this->sentences;
    }

    public function setSentences(?Sentence $sentences): static
    {
        $this->sentences = $sentences;

        return $this;
    }
}
