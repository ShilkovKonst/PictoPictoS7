<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\AudioPhraseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioPhraseRepository::class)]
class AudioPhrase
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $audioName = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToOne(inversedBy: 'audioPhrases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Phrase $phrase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAudioName(): ?string
    {
        return $this->audioName;
    }

    public function setAudioName(string $audioName): static
    {
        $this->audioName = $audioName;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getPhrase(): ?Phrase
    {
        return $this->phrase;
    }

    public function setPhrase(?Phrase $phrase): static
    {
        $this->phrase = $phrase;

        return $this;
    }
}
