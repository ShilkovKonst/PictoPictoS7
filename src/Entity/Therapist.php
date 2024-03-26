<?php

namespace App\Entity;

use App\Repository\TherapistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: TherapistRepository::class)]
class Therapist implements PasswordAuthenticatedUserInterface 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\OneToMany(targetEntity: Pictogram::class, mappedBy: 'therapist')]
    private Collection $pictograms;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'therapist')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: SubCategory::class, mappedBy: 'therapist')]
    private Collection $subCategories;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'therapist')]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'therapist')]
    private ?Institution $institution;


    #[ORM\Column(length: 100)]
    private ?string $firstName;

    #[ORM\Column(length: 100)]
    private ?string $lastName;

    #[ORM\Column(length: 100)]
    private ?string $email;

    #[ORM\Column(length: 50)]
    private ?string $password;

    #[ORM\Column(length: 100)]
    private ?string $job;

    #[ORM\Column]
    private array $roles = [];
    
    public function __construct()
    {
        $this->pictograms = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
        $this->notes = new ArrayCollection();
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

    /**
     * @return Collection<int, Pictogram>
     */
    public function getPictograms(): Collection
    {
        return $this->pictograms;
    }

    public function addPictogram(Pictogram $pictogram): self
    {
        if (!$this->pictograms->contains($pictogram)) {
            $this->pictograms->add($pictogram);
            $pictogram->setTherapist($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): self
    {
        if ($this->pictograms->removeElement($pictogram)) {
            // set the owning side to null (unless already changed)
            if ($pictogram->getTherapist() === $this) {
                $pictogram->setTherapist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setTherapist($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getTherapist() === $this) {
                $category->setTherapist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories->add($subCategory);
            $subCategory->setTherapist($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): self
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getTherapist() === $this) {
                $subCategory->setTherapist(null);
            }
        }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

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
            $note->setTherapist($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getTherapist() === $this) {
                $note->setTherapist(null);
            }
        }

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }
}
