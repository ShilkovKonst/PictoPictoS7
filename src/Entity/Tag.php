<?php

namespace App\Entity;

use App\Entity\Trait\TitleTrait;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    use TitleTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Pictogram::class, mappedBy: 'tags')]
    private Collection $pictograms;

    public function __construct()
    {
        $this->pictograms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $pictogram->addTag($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): static
    {
        if ($this->pictograms->removeElement($pictogram)) {
            $pictogram->removeTag($this);
        }

        return $this;
    }
}
