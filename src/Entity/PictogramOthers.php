<?php

namespace App\Entity;

use App\Repository\PictogramOthersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictogramOthersRepository::class)]
class PictogramOthers extends Pictogram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
