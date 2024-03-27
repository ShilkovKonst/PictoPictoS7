<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    private ?TherapistRepository $therapistRepo;
    private AppFixtures $fixt;

    public function __construct(
        ?TherapistRepository $therapistRepo = null,
        AppFixtures $fixt
    ) {
        $this->therapistRepo = $therapistRepo;
        $this->fixt = $fixt;
    }

    public function load(ObjectManager $manager): void
    {
        $dataCategory = [
            ['Sujets', 'sujets.png', '2021-03-14 15:38:40'],
            ['Boissons', 'boissons.png', '2021-03-15 09:32:15'],
            ['Actions', 'actions.png', '2021-03-15 13:29:34'],
            ['Adjectifs', 'adjectifs.png', '2021-03-15 13:31:46'],
            ['Aliments', 'aliments.png', '2021-03-15 13:33:16'],
            ['Animaux', 'animaux.png', '2021-03-15 13:35:30'],
            ['Chiffres', 'chiffres.png', '2021-03-15 13:37:28'],
            ['Corps humain', 'corpsHumain.png', '2021-03-15 13:39:00'],
            ['Couleurs', 'couleurs.png', '2021-03-15 13:40:02'],
            ['Petits mots', 'determinants.png', '2021-03-15 13:41:46'],
            ['Émotions', 'emotions.png', '2021-03-15 13:44:12'],
            ['Fruits et légumes', 'fruitsEtLegumes.png', '2021-03-15 13:53:03'],
            ['Langues Des Signes', 'langueDesSignes.png', '2021-03-15 13:54:22'],
            ['Lieux', 'lieux.png', '2021-03-15 13:55:46'],
            ['Météo', 'meteo.png', '2021-03-15 13:57:23'],
            ['Multimédia', 'multimedia.png', '2021-03-15 13:58:40'],
            ['Objets', 'objets.png', '2021-03-15 14:00:05'],
            ['Personnes', 'personnes.png', '2021-03-15 14:01:55'],
            ['Scolarité', 'scolarite.png', '2021-03-15 14:03:29'],
            ['Transports', 'transports.png', '2021-03-15 14:05:23'],
            ['Vêtements', 'vetements.png', '2021-03-15 14:06:49'],
            ['Comportements', 'comportements.png', '2021-03-23 15:25:19'],
            ['Orientation', 'orientation.png', '2021-04-27 00:00:00'],
            ['Autres Mots', 'autresMots.png', '2021-04-27 00:04:00'],
            ['Formes', 'formes.png', '2021-05-16 03:00:00'],
            ['Sports', 'sports.png', '2022-04-16 10:07:57'],
            ['Sécurité Routière', 'securiteRoutiere.png', '2021-07-20 14:25:49'],
            ['Jouet', 'jouet.png', '2022-05-03 14:48:06'],
            ['Interrogatif', 'interrogatif.png', '2022-11-10 12:03:02'],
            ['Journee', 'Journee.png', '2022-11-10 12:05:14'],
            ['Heures', 'heures.png', '2022-11-11 10:38:35'],
            ['Couverts', 'couverts.png', '2022-11-22 14:54:44']
        ];
        $i = 0;
        foreach ($dataCategory as $row) {
            $category = new Category();
            $category->setName($row[0]);
            $category->setFilename($row[1]);
            $category->setUpdateAt($this->fixt->formatDateTimeByString($row[2]));
            if ($i % 4 == 0) {
                $category->setTherapist($this->therapistRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
            } else if ($i % 3 == 0) {
                $category->setTherapist($this->therapistRepo->findOneByEmail("palvac@gmail.com"));
            } else if ($i % 2 == 0) {
                $category->setTherapist($this->therapistRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
            } else {
                $category->setTherapist($this->therapistRepo->findOneByEmail("palomavacheron@gmail.com"));
            }             
            
            $manager->persist($category);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            InstitutionFixtures::class,
            TherapistFixtures::class
        ];
    }
}
