<?php

namespace App\DataFixtures;

use App\Entity\Institution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InstitutionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {        
        $dataInst = [
            ['CRP', '123456789', 'crp@fake.com'],
            ['EntrepriseTest', 'EntrepriseTest123', 'Entreprise@test.com'],
            ['ECAM', 'ecam123456', 'ecam@gmail.com'],
            ['test', '1234567890', 'test@fake.com']
        ];
        foreach ($dataInst as $row) {
            $institution = new Institution();
            $institution->setName($row[0]);
            $institution->setCode($row[1]);
            $institution->setEmail($row[2]);

            $manager->persist($institution);
        }
        $manager->flush();
    }
}
