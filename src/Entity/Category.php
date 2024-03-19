<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
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

    #[ORM\Column()]
    #[Assert\Image(mimeTypes: "image/png")]
    #[Vich\UploadableField(mapping: "category_image", fileNameProperty: "filename")]
    private File $illustration;

    #[ORM\Column]
    private ?\DateTime $update_at;

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
}
