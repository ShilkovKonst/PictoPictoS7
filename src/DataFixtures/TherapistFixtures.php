<?php

namespace App\DataFixtures;

use App\Entity\Therapist;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class TherapistFixtures extends Fixture implements DependentFixtureInterface
{    
    private ?UserPasswordHasherInterface $hasher;

    private ?InstitutionRepository $instRepo;

    public function __construct(
        ?UserPasswordHasherInterface $hasher = null,
        ?InstitutionRepository $instRepo = null,
    ) {
        $this->hasher = $hasher;

        $this->instRepo = $instRepo;
    }    

    public function load(ObjectManager $manager): void
    {        
        $output = new ConsoleOutput();
        $dataTherapist = [
            ['rudrauf.tristan@orange.fr', [], '123456789', 'Tristan', 'Rudrauf', 'Dev'],
            ['palvac@gmail.com', [], '123456789', 'Pal', 'Vac', 'Dev'],
            ['m.benkherrat@ecam-epmi.com', ["ROLE_SUPER_ADMIN"], '123456789', 'Moncef', 'Benkherrat', 'SuperAdmin'],
            ['palomavacheron@gmail.com', [], '123456789', 'Paloma', 'Vn', 'Développeuse Web'],
            ['Thérapeute désactivé numéro 17', [], '123456789', 'Thérapeute désactivé numéro 17', 'Thérapeute désactivé numéro 17', 'Dev'],
            ['Thérapeute désactivé numéro 18', [], '123456789', 'Thérapeute désactivé numéro 18', 'Thérapeute désactivé numéro 18', 'Dev'],
            ['Thérapeute désactivé numéro 20', [], '123456789', 'Thérapeute désactivé numéro 20', 'Thérapeute désactivé numéro 20', 'Dev'],
            ['bleuechabani@gmail.com', ["ROLE_SUPER_ADMIN"], '123456789', 'ZARGA', 'CHABANI', 'stagaire']
        ];
        $i=0;
        foreach ($dataTherapist as $row) {
            $therapist = new Therapist();
            $therapist->setEmail($row[0]);
            $therapist->setRoles($row[1]);
            $password = $this->hasher->hashPassword($therapist, $row[2]);
            $therapist->setPassword($password);
            $therapist->setFirstName($row[3]);
            $therapist->setLastName($row[4]);
            $therapist->setJob($row[5]);
            if ($i % 2 == 0) {
                $therapist->setInstitution($this->instRepo->findOneByName("CRP"));
            } else if ($i % 3 == 0) {
                $therapist->setInstitution($this->instRepo->findOneByName("ECAM"));
            } else {
                $therapist->setInstitution($this->instRepo->findOneByName("EntrepriseTest"));
            }           
            
            $manager->persist($therapist);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            InstitutionFixtures::class,
        ];
    }
}
