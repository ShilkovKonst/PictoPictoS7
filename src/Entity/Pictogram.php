<?php

namespace App\Entity;

use App\Repository\PictogramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PictogramRepository::class)]
#[Vich\Uploadable()]
class Pictogram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['pictogram'])]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['pictogram'])]
    private ?string $name;

    #[ORM\Column(length: 255)]
    #[Groups(['pictogram'])]
    private ?string $filename;

    #[Assert\Image(mimeTypes: ["image/png"])]
    #[Vich\UploadableField(mapping: "category_image", fileNameProperty: "filename")]
    private ?File $illustration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    #[Groups(['pictogram'])]
    private ?Category $category;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    #[ORM\JoinColumn(nullable: true)]
    private ?SubCategory $subCategory;

    #[ORM\ManyToOne(inversedBy: 'pictograms')]
    private ?Therapist $therapist;

    #[ORM\ManyToMany(targetEntity: Sentence::class, mappedBy: 'pictograms')]
    private Collection $sentences;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $genre;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $pluriel;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $masculin_sing;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $masculin_plur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $feminin_sing;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $feminin_plur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_sing;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_sing;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_sing;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_plur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_plur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_plur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_sing_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_sing_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_sing_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_plur_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_plur_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_plur_futur;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_sing_passe;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_sing_passe;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_sing_passe;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $prem_pers_plur_passe;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $deux_pers_plur_passe;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['pictogram'])]
    private ?string $trois_pers_plur_passe;

    public function __construct()
    {
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
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
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPluriel(): ?string
    {
        return $this->pluriel;
    }

    public function setPluriel(?string $pluriel): self
    {
        $this->pluriel = $pluriel;

        return $this;
    }

    public function getPremPersSing(): ?string
    {
        return $this->prem_pers_sing;
    }

    public function setPremPersSing(?string $prem_pers_sing): self
    {
        $this->prem_pers_sing = $prem_pers_sing;

        return $this;
    }

    public function getDeuxPersSing(): ?string
    {
        return $this->deux_pers_sing;
    }

    public function setDeuxPersSing(?string $deux_pers_sing): self
    {
        $this->deux_pers_sing = $deux_pers_sing;

        return $this;
    }

    public function getTroisPersSing(): ?string
    {
        return $this->trois_pers_sing;
    }

    public function setTroisPersSing(?string $trois_pers_sing): self
    {
        $this->trois_pers_sing = $trois_pers_sing;

        return $this;
    }

    public function getPremPersPlur(): ?string
    {
        return $this->prem_pers_plur;
    }

    public function setPremPersPlur(?string $prem_pers_plur): self
    {
        $this->prem_pers_plur = $prem_pers_plur;

        return $this;
    }

    public function getDeuxPersPlur(): ?string
    {
        return $this->deux_pers_plur;
    }

    public function setDeuxPersPlur(?string $deux_pers_plur): self
    {
        $this->deux_pers_plur = $deux_pers_plur;

        return $this;
    }

    public function getTroisPersPlur(): ?string
    {
        return $this->trois_pers_plur;
    }

    public function setTroisPersPlur(?string $trois_pers_plur): self
    {
        $this->trois_pers_plur = $trois_pers_plur;

        return $this;
    }

    public function getMasculinSing(): ?string
    {
        return $this->masculin_sing;
    }

    public function setMasculinSing(?string $masculin_sing): self
    {
        $this->masculin_sing = $masculin_sing;

        return $this;
    }

    public function getMasculinPlur(): ?string
    {
        return $this->masculin_plur;
    }

    public function setMasculinPlur(?string $masculin_plur): self
    {
        $this->masculin_plur = $masculin_plur;

        return $this;
    }

    public function getFemininSing(): ?string
    {
        return $this->feminin_sing;
    }

    public function setFemininSing(string $feminin_sing): self
    {
        $this->feminin_sing = $feminin_sing;

        return $this;
    }

    public function getFemininPlur(): ?string
    {
        return $this->feminin_plur;
    }

    public function setFemininPlur(?string $feminin_plur): self
    {
        $this->feminin_plur = $feminin_plur;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPremPersSingFutur(): ?string
    {
        return $this->prem_pers_sing_futur;
    }

    public function setPremPersSingFutur(?string $prem_pers_sing_futur): self
    {
        $this->prem_pers_sing_futur = $prem_pers_sing_futur;

        return $this;
    }

    public function getDeuxPersSingFutur(): ?string
    {
        return $this->deux_pers_sing_futur;
    }

    public function setDeuxPersSingFutur(?string $deux_pers_sing_futur): self
    {
        $this->deux_pers_sing_futur = $deux_pers_sing_futur;

        return $this;
    }

    public function getTroisPersSingFutur(): ?string
    {
        return $this->trois_pers_sing_futur;
    }

    public function setTroisPersSingFutur(string $trois_pers_sing_futur): self
    {
        $this->trois_pers_sing_futur = $trois_pers_sing_futur;

        return $this;
    }

    public function getPremPersPlurFutur(): ?string
    {
        return $this->prem_pers_plur_futur;
    }

    public function setPremPersPlurFutur(?string $prem_pers_plur_futur): self
    {
        $this->prem_pers_plur_futur = $prem_pers_plur_futur;

        return $this;
    }

    public function getDeuxPersPlurFutur(): ?string
    {
        return $this->deux_pers_plur_futur;
    }

    public function setDeuxPersPlurFutur(?string $deux_pers_plur_futur): self
    {
        $this->deux_pers_plur_futur = $deux_pers_plur_futur;

        return $this;
    }

    public function getTroisPersPlurFutur(): ?string
    {
        return $this->trois_pers_plur_futur;
    }

    public function setTroisPersPlurFutur(?string $trois_pers_plur_futur): self
    {
        $this->trois_pers_plur_futur = $trois_pers_plur_futur;

        return $this;
    }

    public function getPremPersSingPasse(): ?string
    {
        return $this->prem_pers_sing_passe;
    }

    public function setPremPersSingPasse(?string $prem_pers_sing_passe): self
    {
        $this->prem_pers_sing_passe = $prem_pers_sing_passe;

        return $this;
    }

    public function getDeuxPersSingPasse(): ?string
    {
        return $this->deux_pers_sing_passe;
    }

    public function setDeuxPersSingPasse(?string $deux_pers_sing_passe): self
    {
        $this->deux_pers_sing_passe = $deux_pers_sing_passe;

        return $this;
    }

    public function getTroisPersSingPasse(): ?string
    {
        return $this->trois_pers_sing_passe;
    }

    public function setTroisPersSingPasse(?string $trois_pers_sing_passe): self
    {
        $this->trois_pers_sing_passe = $trois_pers_sing_passe;

        return $this;
    }

    public function getPremPersPlurPasse(): ?string
    {
        return $this->prem_pers_plur_passe;
    }

    public function setPremPersPlurPasse(?string $prem_pers_plur_passe): self
    {
        $this->prem_pers_plur_passe = $prem_pers_plur_passe;

        return $this;
    }

    public function getDeuxPersPlurPasse(): ?string
    {
        return $this->deux_pers_plur_passe;
    }

    public function setDeuxPersPlurPasse(?string $deux_pers_plur_passe): self
    {
        $this->deux_pers_plur_passe = $deux_pers_plur_passe;

        return $this;
    }

    public function getTroisPersPlurPasse(): ?string
    {
        return $this->trois_pers_plur_passe;
    }

    public function setTroisPersPlurPasse(?string $trois_pers_plur_passe): self
    {
        $this->trois_pers_plur_passe = $trois_pers_plur_passe;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getTherapist(): ?Therapist
    {
        return $this->therapist;
    }

    public function setTherapist(?Therapist $therapist):self
    {
        $this->therapist = $therapist;

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
            $sentence->addPictogram($this);
        }

        return $this;
    }

    public function removeSentence(Sentence $sentence):self
    {
        if ($this->sentences->removeElement($sentence)) {
            $sentence->removePictogram($this);
        }

        return $this;
    }
}
