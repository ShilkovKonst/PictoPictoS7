<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
#[Vich\Uploadable()]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['pictogram', 'subcategory'])]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['pictogram', 'subcategory'])]
    private ?string $name;

    #[ORM\Column(length: 255)]
    #[Groups(['pictogram', 'subcategory'])]
    private ?string $filename;

    #[Assert\Image(mimeTypes: 'image/png')]
    #[Vich\UploadableField(mapping: 'category_image', fileNameProperty: 'filename')]
    private ?File $subillustration;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $update_at;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['pictogram', 'subcategory'])]
    private ?Category $category_id;

    #[ORM\OneToMany(targetEntity: Pictogram::class, mappedBy: 'subcategory_id')]
    private Collection $pictograms_id;

    #[ORM\ManyToOne(inversedBy: 'subCategories')]
    private ?Therapist $therapist = null;

    public function __construct()
    {
        $this->pictograms_id = new ArrayCollection();
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

    public function getSubillustration(): ?File
    {
        return $this->subillustration;
    }

    public function setSubillustration(File $subillustration): self
    {
        $this->subillustration = $subillustration;

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

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * @return Collection<int, Pictogram>
     */
    public function getPictogramsId(): Collection
    {
        return $this->pictograms_id;
    }

    public function addPictogramsId(Pictogram $pictogramsId): self
    {
        if (!$this->pictograms_id->contains($pictogramsId)) {
            $this->pictograms_id->add($pictogramsId);
            $pictogramsId->setSubcategoryId($this);
        }

        return $this;
    }

    public function removePictogramsId(Pictogram $pictogramsId): self
    {
        if ($this->pictograms_id->removeElement($pictogramsId)) {
            // set the owning side to null (unless already changed)
            if ($pictogramsId->getSubcategoryId() === $this) {
                $pictogramsId->setSubcategoryId(null);
            }
        }

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
}
