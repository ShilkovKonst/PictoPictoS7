<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $text;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'questions')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: Phrase::class, mappedBy: 'question')]
    private Collection $phrases;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->phrases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Phrase>
     */
    public function getPhrases(): Collection
    {
        return $this->phrases;
    }

    public function addPhrase(Phrase $phrase): static
    {
        if (!$this->phrases->contains($phrase)) {
            $this->phrases->add($phrase);
            $phrase->setQuestion($this);
        }

        return $this;
    }

    public function removePhrase(Phrase $phrase): static
    {
        if ($this->phrases->removeElement($phrase)) {
            // set the owning side to null (unless already changed)
            if ($phrase->getQuestion() === $this) {
                $phrase->setQuestion(null);
            }
        }

        return $this;
    }
}
