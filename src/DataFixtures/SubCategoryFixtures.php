<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use App\Repository\CategoryRepository;
use App\Repository\TherapistRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubCategoryFixtures extends Fixture implements DependentFixtureInterface
{
    private ?TherapistRepository $therapistRepo;
    private ?CategoryRepository $catRepo;
    private AppFixtures $fixt;

    public function __construct(
        ?TherapistRepository $therapistRepo = null,
        ?CategoryRepository $catRepo = null,
        AppFixtures $fixt
    ) {
        $this->therapistRepo = $therapistRepo;
        $this->catRepo = $catRepo;
        $this->fixt = $fixt;
    }

    public function load(ObjectManager $manager): void
    {
        $dataSubCat = [
            ['École', 'ecole.png', '2021-06-28 15:27:18', 14, 1],
            ['Maison', 'maison.png', '2021-06-29 10:27:21', 14, 1],
            ['Magasins', 'magasins.png', '2021-07-21 13:43:47', 14, 1],
            ['Famille', 'Famille.png', '2021-07-21 14:09:31', 18, 1],
            ['Objets de la cuisine', 'objetsCuisine.png', '2021-07-26 07:34:30', 17, 1],
            ['Objets de la salle de bain', 'objetsSalleDeBain.png', '2021-07-26 07:46:03', 17, 1],
            ['Lettre A', 'A.png', '2021-07-27 09:25:22', 10, 1],
            ['Lettre C', 'C.png', '2021-07-27 10:03:44', 10, 1],
            ['Lettre D', 'D.png', '2021-07-27 10:04:12', 10, 1],
            ['Lettre E', 'E.png', '2021-07-27 10:04:27', 10, 1],
            ['Lettre L', 'L.png', '2021-07-27 10:04:48', 10, 1],
            ['Lettre M', 'M.png', '2021-07-27 10:05:03', 10, 1],
            ['Lettre N', 'N.png', '2021-07-27 10:05:27', 10, 1],
            ['Lettre S', 'S.png', '2021-07-27 10:05:51', 10, 1],
            ['Lettre T', 'T.png', '2021-07-27 10:06:19', 10, 1],
            ['Lettre U', 'U.png', '2021-07-27 10:06:35', 10, 1],
            ['Lettre V', 'V.png', '2021-07-27 10:06:48', 10, 1],
            ['Magasin', 'magasins.png', '2022-12-09 16:07:40', 14, 25],
            ['École', 'ecole.png', '2022-12-20 18:44:07', 14, 25],
            ['maison', 'magasins.png', '2022-12-20 18:49:44', 14, 25],
            ['Famille', 'famille.png', '2022-12-20 18:50:56', 18, 25],
            ['maison', 'aquarium1.png', '2023-01-06 14:06:40', 14, 25],
            ['bar', 'allerAuxToilettes.png', '2023-01-06 15:21:34', 14, 25]
        ];
        foreach ($dataSubCat as $row) {
            $subCat = new SubCategory();
            $subCat->setName($row[0]);
            $subCat->setFilename($row[1]);
            $subCat->setUpdateAt($this->fixt->formatDateTimeByString($row[2]));

            if ($row[3] == 10) {
                $subCat->setCategoryId($this->catRepo->findOneByName("Petits mots"));
            }
            if ($row[3] == 14) {
                $subCat->setCategoryId($this->catRepo->findOneByName("Lieux"));
            }
            if ($row[3] == 18) {
                $subCat->setCategoryId($this->catRepo->findOneByName("Personnes"));
            }
            if ($row[3] == 17) {
                $subCat->setCategoryId($this->catRepo->findOneByName("Objets"));
            }

            if ($row[4] == 1) {
                $subCat->setTherapist($this->therapistRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
            }
            if ($row[4] == 25) {
                $subCat->setTherapist($this->therapistRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
            }
            
            $manager->persist($subCat);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            InstitutionFixtures::class,
            TherapistFixtures::class,
            CategoryFixtures::class
        ];
    }
}
