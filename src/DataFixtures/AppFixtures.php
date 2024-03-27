<?php

namespace App\DataFixtures;
use App\Entity\Therapist;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures
{
    // private ?UserPasswordHasherInterface $hasher;

    // private ?InstitutionRepository $instRepo;
    // private ?TherapistRepository $therapistRepo;
    // private ?CategoryRepository $catRepo;
    // private ?SubCategoryRepository $subCatRepo;

    public function __construct(
        // ?UserPasswordHasherInterface $hasher = null,
        // ?InstitutionRepository $instRepo = null,
        // ?TherapistRepository $therapistRepo = null,
        // ?CategoryRepository $catRepo = null,
        // ?SubCategoryRepository $subCatRepo = null
    ) {
        // $this->hasher = $hasher;

        // $this->instRepo = $instRepo;
        // $this->therapistRepo = $therapistRepo;
        // $this->catRepo = $catRepo;
        // $this->subCatRepo = $subCatRepo;
    }

    public function formatDateTimeByString(string $string): DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $string);
    }    
}
