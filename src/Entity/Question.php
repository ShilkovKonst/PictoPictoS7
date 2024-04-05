<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $text;

    // #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'questions')]
    // private Collection $category;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'questions')]
    private Collection $categories;

    public function __construct()
    {
        // $this->category = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    // /**
    //  * @return Collection<int, Category>
    //  */
    // public function getCategory(): Collection
    // {
    //     return $this->category;
    // }

    // public function addCategory(Category $category): self
    // {
    //     if (!$this->category->contains($category)) {
    //         $this->category->add($category);
    //     }

    //     return $this;
    // }

    // public function removeCategory(Category $category): self
    // {
    //     $this->category->removeElement($category);

    //     return $this;
    // }

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
}
