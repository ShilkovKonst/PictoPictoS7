<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PhraseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhraseRepository::class)]
class Phrase
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'phrases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'phrases')]
    private ?Question $question = null;

    #[ORM\OneToMany(targetEntity: AudioPhrase::class, mappedBy: 'phrase', orphanRemoval: true)]
    private Collection $audioPhrases;

    #[ORM\ManyToMany(targetEntity: Pictogram::class, inversedBy: 'phrases')]
    private Collection $pictograms;

    public function __construct()
    {
        $this->audioPhrases = new ArrayCollection();
        $this->pictograms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, AudioPhrase>
     */
    public function getAudioPhrases(): Collection
    {
        return $this->audioPhrases;
    }

    public function addAudioPhrase(AudioPhrase $audioPhrase): static
    {
        if (!$this->audioPhrases->contains($audioPhrase)) {
            $this->audioPhrases->add($audioPhrase);
            $audioPhrase->setPhrase($this);
        }

        return $this;
    }

    public function removeAudioPhrase(AudioPhrase $audioPhrase): static
    {
        if ($this->audioPhrases->removeElement($audioPhrase)) {
            // set the owning side to null (unless already changed)
            if ($audioPhrase->getPhrase() === $this) {
                $audioPhrase->setPhrase(null);
            }
        }

        return $this;
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
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): static
    {
        $this->pictograms->removeElement($pictogram);

        return $this;
    }
}
