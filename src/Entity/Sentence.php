<?php

namespace App\Entity;

use App\Repository\SentenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SentenceRepository::class)]
class Sentence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["sentence:read"])]
    private ?string $audio;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'sentences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient;

    // #[ORM\ManyToMany(targetEntity: Pictogram::class, inversedBy: 'sentences')]
    // private Collection $pictograms;

    #[ORM\OneToMany(targetEntity: Pictogram::class, mappedBy: 'sentences')]
    private Collection $pictograms;

    public function __construct()
    {
        // $this->pictograms = new ArrayCollection();
        $this->pictograms = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreated()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
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

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    // /**
    //  * @return Collection<int, Pictogram>
    //  */
    // public function getPictograms(): Collection
    // {
    //     return $this->pictograms;
    // }

    // public function addPictogram(Pictogram $pictogram): self
    // {
    //     if (!$this->pictograms->contains($pictogram)) {
    //         $this->pictograms->add($pictogram);
    //     }

    //     return $this;
    // }

    // public function removePictogram(Pictogram $pictogram): self
    // {
    //     $this->pictograms->removeElement($pictogram);

    //     return $this;
    // }

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
            $pictogram->setSentences($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): static
    {
        if ($this->pictograms->removeElement($pictogram)) {
            // set the owning side to null (unless already changed)
            if ($pictogram->getSentences() === $this) {
                $pictogram->setSentences(null);
            }
        }

        return $this;
    }
}
