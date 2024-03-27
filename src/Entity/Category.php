<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Vich\Uploadable()]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category', 'pictogram', 'subcategory'])]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['category', 'pictogram', 'subcategory'])]
    private ?string $name;

    #[ORM\Column(length: 255)]
    #[Groups(['category', 'pictogram', 'subcategory'])]
    private ?string $filename;

    #[Assert\Image(mimeTypes: ["image/png"])]
    #[Vich\UploadableField(mapping: "category_image", fileNameProperty: "filename")]
    private ?File $illustration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $update_at;

    #[ORM\OneToMany(targetEntity: Pictogram::class, mappedBy: 'category')]
    private Collection $pictograms;

    #[ORM\OneToMany(targetEntity: SubCategory::class, mappedBy: 'category_id', orphanRemoval: true)]
    private Collection $subCategories;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Therapist $therapist;

    #[ORM\ManyToMany(targetEntity: Question::class, mappedBy: 'category')]
    private Collection $questions;

    public function __construct()
    {
        $this->pictograms = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
        $this->questions = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getIllustration(): ?File
    {
        return $this->illustration;
    }

    public function setIllustration(File $illustration): self
    {
        $this->illustration = $illustration;
        if ($this->illustration instanceof UploadedFile) {
            $this->update_at = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     * @return Collection<int, Pictogram>
     */
    public function getPictograms(): Collection
    {
        return $this->pictograms;
    }

    public function addPictogram(Pictogram $pictogram):self
    {
        if (!$this->pictograms->contains($pictogram)) {
            $this->pictograms->add($pictogram);
            $pictogram->setCategory($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram):self
    {
        if ($this->pictograms->removeElement($pictogram)) {
            // set the owning side to null (unless already changed)
            if ($pictogram->getCategory() === $this) {
                $pictogram->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory):self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories->add($subCategory);
            $subCategory->setCategoryId($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory):self
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategoryId() === $this) {
                $subCategory->setCategoryId(null);
            }
        }

        return $this;
    }

    public function getTherapist(): ?Therapist
    {
        return $this->therapist;
    }

    public function setTherapist(?Therapist $therapist):self
    {
        $this->therapist = $therapist;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question):self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->addCategory($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question):self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeCategory($this);
        }

        return $this;
    }
}
