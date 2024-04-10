<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PatientRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    #[ORM\Column(length: 10)]
    private ?string $sex = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birthDate = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $therapist = null;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'patient')]
    private Collection $notes;

    #[ORM\OneToMany(targetEntity: Phrase::class, mappedBy: 'patient')]
    private Collection $phrases;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->phrases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getTherapist(): ?User
    {
        return $this->therapist;
    }

    public function setTherapist(?User $therapist): static
    {
        $this->therapist = $therapist;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setPatient($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPatient() === $this) {
                $note->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Phrase>
     */
    public function getPhrases(): Collection
    {
        return $this->phrases;
    }

    public function addPhrase(Phrase $phrase): static
    {
        if (!$this->phrases->contains($phrase)) {
            $this->phrases->add($phrase);
            $phrase->setPatient($this);
        }

        return $this;
    }

    public function removePhrase(Phrase $phrase): static
    {
        if ($this->phrases->removeElement($phrase)) {
            // set the owning side to null (unless already changed)
            if ($phrase->getPatient() === $this) {
                $phrase->setPatient(null);
            }
        }

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode($code): static
    {
        $this->code = strtolower($code);

        return $this;
    }
}
