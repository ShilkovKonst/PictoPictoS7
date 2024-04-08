<?php

namespace App\Entity;

use App\Entity\Trait\IllustrationFilenameTrait;
use App\Entity\Trait\NameTrait;
use App\Entity\Trait\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Pictogram
{
    use NameTrait;
    use IllustrationFilenameTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    private ?Therapist $therapist = null;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Sentence::class, inversedBy: 'pictograms')]
    private Collection $sentences;

    public function __construct()
    {
        $this->sentences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Sentence>
     */
    public function getSentences(): Collection
    {
        return $this->sentences;
    }

    public function addSentence(Sentence $sentence): static
    {
        if (!$this->sentences->contains($sentence)) {
            $this->sentences->add($sentence);
            $sentence->addPictogram($this);
        }

        return $this;
    }

    public function removeSentence(Sentence $sentence): static
    {
        if ($this->sentences->removeElement($sentence)) {
            $sentence->removePictogram($this);
        }

        return $this;
    }
}
