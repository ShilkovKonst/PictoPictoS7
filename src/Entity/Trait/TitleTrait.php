<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TitleTrait
{
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
