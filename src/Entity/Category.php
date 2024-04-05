<?php

namespace App\Entity;

use App\Entity\Trait\IllustrationFilenameTrait;
use App\Entity\Trait\NameTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use NameTrait;
    use IllustrationFilenameTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subCategories')]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?self $superCategory = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'superCategory', orphanRemoval: true)]
    private Collection $subCategories;

    #[ORM\ManyToMany(targetEntity: Question::class, mappedBy: 'categories')]
    private Collection $questions;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?Therapist $therapist = null;

    #[ORM\OneToMany(targetEntity: Pictogram::class, mappedBy: 'category')]
    private Collection $pictograms;

    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->pictograms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSuperCategory(): ?self
    {
        return $this->superCategory;
    }

    public function setSuperCategory(?self $superCategory): static
    {
        $this->superCategory = $superCategory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(self $subCategory): static
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories->add($subCategory);
            $subCategory->setSuperCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(self $subCategory): static
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getSuperCategory() === $this) {
                $subCategory->setSuperCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->questions->removeElement($question);

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

    /**
     * @return Collection<int, Pictogram>
     */
    public function getPictograms(): Collection
    {
        return $this->pictograms;
    }

    public function addPictogram(Pictogram $pictogram): static
    {
        if (!$this->pictograms->contains($pictogram)) {
            $this->pictograms->add($pictogram);
            $pictogram->setCategory($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): static
    {
        if ($this->pictograms->removeElement($pictogram)) {
            // set the owning side to null (unless already changed)
            if ($pictogram->getCategory() === $this) {
                $pictogram->setCategory(null);
            }
        }

        return $this;
    }
}
