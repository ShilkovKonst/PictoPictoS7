<?php

namespace App\Entity\Trait;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

trait IllustrationFilenameTrait
{

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[Assert\Image(mimeTypes: ["image/png", "image/gif"])]
    #[Vich\UploadableField(mapping: "category_image", fileNameProperty: "filename")]
    private ?File $illustration = null;    

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
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
            $this->updatedAt = new \DateTimeImmutable('now');
        }

        return $this;
    }

}
