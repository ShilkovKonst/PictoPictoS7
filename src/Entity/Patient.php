<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100)]
    private ?string $firstName;

    #[ORM\Column(length: 100)]
    private ?string $lastName;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate;

    #[ORM\Column(length: 100)]
    private ?string $schoolGrade;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'patient')]
    private Collection $notes;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(targetEntity: Sentence::class, mappedBy: 'patient')]
    private Collection $sentences;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->sentences = new ArrayCollection();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getSchoolGrade(): ?string
    {
        return $this->schoolGrade;
    }

    public function setSchoolGrade(string $schoolGrade): self
    {
        $this->schoolGrade = $schoolGrade;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setPatient($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPatient() === $this) {
                $note->setPatient(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Sentence>
     */
    public function getSentences(): Collection
    {
        return $this->sentences;
    }

    public function addSentence(Sentence $sentence):self
    {
        if (!$this->sentences->contains($sentence)) {
            $this->sentences->add($sentence);
            $sentence->setPatient($this);
        }

        return $this;
    }

    public function removeSentence(Sentence $sentence):self
    {
        if ($this->sentences->removeElement($sentence)) {
            // set the owning side to null (unless already changed)
            if ($sentence->getPatient() === $this) {
                $sentence->setPatient(null);
            }
        }

        return $this;
    }
}
