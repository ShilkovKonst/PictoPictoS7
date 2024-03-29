<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Institution;
use App\Entity\Note;
use App\Entity\Patient;
use App\Entity\Pictogram;
use App\Entity\Question;
use App\Entity\Sentence;
use App\Entity\SubCategory;
use App\Entity\Therapist;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    private InstitutionRepository $iRepo;
    private TherapistRepository $thRepo;
    private CategoryRepository $cRepo;
    private SubCategoryRepository $scRepo;
    private PatientRepository $patRepo;
    private PictogramRepository $pictRepo;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        InstitutionRepository $iRepo,
        TherapistRepository $thRepo,
        CategoryRepository $cRepo,
        SubCategoryRepository $scRepo,
        PatientRepository $patRepo,
        PictogramRepository $pictRepo
    ) {
        $this->hasher = $hasher;

        $this->iRepo = $iRepo;
        $this->thRepo = $thRepo;
        $this->cRepo = $cRepo;
        $this->scRepo = $scRepo;
        $this->patRepo = $patRepo;
        $this->pictRepo = $pictRepo;
    }

    public function load(ObjectManager $manager): void
    {
        $this->populateInstitution($manager);
        $manager->flush();

        $this->populateTherapist($manager);
        $manager->flush();

        $this->populateCategory($manager);
        $manager->flush();

        $this->populateSubCategory($manager);
        $manager->flush();

        $this->populatePictogram($manager);
        $manager->flush();

        $this->populateQuestion($manager);
        $manager->flush();

        $this->populatePatient($manager);
        $manager->flush();

        $this->populateNote($manager);
        $manager->flush();

        $this->populateSentence($manager);
        $manager->flush();
    }

    private function formatDateTimeByString(string $string): DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $string);
    }

    private function formatDateTimeImmutableByString(string $string): DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $string);
    }

    private function formatBirthDateByString(string $string): DateTime
    {
        return \DateTime::createFromFormat('Y-m-d', $string);
    }

    private function populateInstitution(ObjectManager $manager)
    {
        $data = [
            ['CRP', '123456789', 'crp@fake.com'],
            ['EntrepriseTest', 'EntrepriseTest123', 'Entreprise@test.com'],
            ['ECAM', 'ecam123456', 'ecam@gmail.com'],
            ['test', '1234567890', 'test@fake.com']
        ];
        foreach ($data as $row) {
            $institution = new Institution();
            $institution->setName($row[0]);
            $institution->setCode($row[1]);
            $institution->setEmail($row[2]);

            $manager->persist($institution);
        }
    }

    private function populateTherapist(ObjectManager $manager)
    {
        $data = [
            ['rudrauf.tristan@orange.fr', [], '123456789', 'Tristan', 'Rudrauf', 'Dev'],
            ['palvac@gmail.com', [], '123456789', 'Pal', 'Vac', 'Dev'],
            ['m.benkherrat@ecam-epmi.com', ["ROLE_SUPER_ADMIN"], '123456789', 'Moncef', 'Benkherrat', 'SuperAdmin'],
            ['palomavacheron@gmail.com', [], '123456789', 'Paloma', 'Vn', 'Développeuse Web'],
            ['Thérapeute désactivé numéro 17', [], '123456789', 'Thérapeute désactivé numéro 17', 'Thérapeute désactivé numéro 17', 'Dev'],
            ['Thérapeute désactivé numéro 18', [], '123456789', 'Thérapeute désactivé numéro 18', 'Thérapeute désactivé numéro 18', 'Dev'],
            ['Thérapeute désactivé numéro 20', [], '123456789', 'Thérapeute désactivé numéro 20', 'Thérapeute désactivé numéro 20', 'Dev'],
            ['bleuechabani@gmail.com', ["ROLE_SUPER_ADMIN"], '123456789', 'ZARGA', 'CHABANI', 'stagaire']
        ];
        $i = 0;
        foreach ($data as $row) {
            $therapist = new Therapist();
            $therapist->setEmail($row[0]);
            $therapist->setRoles($row[1]);
            $password = $this->hasher->hashPassword($therapist, $row[2]);
            $therapist->setPassword($password);
            $therapist->setFirstName($row[3]);
            $therapist->setLastName($row[4]);
            $therapist->setJob($row[5]);
            if ($i % 2 == 0) {
                $therapist->setInstitution($this->iRepo->findOneByName("CRP"));
            } else if ($i % 3 == 0) {
                $therapist->setInstitution($this->iRepo->findOneByName("ECAM"));
            } else {
                $therapist->setInstitution($this->iRepo->findOneByName("EntrepriseTest"));
            }

            $manager->persist($therapist);
            $i++;
        }
    }

    private function populateCategory(ObjectManager $manager)
    {
        $data = [
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
        foreach ($data as $row) {
            $category = new Category();
            $category->setName($row[0]);
            $category->setFilename($row[1]);
            $category->setUpdateAt($this->formatDateTimeByString($row[2]));
            if ($i % 4 == 0) {
                $category->setTherapist($this->thRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
            } else if ($i % 3 == 0) {
                $category->setTherapist($this->thRepo->findOneByEmail("palvac@gmail.com"));
            } else if ($i % 2 == 0) {
                $category->setTherapist($this->thRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
            } else {
                $category->setTherapist($this->thRepo->findOneByEmail("palomavacheron@gmail.com"));
            }

            $manager->persist($category);
            $i++;
        }
    }

    private function populateSubCategory(ObjectManager $manager)
    {
        $data = [
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
        foreach ($data as $row) {
            $subCat = new SubCategory();
            $subCat->setName($row[0]);
            $subCat->setFilename($row[1]);
            $subCat->setUpdateAt($this->formatDateTimeByString($row[2]));

            if ($row[3] == 10) {
                $subCat->setCategoryId($this->cRepo->findOneByName("Petits mots"));
            }
            if ($row[3] == 14) {
                $subCat->setCategoryId($this->cRepo->findOneByName("Lieux"));
            }
            if ($row[3] == 18) {
                $subCat->setCategoryId($this->cRepo->findOneByName("Personnes"));
            }
            if ($row[3] == 17) {
                $subCat->setCategoryId($this->cRepo->findOneByName("Objets"));
            }

            if ($row[4] == 1) {
                $subCat->setTherapist($this->thRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
            }
            if ($row[4] == 25) {
                $subCat->setTherapist($this->thRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
            }

            $manager->persist($subCat);
        }
    }

    private function populatePictogram(ObjectManager $manager)
    {
        $data = [
            ['Je', 'je.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 13:07:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tu', 'tu.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:30:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Il', 'il.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:34:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vous', 'vous.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:38:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nous', 'nous.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:40:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Elle', 'elle.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:42:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Eau', 'eau.png', 'féminin', 'eaux', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eau', 'eaux', 2, '2021-03-15 14:45:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chocolat chaud', 'chocolatChaud.png', 'masculin', 'chocolats chauds', NULL, NULL, NULL, NULL, NULL, NULL, 'chocolat chaud', 'chocolats chauds', NULL, NULL, 2, '2021-03-15 14:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jus d\'orange', 'jusDOrange.png', 'masculin', 'jus d\'orange', NULL, NULL, NULL, NULL, NULL, NULL, 'jus d\'orange', 'jus d\'orange', NULL, NULL, 2, '2021-03-15 14:51:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Soda', 'soda.png', 'masculin', 'sodas', NULL, NULL, NULL, NULL, NULL, NULL, 'soda', 'sodas', NULL, NULL, 2, '2021-03-15 14:52:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jus de pomme', 'jusDePomme.png', 'masculin', 'jus de pomme', NULL, NULL, NULL, NULL, NULL, NULL, 'Jus de pomme', 'Jus de pomme', NULL, NULL, 2, '2021-03-15 14:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vouloir', 'vouloir.png', NULL, NULL, 'veux', 'veux', 'veut', 'voulons', 'voulez', 'veulent', NULL, NULL, NULL, NULL, 3, '2021-03-15 14:59:48', NULL, NULL, 'voudrai', 'voudras', 'voudra', 'voudrons', 'voudrez', 'voudront', 'ai voulu', 'as voulu', 'a voulu', 'avons voulu', 'avez voulu', 'ont voulu'],
            ['Regarder', 'regarder.png', NULL, NULL, 'regarde', 'regardes', 'regarde', 'regardons', 'regardez', 'regardent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:04:19', NULL, NULL, 'regarderai', 'regarderas', 'regardera', 'regarderons', 'regarderez', 'regarderont', 'ai regardé', 'as regardé', 'a regardé', 'avons regardé', 'avez regardé', 'ont regardé'],
            ['Boire', 'boire.png', NULL, NULL, 'bois', 'bois', 'boit', 'buvons', 'buvez', 'boivent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:13:11', NULL, NULL, 'boirai', 'boiras', 'boira', 'boirons', 'boirez', 'boiront', 'ai bu', 'as bu', 'a bu', 'avons bu', 'avez bu', 'ont bu'],
            ['Manger', 'manger.png', NULL, NULL, 'mange', 'manges', 'mange', 'mangeons', 'mangez', 'mangent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:15:28', NULL, NULL, 'mangerai', 'mangeras', 'mangera', 'mangerons', 'mangerez', 'mangeront', 'ai mangé', 'as mangé', 'a mangé', 'avons mangé', 'avez mangé', 'ont mangé'],
            ['Aller', 'aller.png', NULL, NULL, 'vais', 'vas', 'va', 'allons', 'allez', 'vont', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:18:29', NULL, NULL, 'irai', 'iras', 'ira', 'irons', 'irez', 'iront', 'suis allé', 'es allé', 'est allé', 'sommes allés', 'êtes allés', 'sont allés'],
            ['Court', 'court.png', 'masculin', 'courts', NULL, NULL, NULL, NULL, NULL, NULL, 'court', 'courts', 'courte', 'courtes', 4, '2021-03-15 15:21:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Petit', 'petit.png', 'masculin', 'petits', NULL, NULL, NULL, NULL, NULL, NULL, 'petit', 'petits', 'petite', 'petites', 4, '2021-03-15 15:24:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Grand', 'grand.png', 'masculin', 'grands', NULL, NULL, NULL, NULL, NULL, NULL, 'grand', 'grands', 'grande', 'grandes', 4, '2021-03-15 15:27:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Long', 'long.png', 'masculin', 'longs', NULL, NULL, NULL, NULL, NULL, NULL, 'long', 'longs', 'longue', 'longues', 4, '2021-03-15 15:29:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Correct', 'correct.png', 'masculin', 'corrects', NULL, NULL, NULL, NULL, NULL, NULL, 'correct', 'corrects', 'correcte', 'correctes', 4, '2021-03-15 15:33:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Incorrect', 'incorrect.png', 'masculin', 'incorrects', NULL, NULL, NULL, NULL, NULL, NULL, 'incorrect', 'incorrects', 'incorrecte', 'incorrectes', 4, '2021-03-15 15:35:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Céréales', 'cereales.png', 'féminin', 'céréales', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'céréale', 'céréales', 5, '2021-03-15 15:39:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dessert', 'dessert.png', 'masculin', 'desserts', NULL, NULL, NULL, NULL, NULL, NULL, 'dessert', 'desserts', NULL, NULL, 5, '2021-03-15 15:41:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gâteau', 'gateaux.png', 'masculin', 'gâteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'gâteau', 'gâteaux', NULL, NULL, 5, '2021-03-15 15:44:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Glace', 'glace.png', 'féminin', 'glaces', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'glace', 'glaces', 5, '2021-03-15 15:45:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Riz', 'riz.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'riz', 'riz', NULL, NULL, 5, '2021-03-15 15:47:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chat', 'chat.png', 'masculin', 'chats', NULL, NULL, NULL, NULL, NULL, NULL, 'chat', 'chats', 'chatte', 'chattes', 6, '2021-03-15 18:06:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chien', 'chien.png', 'masculin', 'chiens', NULL, NULL, NULL, NULL, NULL, NULL, 'chien', 'chiens', 'chienne', 'chiennes', 6, '2021-03-15 18:08:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lapin', 'lapin.png', 'masculin', 'lapins', NULL, NULL, NULL, NULL, NULL, NULL, 'lapin', 'lapins', 'lapine', 'lapines', 6, '2022-11-23 10:22:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Oiseau', 'oiseau.png', 'masculin', 'oiseaux', NULL, NULL, NULL, NULL, NULL, NULL, 'oiseau', 'oiseaux', 'oiselle', 'oiselles', 6, '2021-03-15 18:18:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poisson', 'poissons.png', 'masculin', 'poissons', NULL, NULL, NULL, NULL, NULL, NULL, 'poisson', 'poissons', NULL, NULL, 6, '2021-03-15 18:22:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Un', 'un.png', 'masculin', 'uns', NULL, NULL, NULL, NULL, NULL, NULL, 'un', 'uns', 'une', 'unes', 7, '2021-03-15 18:36:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux', 'deux.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'deux', NULL, NULL, NULL, 7, '2021-03-15 18:41:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Zéro', 'zero.png', 'masculin', 'zéros', NULL, NULL, NULL, NULL, NULL, NULL, 'zéro', 'zéros', NULL, NULL, 7, '2021-03-15 18:44:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois', 'trois.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trois', NULL, NULL, NULL, 7, '2021-03-15 18:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre', 'quatre.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'quatre', NULL, NULL, NULL, 7, '2021-03-15 18:52:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bouche', 'bouche.png', 'féminin', 'bouches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bouche', 'bouches', 8, '2021-03-15 19:16:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mains', 'mains.png', 'féminin', 'mains', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'main', 'mains', 8, '2021-03-15 19:22:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nez', 'nez.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nez', 'nez', NULL, NULL, 8, '2021-03-15 19:26:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pieds', 'pieds.png', 'masculin', 'pieds', NULL, NULL, NULL, NULL, NULL, NULL, 'pied', 'pieds', NULL, NULL, 8, '2021-03-15 19:27:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Oreille', 'oreille.png', 'féminin', 'oreilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'oreille', 'oreilles', 8, '2021-03-15 19:30:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Blanc', 'blanc.png', 'masculin', 'blancs', NULL, NULL, NULL, NULL, NULL, NULL, 'blanc', 'blancs', 'blanche', 'blanches', 9, '2021-03-15 21:24:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bleu', 'bleu.png', 'masculin', 'bleus', NULL, NULL, NULL, NULL, NULL, NULL, 'bleu', 'bleus', 'bleue', 'bleues', 9, '2021-03-15 21:27:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Rouge', 'rouge.png', 'masculin', 'rouges', NULL, NULL, NULL, NULL, NULL, NULL, 'rouge', 'rouges', 'rouge', 'rouges', 9, '2021-03-15 21:30:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vert', 'vert.png', 'masculin', 'verts', NULL, NULL, NULL, NULL, NULL, NULL, 'vert', 'verts', 'verte', 'vertes', 9, '2021-03-15 21:33:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Rose', 'rose.png', 'masculin', 'roses', NULL, NULL, NULL, NULL, NULL, NULL, 'rose', 'roses', 'rose', 'roses', 9, '2021-03-15 21:36:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['De', 'de.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:47:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Des', 'des.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:48:13', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Et', 'et.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:50:00', NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mon', 'mon.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:51:31', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ce', 'ce.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:52:59', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Colère', 'colere.png', 'féminin', 'colères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'colère', 'colères', 11, '2021-03-15 21:56:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Curieux', 'curieux.png', 'masculin', 'curieux', NULL, NULL, NULL, NULL, NULL, NULL, 'curieux', 'curieux', 'curieuse', 'curieuses', 11, '2021-03-15 21:59:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Inquiet', 'inquiet.png', 'masculin', 'inquiets', NULL, NULL, NULL, NULL, NULL, NULL, 'inquiet', 'inquiets', 'inquiète', 'inquiètes', 11, '2021-03-15 22:03:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Joyeux', 'joyeux.png', 'masculin', 'joyeux', NULL, NULL, NULL, NULL, NULL, NULL, 'joyeux', 'joyeux', 'joyeuse', 'joyeuses', 11, '2021-03-15 22:06:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Peur', 'peur.png', 'féminin', 'peurs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'peur', 'peurs', 11, '2021-03-15 22:09:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Banane', 'banane.png', 'féminin', 'bananes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'banane', 'bananes', 12, '2021-03-15 22:12:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Carotte', 'carotte.png', 'féminin', 'carottes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carotte', 'carottes', 12, '2021-03-15 22:15:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fraise', 'fraise.png', 'féminin', 'fraises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fraise', 'fraises', 12, '2021-03-15 22:18:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Orange', 'orange.png', 'féminin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'orange', 'oranges', 12, '2021-03-15 22:20:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pomme de terre', 'pommeDeTerre.png', 'féminin', 'pommes de terre', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pomme de terre', 'pommes de terre', 12, '2021-03-15 22:22:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cuisine', 'cuisine.png', 'féminin', 'cuisines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cuisine', 'cuisines', NULL, '2021-03-16 08:36:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['École', 'ecole.png', 'féminin', 'écoles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'école', 'écoles', NULL, '2021-03-16 08:38:41', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Hôpital', 'hopital.png', 'masculin', 'hôpitaux', NULL, NULL, NULL, NULL, NULL, NULL, 'hôpital', 'hôpitaux', NULL, NULL, 14, '2021-03-16 08:40:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Salle de bain', 'salleDeBain.png', 'féminin', 'salles de bains', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'salle de bain', 'salles de bains', NULL, '2021-03-16 08:42:14', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gare', 'gare.png', 'féminin', 'gares', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gare', 'gares', 14, '2021-03-16 08:43:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Soleil', 'soleil.png', 'masculin', 'soleils', NULL, NULL, NULL, NULL, NULL, NULL, 'soleil', 'soleils', NULL, NULL, 15, '2021-03-16 08:45:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Venteux', 'venteux.png', 'masculin', 'venteux', NULL, NULL, NULL, NULL, NULL, NULL, 'venteux', 'venteux', 'venteuse', 'venteuses', 15, '2021-03-16 08:48:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nuage', 'nuage.png', 'masculin', 'nuages', NULL, NULL, NULL, NULL, NULL, NULL, 'nuage', 'nuages', NULL, NULL, 15, '2021-03-16 08:49:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pluvieux', 'pluvieux.png', 'masculin', 'pluvieux', NULL, NULL, NULL, NULL, NULL, NULL, 'pluvieux', 'pluvieux', 'pluvieuse', 'pluvieuses', 15, '2021-03-16 08:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gelée', 'gelee.png', 'féminin', 'gelée', NULL, NULL, NULL, NULL, NULL, NULL, 'gelé', 'gelés', 'gelée', 'gelées', 15, '2021-03-16 08:53:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Téléphone portable', 'telephonePortable.png', 'masculin', 'téléphones portable', NULL, NULL, NULL, NULL, NULL, NULL, 'téléphone portable', 'téléphones portables', NULL, NULL, 16, '2021-03-16 08:55:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Télévision', 'television.png', 'féminin', 'télévisions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'télévision', 'télévisions', 16, '2021-03-16 08:57:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ordinateur', 'ordinateur.png', 'masculin', 'ordinateurs', NULL, NULL, NULL, NULL, NULL, NULL, 'ordinateur', 'ordinateurs', NULL, NULL, 16, '2021-03-16 08:58:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ordinateur portable', 'ordinateurPortable.png', 'masculin', 'ordinateurs portables', NULL, NULL, NULL, NULL, NULL, NULL, 'ordinateur portable', 'ordinateurs portables', NULL, NULL, 16, '2021-03-16 08:59:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Console', 'console.png', 'féminin', 'consoles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'console', 'consoles', 16, '2021-03-16 09:00:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bande dessinée', 'bandeDessinee.png', 'féminin', 'bandes dessinées', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bande dessinée', 'bandes dessinées', 17, '2021-03-16 09:16:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Brosse à dents', 'brosseADents.png', 'féminin', 'brosses à dents', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'brosse à dents', 'brosses à dents', NULL, '2021-03-16 09:18:04', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Couteau', 'couteau.png', 'masculin', 'couteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'couteau', 'couteaux', NULL, NULL, NULL, '2021-03-16 09:19:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cuillère', 'cuillere.png', 'féminin', 'cuillères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cuillère', 'cuillères', NULL, '2021-03-16 09:20:34', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fourchette', 'fourchette.png', 'féminin', 'fourchettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fourchette', 'fourchettes', NULL, '2021-03-16 09:22:43', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Table', 'table.png', 'féminin', 'tables', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'table', 'tables', 17, '2021-03-16 09:24:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Médecin', 'medecin.png', 'masculin', 'médecins', NULL, NULL, NULL, NULL, NULL, NULL, 'médecin', 'médecins', 'médecin', 'médecins', 18, '2021-03-16 09:26:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Grand-mère', 'grandMere.png', 'féminin', 'grands-mères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'grand-mère', 'grand-mères', NULL, '2021-03-16 09:30:38', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Orthophoniste', 'orthophoniste.png', 'masculin', 'orthophonistes', NULL, NULL, NULL, NULL, NULL, NULL, 'orthophoniste', 'orthophonistes', 'orthophoniste', 'orthophonistes', 18, '2021-03-16 09:33:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Professeur', 'professeur.png', 'masculin', 'professeurs', NULL, NULL, NULL, NULL, NULL, NULL, 'professeur', 'professeurs', 'professeure', 'professeures', 18, '2021-03-16 09:36:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Papa', 'papa.png', 'masculin', 'papas', NULL, NULL, NULL, NULL, NULL, NULL, 'papa', 'papas', NULL, NULL, NULL, '2021-03-16 09:37:41', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cahier', 'cahier.png', 'masculin', 'cahiers', NULL, NULL, NULL, NULL, NULL, NULL, 'cahier', 'cahiers', NULL, NULL, 19, '2021-03-16 09:39:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Crayon', 'crayon.png', 'masculin', 'crayons', NULL, NULL, NULL, NULL, NULL, NULL, 'crayon', 'crayons', NULL, NULL, 19, '2021-03-16 09:40:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gomme', 'gomme.png', 'féminin', 'gommes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gomme', 'gommes', 19, '2021-03-16 09:42:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Règle', 'regle.png', 'féminin', 'règles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'règle', 'règles', 19, '2021-03-16 09:43:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Stylo', 'stylo.png', 'masculin', 'stylos', NULL, NULL, NULL, NULL, NULL, NULL, 'stylo', 'stylos', NULL, NULL, 19, '2021-03-16 09:44:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ambulance', 'ambulance.png', 'féminin', 'ambulances', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ambulance', 'ambulances', 20, '2021-03-16 09:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Avion', 'avion.png', 'masculin', 'avions', NULL, NULL, NULL, NULL, NULL, NULL, 'avion', 'avions', NULL, NULL, 20, '2021-03-16 09:47:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Métro', 'metro.png', 'masculin', 'métros', NULL, NULL, NULL, NULL, NULL, NULL, 'métro', 'métros', NULL, NULL, 20, '2021-03-16 09:48:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Taxi', 'taxi.png', 'masculin', 'taxis', NULL, NULL, NULL, NULL, NULL, NULL, 'taxi', 'taxis', NULL, NULL, 20, '2021-03-16 09:49:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Train', 'train.png', 'masculin', 'trains', NULL, NULL, NULL, NULL, NULL, NULL, 'train', 'trains', NULL, NULL, 20, '2021-03-16 09:51:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chaussettes', 'chaussettes.png', 'féminin', 'chaussettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaussette', 'chaussettes', 21, '2021-03-16 09:53:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chaussures', 'chaussures.png', 'féminin', 'chaussures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaussure', 'chaussures', 21, '2021-03-16 09:54:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Manteau', 'manteau.png', 'masculin', 'manteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'manteau', 'manteaux', NULL, NULL, 21, '2021-03-16 09:55:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pantalon', 'pantalon.png', 'masculin', 'pantalons', NULL, NULL, NULL, NULL, NULL, NULL, 'pantalon', 'pantalons', NULL, NULL, 21, '2021-03-16 09:57:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tee-shirt', 'teeShirt.png', 'masculin', 'tee-shirts', NULL, NULL, NULL, NULL, NULL, NULL, 'tee-shirt', 'tee-shirts', NULL, NULL, 21, '2021-03-16 10:00:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Avoir', 'avoir.png', NULL, NULL, 'ai', 'as', 'a', 'avons', 'avez', 'ont', NULL, NULL, NULL, NULL, 3, '2021-03-17 12:17:07', NULL, NULL, 'aurai', 'auras', 'aura', 'aurons', 'aurez', 'auront', 'ai eu', 'as eu', 'a eu', 'avons eu', 'avez eu', 'ont eu'],
            ['Eux', 'eux.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-18 13:07:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Moi', 'moi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-18 13:08:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Café', 'cafe.png', 'masculin', 'cafés', NULL, NULL, NULL, NULL, NULL, NULL, 'café', 'cafés', NULL, NULL, 2, '2021-03-18 14:45:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Eau du robinet', 'eauDuRobinet.png', 'féminin', 'eaux du robinet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eau du robinet', 'eaux du robinet', 2, '2021-03-18 14:46:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jus de raisin', 'jusDeRaisin.png', 'masculin', 'jus de raisin', NULL, NULL, NULL, NULL, NULL, NULL, 'jus de raisin', 'jus de raisin', NULL, NULL, 2, '2021-03-18 14:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lait', 'lait.png', 'masculin', 'laits', NULL, NULL, NULL, NULL, NULL, NULL, 'lait', 'laits', NULL, NULL, 2, '2021-03-18 14:55:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Limonade', 'limonade.png', 'féminin', 'limonades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'limonade', 'limonades', 2, '2021-03-18 14:56:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Aller aux toilettes', 'allerAuxToilettes.png', NULL, NULL, 'vais aux toilettes', 'vas aux toilettes', 'va aux toilettes', 'allons aux toilettes', 'allez aux toilettes', 'vont aux toilettes', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:18:29', NULL, NULL, 'irai aux toilettes', 'iras aux toilettes', 'ira aux toilettes', 'irons aux toilettes', 'irez aux toilettes', 'iront aux toilettes', 'suis allé aux toilettes', 'es allé aux toilettes', 'est allé aux toilettes', 'sommes allés aux toilettes', 'êtes allés aux toilettes', 'sont allés aux toilettes'],
            ['Couper', 'couper.png', NULL, NULL, 'coupe', 'coupes', 'coupe', 'coupons', 'coupez', 'coupent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:24:19', NULL, NULL, 'couperai', 'couperas', 'coupera', 'couperons', 'couperez', 'couperont', 'ai coupé', 'as coupé', 'a coupé', 'avons coupé', 'avez coupé', 'ont coupé'],
            ['Courir', 'courir.png', NULL, NULL, 'cours', 'cours', 'court', 'courons', 'courez', 'courent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:25:19', NULL, NULL, 'courrai', 'courras', 'courra', 'courrons', 'courrez', 'courront', 'ai couru', 'as couru', 'a couru', 'avons couru', 'avez couru', 'ont couru'],
            ['Descendre', 'descendre.png', NULL, NULL, 'descends', 'descends', 'descend', 'descendons', 'descendez', 'descendent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:26:19', NULL, NULL, 'descendrai', 'descendras', 'descendra', 'descendrons', 'descendrez', 'descendront', 'ai descendu', 'as descendu', 'a descendu', 'avons descendu', 'avez descendu', 'ont descendu'],
            ['Dessiner', 'dessiner.png', NULL, NULL, 'dessine', 'dessines', 'dessine', 'dessinons', 'dessinez', 'dessinent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:27:19', NULL, NULL, 'dessinerai', 'dessineras', 'dessinera', 'dessinerons', 'dessinerez', 'dessineront', 'ai dessiné', 'as dessiné', 'a dessiné', 'avons dessiné', 'avez dessiné', 'ont dessiné'],
            ['Écouter', 'ecouter.png', NULL, NULL, 'écoute', 'écoutes', 'écoute', 'écoutons', 'écoutez', 'écoutent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:28:19', NULL, NULL, 'écouterai', 'écouteras', 'écoutera', 'écouterons', 'écouterez', 'écouteront', 'ai écouté', 'as écouté', 'a écouté', 'avons écouté', 'avez écouté', 'ont écouté'],
            ['Écrire', 'ecrire.gif', NULL, NULL, 'écris', 'écris', 'écrit', 'écrivons', 'écrivez', 'écrivent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:29:19', NULL, NULL, 'écrirai', 'écriras', 'écrira', 'écrirons', 'écrirez', 'écriront', 'ai écrit', 'as écrit', 'a écrit', 'avons écrit', 'avez écrit', 'ont écrit'],
            ['Être', 'etre.png', NULL, NULL, 'suis', 'es', 'est', 'sommes', 'êtes', 'sont', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:30:19', NULL, NULL, 'serai', 'seras', 'sera', 'serons', 'serez', 'seront', 'ai été', 'as été', 'a été', 'avons été', 'avez été', 'ont été'],
            ['Jouer', 'jouer.png', NULL, NULL, 'joue', 'joues', 'joue', 'jouons', 'jouez', 'jouent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:31:19', NULL, NULL, 'jouerai', 'joueras', 'jouera', 'jouerons', 'jouerez', 'joueront', 'ai joué', 'as joué', 'a joué', 'avons joué', 'avez joué', 'ont joué'],
            ['Laver le linge', 'laverLeLinge.png', NULL, NULL, 'lave le linge', 'laves le linge', 'lave le linge', 'lavons le linge', 'lavez le linge', 'lavent le linge', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:32:19', NULL, NULL, 'laverai le linge', 'laveras le linge', 'lavera le linge', 'laverons le linge', 'laverez le linge', 'laveront le linge', 'ai lavé le linge', 'as lavé le linge', 'a lavé le linge', 'avons lavé le linge', 'avez lavé le linge', 'ont lavé le linge'],
            ['Laver les dents', 'laverLesDents.png', NULL, NULL, 'lave les dents', 'laves les dents', 'lave les dents', 'lavons les dents', 'lavez les dents', 'lavent les dents', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:33:19', NULL, NULL, 'laverai les dents', 'laveras les dents', 'lavera les dents', 'laverons les dents', 'laverez les dents', 'laveront les dents', 'ai lavé les dents', 'as lavé les dents', 'a lavé les dents', 'avons lavé les dents', 'avez lavé les dents', 'ont lavé les dents'],
            ['Laver', 'laver.png', NULL, NULL, 'lave', 'laves', 'lave', 'lavons', 'lavez', 'lavent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:34:19', NULL, NULL, 'laverai', 'laverai', 'lavera', 'laverons', 'laverez', 'laveront', 'ai lavé', 'as lavé', 'a lavé', 'avons lavé', 'avez lavé', 'ont lavé'],
            ['Lire', 'lire.png', NULL, NULL, 'lis', 'lis', 'lit', 'lisons', 'lisez', 'lisent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:35:19', NULL, NULL, 'lirai', 'liras', 'lira', 'lirons', 'lirez', 'liront', 'ai lu', 'as lu', 'a lu', 'avons lu', 'avez lu', 'ont lu'],
            ['Monter', 'monter.png', NULL, NULL, 'monte', 'montes', 'monte', 'montons', 'montez', 'montent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:36:19', NULL, NULL, 'monterai', 'monteras', 'montera', 'monterons', 'monterez', 'monteront', 'ai monté', 'as monté', 'a monté', 'avons monté', 'avez monté', 'ont monté'],
            ['Se moucher', 'moucher.png', NULL, NULL, 'me mouche', 'te mouches', 'se mouche', 'nous mouchons', 'vous mouchez', 'se mouchent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:37:19', NULL, NULL, 'me moucherai', 'te moucheras', 'se mouchera', 'nous moucherons', 'vous moucherez', 'se moucheront', 'me suis mouché', 't\'es mouché', 's\'est mouché', 'nous sommes mouchés', 'vous êtes mouchés', 'se sont mouchés'],
            ['Nager', 'nager.png', NULL, NULL, 'nage', 'nages', 'nage', 'nageons', 'nagez', 'nagent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:38:19', NULL, NULL, 'nagerai', 'nageras', 'nagera', 'nagerons', 'nagerez', 'nageront', 'ai nagé', 'as nagé', 'a nagé', 'avons nagé', 'avez nagé', 'ont nagé'],
            ['Prendre un bain', 'prendreUnBain.png', NULL, NULL, 'prends un bain', 'prends un bain', 'prend un bain', 'prenons un bain', 'prenez un bain', 'prennent un bain', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:39:19', NULL, NULL, 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'ai pris un bain', 'as pris un bain', 'a pris un bain', 'avons pris un bain', 'avez pris un bain', 'ont pris un bain'],
            ['Regarder la télévision', 'regarderLaTelevision.png', NULL, NULL, 'regarde la télévision', 'regardes la télévision', 'regarde la télévision', 'regardons la télévision', 'regardez la télévision', 'regardent la télévision', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:40:19', NULL, NULL, 'regarderai la télévision', 'regarderas la télévision', 'regardera la télévision', 'regarderons la télévision', 'regarderez la télévision', 'regarderont la télévision', 'ai regardé la télévision', 'as regardé la télévision', 'a regardé la télévision', 'avons regardé la télévision', 'avez regardé la télévision', 'ont regardé la télévision'],
            ['Remplir', 'remplir.png', NULL, NULL, 'remplis', 'remplis', 'remplit', 'remplissons', 'remplissez', 'remplissent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:41:19', NULL, NULL, 'remplirai', 'rempliras', 'remplira', 'remplirons', 'remplirez', 'rempliront', 'ai rempli', 'as rempli', 'a rempli', 'avons rempli', 'avez rempli', 'ont rempli'],
            ['Renverser', 'renverser.png', NULL, NULL, 'renverse', 'renverses', 'renverse', 'renversons', 'renversez', 'renversent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:42:19', NULL, NULL, 'renverserai', 'renverseras', 'renversera', 'renverserons', 'renverserez', 'renverseront', 'ai renversé', 'as renversé', 'a renversé', 'avons renversé', 'avez renversé', 'ont renversé'],
            ['S\'habiller', 'sHabiller.png', NULL, NULL, 'm\'habille', 't\'habilles', 's\'habille', 'nous habillons', 'vous habillez', 's\'habillent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:43:19', NULL, NULL, 'm\'habillerai', 't\'habilleras', 's\'habillera', 'nous habillerons', 'vous habillerez', 's\'habilleront', 'me suis habillé', 't\'es habillé', 's\'est habillé', 'nous sommes habillés', 'vous êtes habillés', 'se sont habillés'],
            ['Salir', 'salir.png', NULL, NULL, 'salis', 'salis', 'salit', 'salissons', 'salissez', 'salissent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:44:19', NULL, NULL, 'salirai', 'saliras', 'salira', 'salirons', 'salirez', 'saliront', 'ai sali', 'as sali', 'a sali', 'avons sali', 'avez sali', 'ont sali'],
            ['Se déshabiller', 'seDeshabiller.png', NULL, NULL, 'me déshabille', 'te déshabilles', 'se déshabille', 'nous déshabillons', 'vous déshabillez', 'se déshabillent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:45:19', NULL, NULL, 'me déshabillerai', 'te déshabilleras', 'se déshabillera', 'nous déshabillerons', 'vous déshabillerez', 'se déshabilleront', 'me suis déshabillé', 't\'es déshabillé', 's\'est déshabillé', 'nous sommes déshabillés', 'vous êtes déshabillés', 'se sont déshabillés'],
            ['Siffler', 'siffler.png', NULL, NULL, 'siffle', 'siffles', 'siffle', 'sifflons', 'sifflez', 'sifflent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:46:19', NULL, NULL, 'sifflerai', 'siffleras', 'sifflera', 'sifflerons', 'sifflerez', 'siffleront', 'ai sifflé', 'as sifflé', 'a sifflé', 'avons sifflé', 'avez sifflé', 'ont sifflé'],
            ['Téléphoner', 'telephoner.png', NULL, NULL, 'téléphone', 'téléphones', 'téléphone', 'téléphonons', 'téléphonez', 'téléphonent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:47:19', NULL, NULL, 'téléphonerai', 'téléphoneras', 'téléphonera', 'téléphonerons', 'téléphonerez', 'téléphoneront', 'ai téléphoné', 'as téléphoné', 'a téléphoné', 'avons téléphoné', 'avez téléphoné', 'ont téléphoné'],
            ['Accompagnée', 'accompagnee.png', 'féminin', 'accompagnées', NULL, NULL, NULL, NULL, NULL, NULL, 'accompagné', 'accompagnés', 'accompagnée', 'accompagnées', 4, '2021-03-19 15:21:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cassé', 'casse.png', 'masculin', 'cassés', NULL, NULL, NULL, NULL, NULL, NULL, 'cassé', 'cassés', 'cassée', 'cassées', 4, '2021-03-19 15:22:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Coiffée', 'coiffee.png', 'féminin', 'coiffées', NULL, NULL, NULL, NULL, NULL, NULL, 'coiffé', 'coiffés', 'coiffée', 'coiffées', 4, '2021-03-19 15:23:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Décoiffé', 'décoiffe.png', 'masculin', 'décoiffés', NULL, NULL, NULL, NULL, NULL, NULL, 'décoiffé', 'décoiffés', 'décoiffée', 'décoiffées', 4, '2021-03-19 15:24:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dernier', 'dernier.png', 'masculin', 'derniers', NULL, NULL, NULL, NULL, NULL, NULL, 'dernier', 'derniers', 'dernière', 'dernières', 4, '2021-03-19 15:25:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deuxième', 'deuxieme.png', 'masculin', 'deuxièmes', NULL, NULL, NULL, NULL, NULL, NULL, 'deuxième', 'deuxièmes', 'deuxième', 'deuxièmes', 4, '2021-03-19 15:26:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Étroit', 'etroit.png', 'masculin', 'étroits', NULL, NULL, NULL, NULL, NULL, NULL, 'étroit', 'étroits', 'étroite', 'étroites', 4, '2021-03-19 15:27:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fermé', 'ferme.png', 'masculin', 'fermés', NULL, NULL, NULL, NULL, NULL, NULL, 'fermé', 'fermés', 'fermée', 'fermées', 4, '2021-03-19 15:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gros', 'gros.png', 'masculin', 'gros', NULL, NULL, NULL, NULL, NULL, NULL, 'gros', 'gros', 'grosse', 'grosses', 4, '2021-03-19 15:29:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Large', 'large.png', 'masculin', 'larges', NULL, NULL, NULL, NULL, NULL, NULL, 'large', 'larges', 'large', 'larges', 4, '2021-03-19 15:30:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lent', 'lent.png', 'masculin', 'lents', NULL, NULL, NULL, NULL, NULL, NULL, 'lent', 'lents', 'lente', 'lentes', 4, '2021-03-19 15:31:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mince', 'mince.png', 'masculin', 'minces', NULL, NULL, NULL, NULL, NULL, NULL, 'mince', 'minces', 'mince', 'minces', 4, '2021-03-19 15:32:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mouillé', 'mouille.png', 'masculin', 'mouillés', NULL, NULL, NULL, NULL, NULL, NULL, 'mouillé', 'mouillés', 'mouillée', 'mouillées', 4, '2021-03-19 15:33:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ouvert', 'ouvert.png', 'masculin', 'ouverts', NULL, NULL, NULL, NULL, NULL, NULL, 'ouvert', 'ouverts', 'ouverte', 'ouvertes', 4, '2021-03-19 15:34:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Premier', 'premier.png', 'masculin', 'premiers', NULL, NULL, NULL, NULL, NULL, NULL, 'premier', 'premiers', 'première', 'premières', 4, '2021-03-19 15:35:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sec', 'sec.png', 'masculin', 'secs', NULL, NULL, NULL, NULL, NULL, NULL, 'sec', 'secs', 'sèche', 'sèches', 4, '2021-03-19 15:36:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Seul', 'seul.png', 'masculin', 'seuls', NULL, NULL, NULL, NULL, NULL, NULL, 'seul', 'seuls', 'seule', 'seules', 4, '2021-03-19 15:37:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vide', 'vide.png', 'masculin', 'vides', NULL, NULL, NULL, NULL, NULL, NULL, 'vide', 'vides', 'vide', 'vides', 4, '2021-03-19 15:38:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Beurre', 'beurre.png', 'masculin', 'beurres', NULL, NULL, NULL, NULL, NULL, NULL, 'beurre', 'beurres', NULL, NULL, 5, '2021-03-19 15:45:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chocolat', 'chocolat.png', 'masculin', 'chocolats', NULL, NULL, NULL, NULL, NULL, NULL, 'chocolat', 'chocolats', NULL, NULL, 5, '2021-03-19 15:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Confiture', 'confiture.png', 'féminin', 'confitures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'confiture', 'confitures', 5, '2021-03-19 15:49:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pâtes', 'pates.png', 'féminin', 'pâtes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pâtes', 5, '2021-03-19 15:50:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Farine', 'farine.png', 'féminin', 'farines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'farine', 'farines', 5, '2021-03-19 15:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Flan', 'flan.png', 'masculin', 'flans', NULL, NULL, NULL, NULL, NULL, NULL, 'flan', 'flans', NULL, NULL, 5, '2021-03-19 15:52:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fromage', 'fromage.png', 'masculin', 'fromages', NULL, NULL, NULL, NULL, NULL, NULL, 'fromage', 'fromages', NULL, NULL, 5, '2021-03-19 15:53:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jambon', 'jambon.png', 'masculin', 'jambons', NULL, NULL, NULL, NULL, NULL, NULL, 'jambon', 'jambons', NULL, NULL, 5, '2021-03-19 15:54:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Miel', 'miel.png', 'masculin', 'miels', NULL, NULL, NULL, NULL, NULL, NULL, 'miel', 'miels', NULL, NULL, 5, '2021-03-19 15:55:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Moutarde', 'moutarde.png', 'féminin', 'moutardes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moutarde', 'moutardes', 5, '2021-03-19 15:56:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Oeufs', 'oeufs.png', 'masculin', 'oeufs', NULL, NULL, NULL, NULL, NULL, NULL, 'oeuf', 'oeufs', NULL, NULL, 5, '2021-03-19 15:57:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pain', 'pain.png', 'masculin', 'pains', NULL, NULL, NULL, NULL, NULL, NULL, 'pain', 'pains', NULL, NULL, 5, '2021-03-19 15:58:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Petit pot', 'petitPot.png', 'masculin', 'petits pots', NULL, NULL, NULL, NULL, NULL, NULL, 'petit pot', 'petits pots', NULL, NULL, 5, '2021-03-19 15:59:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poisson', 'poisson.png', 'masculin', 'poisson', NULL, NULL, NULL, NULL, NULL, NULL, 'poisson', 'poissons', NULL, NULL, 5, '2021-03-20 14:39:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poivre', 'poivre.png', 'masculin', 'poivres', NULL, NULL, NULL, NULL, NULL, NULL, 'poivre', 'poivres', NULL, NULL, 5, '2021-03-20 14:40:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poulet', 'poulet.png', 'masculin', 'poulets', NULL, NULL, NULL, NULL, NULL, NULL, 'poulet', 'poulets', NULL, NULL, 5, '2021-03-20 14:41:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sandwich', 'sandwich.png', 'masculin', 'sandwichs', NULL, NULL, NULL, NULL, NULL, NULL, 'sandwich', 'sandwichs', NULL, NULL, 5, '2021-03-20 14:42:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ketchup', 'ketchup.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ketchup', NULL, NULL, NULL, 5, '2021-03-20 14:43:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sel', 'sel.png', 'masculin', 'sels', NULL, NULL, NULL, NULL, NULL, NULL, 'sel', 'sels', NULL, NULL, 5, '2021-03-20 14:44:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sucette', 'sucette.png', 'féminin', 'sucettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sucette', 'sucettes', 5, '2021-03-20 14:46:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Viande', 'viande.png', 'féminin', 'viandes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'viande', 'viandes', 5, '2021-03-20 14:47:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Yaourt', 'yaourt.png', 'masculin', 'yaourts', NULL, NULL, NULL, NULL, NULL, NULL, 'yaourt', 'yaourts', NULL, NULL, 5, '2021-03-20 14:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Canard', 'canard.png', 'masculin', 'canards', NULL, NULL, NULL, NULL, NULL, NULL, 'canard', 'canards', NULL, NULL, 6, '2021-03-20 18:08:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cheval', 'cheval.png', 'masculin', 'chevaux', NULL, NULL, NULL, NULL, NULL, NULL, 'cheval', 'chevaux', NULL, NULL, 6, '2021-03-20 18:09:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cochon', 'cochon.png', 'masculin', 'cochons', NULL, NULL, NULL, NULL, NULL, NULL, 'cochon', 'cochons', 'cochonne', 'cochonnes', 6, '2021-03-20 18:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Crocodile', 'crocodile.png', 'masculin', 'crocodiles', NULL, NULL, NULL, NULL, NULL, NULL, 'crocodile', 'crocodiles', NULL, NULL, 6, '2021-03-20 18:11:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dauphin', 'dauphin.png', 'masculin', 'dauphins', NULL, NULL, NULL, NULL, NULL, NULL, 'dauphin', 'dauphins', NULL, NULL, 6, '2021-03-20 18:12:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dinosaure', 'dinosaure.png', 'masculin', 'dinosaures', NULL, NULL, NULL, NULL, NULL, NULL, 'dinosaure', 'dinosaures', NULL, NULL, 6, '2021-03-20 18:13:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Éléphant', 'elephant.png', 'masculin', 'éléphants', NULL, NULL, NULL, NULL, NULL, NULL, 'éléphant', 'éléphants', 'éléphante', 'éléphantes', 6, '2021-03-20 18:14:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Escargot', 'escargot.png', 'masculin', 'escargots', NULL, NULL, NULL, NULL, NULL, NULL, 'escargot', 'escargots', NULL, NULL, 6, '2021-03-20 18:15:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Grenouille', 'grenouille.png', 'féminin', 'grenouilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'grenouille', 'grenouilles', 6, '2021-03-20 18:16:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Hamster', 'hamster.png', 'masculin', 'hamsters', NULL, NULL, NULL, NULL, NULL, NULL, 'hamster', 'hamsters', NULL, NULL, 6, '2021-03-20 18:17:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lion', 'lion.png', 'masculin', 'lions', NULL, NULL, NULL, NULL, NULL, NULL, 'lion', 'lions', 'lionne', 'lionnes', 6, '2021-03-20 18:18:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mouton', 'mouton.png', 'masculin', 'moutons', NULL, NULL, NULL, NULL, NULL, NULL, 'mouton', 'moutons', NULL, NULL, 6, '2021-03-20 18:19:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Oie', 'oie.png', 'féminin', 'oies', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'oie', 'oies', 6, '2021-03-20 18:20:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Papillon', 'papillon.png', 'masculin', 'papillons', NULL, NULL, NULL, NULL, NULL, NULL, 'papillon', 'papillons', NULL, NULL, 6, '2021-03-20 18:21:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Perruche', 'perruche.png', 'féminin', 'perruches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'perruche', 'perruches', 6, '2021-03-20 18:22:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poule', 'poule.png', 'féminin', 'poules', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poule', 'poules', 6, '2021-03-20 18:23:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Singe', 'singe.png', 'masculin', 'singes', NULL, NULL, NULL, NULL, NULL, NULL, 'singe', 'singes', NULL, NULL, 6, '2021-03-20 18:24:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Souris', 'souris.png', 'féminin', 'souris', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'souris', 'souris', 6, '2021-03-20 18:25:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tortue', 'tortue.png', 'féminin', 'tortues', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tortue', 'tortues', 6, '2021-03-20 18:26:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vache', 'vache.png', 'féminin', 'vaches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vache', 'vaches', 6, '2021-03-20 18:27:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq', 'cinq.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cinq', NULL, NULL, NULL, 7, '2021-03-20 18:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six', 'six.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'six', NULL, NULL, NULL, 7, '2021-03-20 18:47:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept', 'sept.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sept', NULL, NULL, NULL, 7, '2021-03-20 18:48:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit', 'huit.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'huit', NULL, NULL, NULL, 7, '2021-03-20 18:49:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Neuf', 'neuf.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'neuf', NULL, NULL, NULL, 7, '2021-03-20 18:50:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dix', 'dix.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dix', NULL, NULL, NULL, 7, '2021-03-20 18:51:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bras', 'bras.png', 'masculin', 'bras', NULL, NULL, NULL, NULL, NULL, NULL, 'bras', 'bras', NULL, NULL, 8, '2021-03-20 19:16:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cheveux', 'cheveux.png', 'masculin', 'cheveux', NULL, NULL, NULL, NULL, NULL, NULL, 'cheveu', 'cheveux', NULL, NULL, 8, '2021-03-20 19:17:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cou', 'cou.png', 'masculin', 'cous', NULL, NULL, NULL, NULL, NULL, NULL, 'cou', 'cous', NULL, NULL, 8, '2021-03-20 19:18:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dent', 'dents.png', 'féminin', 'dents', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dents', 'dents', 8, '2021-03-20 19:19:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Orteils', 'orteils.png', 'masculin', 'orteils', NULL, NULL, NULL, NULL, NULL, NULL, 'orteil', 'orteils', NULL, NULL, 8, '2021-03-20 19:20:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Doigts', 'doigts.png', 'masculin', 'doigts', NULL, NULL, NULL, NULL, NULL, NULL, 'doigt', 'doigts', NULL, NULL, 8, '2021-03-20 19:21:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dos', 'dos.png', 'masculin', 'dos', NULL, NULL, NULL, NULL, NULL, NULL, 'dos', 'dos', NULL, NULL, 8, '2021-03-20 19:22:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fesses', 'fesses.png', 'féminin', 'fesses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fesse', 'fesses', 8, '2021-03-20 19:23:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jambe', 'jambe.png', 'féminin', 'jambes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jambe', 'jambes', 8, '2021-03-20 19:24:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Langue', 'langue.png', 'féminin', 'langues', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'langue', 'langues', 8, '2021-03-20 19:25:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nombril', 'nombril.png', 'masculin', 'nombrils', NULL, NULL, NULL, NULL, NULL, NULL, 'nombril', 'nombrils', NULL, NULL, 8, '2021-03-20 19:26:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nuque', 'nuque.png', 'féminin', 'nuques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nuque', 'nuques', 8, '2021-03-20 19:27:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poitrine', 'poitrine.png', 'féminin', 'poitrines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poitrine', 'poitrines', 8, '2021-03-20 19:28:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tête', 'tete.png', 'féminin', 'têtes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tête', 'têtes', 8, '2021-03-20 19:29:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ventre', 'ventre.png', 'masculin', 'ventres', NULL, NULL, NULL, NULL, NULL, NULL, 'ventre', 'ventres', NULL, NULL, 8, '2021-03-20 19:30:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Yeux', 'yeux.png', 'masculin', 'yeux', NULL, NULL, NULL, NULL, NULL, NULL, 'oeil', 'yeux', NULL, NULL, 8, '2021-03-20 19:31:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gris', 'gris.png', 'masculin', 'gris', NULL, NULL, NULL, NULL, NULL, NULL, 'gris', 'gris', 'grise', 'grises', 9, '2021-03-20 21:24:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jaune', 'jaune.png', 'masculin', 'jaunes', NULL, NULL, NULL, NULL, NULL, NULL, 'jaune', 'jaunes', 'jaune', 'jaunes', 9, '2021-03-20 21:25:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Marron', 'marron.png', 'masculin', 'marrons', NULL, NULL, NULL, NULL, NULL, NULL, 'marron', 'marrons', 'marronne', 'marronnes', 9, '2021-03-20 21:26:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Noir', 'noir.png', 'masculin', 'noirs', NULL, NULL, NULL, NULL, NULL, NULL, 'noir', 'noirs', 'noire', 'noires', 9, '2021-03-20 21:27:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['À la', 'aLa.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:47:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['À', 'a.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:48:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ces', 'ces.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:49:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cet', 'cet.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:50:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cette', 'cette.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:51:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Leur', 'leur.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:52:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Leurs', 'leurs.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:53:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ma', 'ma.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:54:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mes', 'mes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:55:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mon', 'mon.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:56:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nos', 'nos.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:57:06', NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Notre', 'notre.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:58:06', NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sa', 'sa.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:59:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ses', 'ses.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:00:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Son', 'son.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:01:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ta', 'ta.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:02:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tes', 'tes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:03:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vos', 'vos.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:04:06', NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Votre', 'votre.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:05:06', NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Amoureux', 'amoureux.png', 'masculin', 'amoureux', NULL, NULL, NULL, NULL, NULL, NULL, 'amoureux', 'amoureux', 'amoureuse', 'amoureuses', 11, '2021-03-20 22:20:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Confus', 'confus.png', 'masculin', 'confus', NULL, NULL, NULL, NULL, NULL, NULL, 'confus', 'confus', 'confuse', 'confuses', 11, '2021-03-20 22:21:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Content', 'content.png', 'masculin', 'contents', NULL, NULL, NULL, NULL, NULL, NULL, 'content', 'contents', 'contente', 'contentes', 11, '2021-03-20 22:22:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Distrait', 'distrait.png', 'masculin', 'distraits', NULL, NULL, NULL, NULL, NULL, NULL, 'distrait', 'distraits', 'distraite', 'distraites', 11, '2021-03-20 22:23:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ennuyeux', 'ennuyeux.png', 'masculin', 'ennuyeux', NULL, NULL, NULL, NULL, NULL, NULL, 'ennuyeux', 'ennuyeux', 'ennuyeuse', 'ennuyeuses', 11, '2021-03-20 22:24:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fatigué', 'fatigue.png', 'masculin', 'fatigués', NULL, NULL, NULL, NULL, NULL, NULL, 'fatigué', 'fatigués', 'fatiguée', 'fatiguées', 11, '2021-03-20 22:25:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Honte', 'honte.png', 'féminin', 'hontes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'honte', 'hontes', 11, '2021-03-20 22:26:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Surpris', 'surpris.png', 'masculin', 'surpris', NULL, NULL, NULL, NULL, NULL, NULL, 'surpris', 'surpris', 'surprise', 'surprises', 11, '2021-03-20 22:27:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Timide', 'timide.png', 'masculin', 'timides', NULL, NULL, NULL, NULL, NULL, NULL, 'timide', 'timides', 'timide', 'timides', 11, '2021-03-20 22:28:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Triste', 'triste.png', 'masculin', 'tristes', NULL, NULL, NULL, NULL, NULL, NULL, 'triste', 'tristes', 'triste', 'tristes', 11, '2021-03-20 22:29:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ananas', 'ananas.png', 'masculin', 'ananas', NULL, NULL, NULL, NULL, NULL, NULL, 'ananas', 'ananas', NULL, NULL, 12, '2021-03-20 22:32:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Aubergine', 'aubergine.png', 'féminin', 'aubergines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aubergine', 'aubergines', 12, '2021-03-20 22:33:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Brocoli', 'brocoli.png', 'masculin', 'brocolis', NULL, NULL, NULL, NULL, NULL, NULL, 'brocoli', 'brocolis', NULL, NULL, 12, '2021-03-20 22:34:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cerise', 'cerise.png', 'féminin', 'cerises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cerise', 'cerises', 12, '2021-03-20 22:35:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chou-fleur', 'chouFleur.png', 'masculin', 'choux-fleurs', NULL, NULL, NULL, NULL, NULL, NULL, 'chou-fleur', 'choux-fleurs', NULL, NULL, 12, '2021-03-20 22:36:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Citron', 'citron.png', 'masculin', 'citrons', NULL, NULL, NULL, NULL, NULL, NULL, 'citron', 'citrons', NULL, NULL, 12, '2021-03-20 22:37:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cornichon', 'cornichon.png', 'masculin', 'cornichons', NULL, NULL, NULL, NULL, NULL, NULL, 'cornichon', 'cornichons', NULL, NULL, 12, '2021-03-20 22:38:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Framboise', 'framboises.png', 'féminin', 'framboises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'framboise', 'framboises', 12, '2021-03-20 22:39:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Haricots verts', 'haricotsVerts.png', 'masculin', 'haricots verts', NULL, NULL, NULL, NULL, NULL, NULL, 'haricot vert', 'haricots verts', NULL, NULL, 12, '2021-03-20 22:40:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Maïs', 'mais.png', 'masculin', 'maïs', NULL, NULL, NULL, NULL, NULL, NULL, 'maïs', 'maïs', NULL, NULL, 12, '2021-03-20 22:41:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Myrtille', 'myrtilles.png', 'féminin', 'myrtilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'myrtille', 'myrtilles', 12, '2021-03-20 22:42:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Noix de coco', 'noixDeCoco.png', 'féminin', 'noix de coco', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'noix de coco', 'noix de coco', 12, '2021-03-20 22:43:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Noix', 'noix.png', 'féminin', 'noix', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'noix', 'noix', 12, '2021-03-20 22:44:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Oignon', 'oignon.png', 'masculin', 'oignons', NULL, NULL, NULL, NULL, NULL, NULL, 'oignon', 'oignons', NULL, NULL, 12, '2021-03-20 22:45:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Olive', 'olives.png', 'féminin', 'olives', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'olive', 'olives', 12, '2021-03-20 22:46:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pastèque', 'pasteque.png', 'féminin', 'pastèques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pastèque', 'pastèques', 12, '2021-03-20 22:47:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poire', 'poire.png', 'féminin', 'poires', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poire', 'poires', 12, '2021-03-20 22:48:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poireau', 'poireaux.png', 'masculin', 'poireaux', NULL, NULL, NULL, NULL, NULL, NULL, 'poireau', 'poireaux', NULL, NULL, 12, '2021-03-20 22:49:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poivron', 'poivron.png', 'masculin', 'poivrons', NULL, NULL, NULL, NULL, NULL, NULL, 'poivron', 'poivrons', NULL, NULL, 12, '2021-03-20 22:49:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pomme', 'pomme.png', 'féminin', 'pommes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pomme', 'pommes', 12, '2021-03-20 22:50:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Raisin noir', 'raisinsNoirs.png', 'masculin', 'raisins noirs', NULL, NULL, NULL, NULL, NULL, NULL, 'raisin noir', 'raisins noirs', NULL, NULL, 12, '2021-03-20 22:51:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Salade', 'salade.png', 'féminin', 'salades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'salade', 'salades', 12, '2021-03-20 22:52:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tomate', 'tomate.png', 'féminin', 'tomates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tomate', 'tomates', 12, '2021-03-20 22:53:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Boulangerie', 'boulangerie.png', 'féminin', 'boulangeries', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'boulangerie', 'boulangeries', NULL, '2021-03-21 08:36:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chambre à coucher', 'chambreACoucher.png', 'féminin', 'chambres à coucher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chambre à coucher', 'chambres à coucher', NULL, '2021-03-21 08:37:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinema', 'cinema.png', 'masculin', 'cinemas', NULL, NULL, NULL, NULL, NULL, NULL, 'cinema', 'cinemas', NULL, NULL, 14, '2021-03-21 08:38:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Magasin de glaces', 'magasinDeGlaces.png', 'masculin', 'magasins de glaces', NULL, NULL, NULL, NULL, NULL, NULL, 'magasin de glaces', 'magasins de glaces', NULL, NULL, NULL, '2021-03-21 08:39:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Maison', 'maison.png', 'féminin', 'maisons', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'maison', 'maisons', NULL, '2021-03-21 08:40:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pharmacie', 'pharmacie.png', 'féminin', 'pharmacies', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pharmacie', 'pharmacies', NULL, '2021-03-21 08:41:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Piscine', 'piscine.png', 'féminin', 'piscines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'piscine', 'piscines', 14, '2021-03-21 08:42:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Salon de coiffure', 'salonDeCoiffure.png', 'masculin', 'salons de coiffure', NULL, NULL, NULL, NULL, NULL, NULL, 'salon de coiffure', 'salons de coiffure', NULL, NULL, NULL, '2021-03-21 08:43:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Salon', 'salon.png', 'masculin', 'salons', NULL, NULL, NULL, NULL, NULL, NULL, 'salon', 'salons', NULL, NULL, NULL, '2021-03-21 08:44:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Supermarché', 'supermarche.png', 'masculin', 'supermarchés', NULL, NULL, NULL, NULL, NULL, NULL, 'supermarché', 'supermarchés', NULL, NULL, NULL, '2021-03-21 08:45:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ville', 'ville.png', 'féminin', 'villes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ville', 'villes', 14, '2021-03-21 08:46:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Arc-en-ciel', 'arcEnCiel.png', 'masculin', 'arcs-en-ciel', NULL, NULL, NULL, NULL, NULL, NULL, 'arc-en-ciel', 'arcs-en-ciel', NULL, NULL, 15, '2021-03-21 08:47:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Brumeux', 'brumeux.png', 'masculin', 'brumeux', NULL, NULL, NULL, NULL, NULL, NULL, 'brumeux', 'brumeux', 'brumeuse', 'brumeuses', 15, '2021-03-21 08:48:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Éclair', 'eclair.png', 'masculin', 'éclairs', NULL, NULL, NULL, NULL, NULL, NULL, 'éclair', 'éclairs', NULL, NULL, 15, '2021-03-21 08:49:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ensoleillé', 'ensoleille.png', 'masculin', 'ensoleillés', NULL, NULL, NULL, NULL, NULL, NULL, 'ensoleillé', 'ensoleillés', 'ensoleillée', 'ensoleillées', 15, '2021-03-21 08:50:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Neigeux', 'neigeux.png', 'masculin', 'neigeux', NULL, NULL, NULL, NULL, NULL, NULL, 'neigeux', 'neigeux', 'neigeuse', 'neigeuses', 15, '2021-03-21 08:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tonnerre', 'tonnerre.png', 'masculin', 'tonnerres', NULL, NULL, NULL, NULL, NULL, NULL, 'tonnerre', 'tonnerres', NULL, NULL, 15, '2021-03-21 08:53:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Nuageux', 'nuageux.png', 'masculin', 'nuageux', NULL, NULL, NULL, NULL, NULL, NULL, 'nuageux', 'nuageux', 'nuageuse', 'nuageuses', 15, '2021-03-21 08:54:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Orageux', 'orageux.png', 'masculin', 'orageux', NULL, NULL, NULL, NULL, NULL, NULL, 'orageux', 'orageux', 'orageuse', 'orageuses', 15, '2021-03-21 08:55:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tornade', 'tornade.png', 'féminin', 'tornades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tornade', 'tornades', 15, '2021-03-21 08:56:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bibliothèque', 'bibliotheque.png', 'féminin', 'bibliothèques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bibliothèque', 'bibliothèques', 17, '2021-03-21 09:16:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Casserole', 'casserole.png', 'féminin', 'casseroles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'casserole', 'casseroles', NULL, '2021-03-21 09:18:04', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Balai', 'balai.png', 'masculin', 'balais', NULL, NULL, NULL, NULL, NULL, NULL, 'balai', 'balais', NULL, NULL, 17, '2021-03-21 09:19:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chaise', 'chaise.png', 'féminin', 'chaises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaise', 'chaises', 17, '2021-03-21 09:20:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ciseaux', 'ciseaux1.png', 'masculin', 'ciseaux', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ciseaux', NULL, NULL, 17, '2021-03-21 09:21:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Conserves', 'conserve.png', 'féminin', 'conserves', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'conserve', 'conserves', NULL, '2021-03-21 09:22:43', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Coussin', 'coussin.png', 'masculin', 'coussins', NULL, NULL, NULL, NULL, NULL, NULL, 'coussin', 'coussins', NULL, NULL, 17, '2021-03-21 09:23:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Couvert', 'couverts.png', 'masculin', 'couverts', NULL, NULL, NULL, NULL, NULL, NULL, 'couvert', 'couverts', NULL, NULL, NULL, '2021-03-21 09:24:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lampe', 'lampe.png', 'féminin', 'lampes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lampe', 'lampes', 17, '2021-03-21 09:25:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lit', 'lit.png', 'masculin', 'lits', NULL, NULL, NULL, NULL, NULL, NULL, 'lit', 'lits', NULL, NULL, 17, '2021-03-21 09:26:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Lunettes', 'lunettes.png', 'féminin', 'lunettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lunettes', 17, '2021-03-21 09:27:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pèse-personne', 'pesePersonne.png', 'masculin', 'pèse-personnes', NULL, NULL, NULL, NULL, NULL, NULL, 'pèse-personne', 'pèse-personnes', NULL, NULL, 17, '2021-03-21 09:28:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Portefeuille', 'portefeuille.png', 'masculin', 'portefeuilles', NULL, NULL, NULL, NULL, NULL, NULL, 'portefeuille', 'portefeuilles', NULL, NULL, 17, '2021-03-21 09:29:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Poubelle', 'poubelle.png', 'féminin', 'poubelles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poubelle', 'poubelles', 17, '2021-03-21 09:30:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Réfrigérateur', 'refrigerateur.png', 'masculin', 'réfrigérateurs', NULL, NULL, NULL, NULL, NULL, NULL, 'réfrigérateur', 'réfrigérateurs', NULL, NULL, NULL, '2021-03-21 09:31:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sac à dos', 'sacADos.png', 'masculin', 'sacs à dos', NULL, NULL, NULL, NULL, NULL, NULL, 'sac à dos', 'sacs à dos', NULL, NULL, 17, '2021-03-21 09:32:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Seau', 'seau.png', 'masculin', 'seaux', NULL, NULL, NULL, NULL, NULL, NULL, 'seau', 'seaux', NULL, NULL, 17, '2021-03-21 09:33:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Serviette de bain', 'servietteDeBain.png', 'féminin', 'serviettes de bain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'serviette de bain', 'serviettes de bain', NULL, '2021-03-21 09:34:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Affaires de toilettes', 'affairesDeToilette.png', 'féminin', 'affaires de toilettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affaire de toilettes', 'affaires de toilettes', NULL, '2021-03-21 09:35:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trousse de toilettes', 'trousseDeToilette.png', 'féminin', 'trousses de toilettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trousse de toilettes', 'trousses de toilettes', NULL, '2021-03-21 09:36:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tasse', 'tasse.png', 'féminin', 'tasses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tasse', 'tasses', NULL, '2021-03-21 09:37:49', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vaisselle', 'vaisselle.png', 'féminin', 'vaisselles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vaisselle', 'vaisselles', NULL, '2021-03-21 09:38:49', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Astronaute', 'astronaute.png', 'masculin', 'astronautes', NULL, NULL, NULL, NULL, NULL, NULL, 'astronaute', 'astronautes', 'astronaute', 'astronautes', 18, '2021-03-21 09:46:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bibliothécaire', 'bibliothecaire.png', 'féminin', 'bibliothécaires', NULL, NULL, NULL, NULL, NULL, NULL, 'bibliothécaire', 'bibliothécaires', 'bibliothécaire', 'bibliothécaires', 18, '2021-03-21 09:48:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Caissière', 'caissiere.png', 'féminin', 'caissières', NULL, NULL, NULL, NULL, NULL, NULL, 'caissier', 'caissiers', 'caissière', 'caissières', 18, '2021-03-21 09:49:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chauffeur de taxi', 'chauffeurDeTaxi.png', 'masculin', 'chauffeurs de taxi', NULL, NULL, NULL, NULL, NULL, NULL, 'chauffeur de taxi', 'chauffeurs de taxi', 'chauffeuse de taxi', 'chauffeuses de taxi', 18, '2021-03-21 09:50:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chef d\'orchestre', 'chefDOrchestre.png', 'féminin', 'chefs d\'orchestre', NULL, NULL, NULL, NULL, NULL, NULL, 'chef d\'orchestre', 'chefs d\'orchestre', 'chefs d\'orchestre', 'chefs d\'orchestre', 18, '2021-03-21 09:51:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Coiffeuse', 'coiffeuse.png', 'féminin', 'coiffeuses', NULL, NULL, NULL, NULL, NULL, NULL, 'coiffeur', 'coiffeurs', 'coiffeuse', 'coiffeuses', 18, '2021-03-21 09:52:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cuisinier', 'cuisinier.png', 'masculin', 'cuisiniers', NULL, NULL, NULL, NULL, NULL, NULL, 'cuisinier', 'cuisiniers', 'cuisinière', 'cuisinieres', 18, '2021-03-21 09:53:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Danseur', 'danseur.png', 'masculin', 'danseurs', NULL, NULL, NULL, NULL, NULL, NULL, 'danseur', 'danseurs', 'danseuse', 'danseuses', 18, '2021-03-21 09:54:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Grand-père', 'grandPere.png', 'masculin', 'grands-pères', NULL, NULL, NULL, NULL, NULL, NULL, 'grand-père', 'grand-pères', NULL, NULL, NULL, '2021-03-21 09:55:41', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Informaticienne', 'informaticienne.png', 'féminin', 'informaticiennes', NULL, NULL, NULL, NULL, NULL, NULL, 'informaticien', 'informaticiens', 'informaticienne', 'informaticiennes', 18, '2021-03-21 09:56:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Livreur', 'livreur.png', 'masculin', 'livreurs', NULL, NULL, NULL, NULL, NULL, NULL, 'livreur', 'livreurs', 'livreuse', 'livreuses', 18, '2021-03-21 09:57:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Maman', 'maman.png', 'féminin', 'mamans', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'maman', 'mamans', NULL, '2021-03-21 09:58:04', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Moniteur', 'moniteur.png', 'masculin', 'moniteurs', NULL, NULL, NULL, NULL, NULL, NULL, 'moniteur', 'moniteurs', 'monitrice', 'monitrices', 18, '2021-03-21 09:59:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Opticien', 'opticien.png', 'masculin', 'opticiens', NULL, NULL, NULL, NULL, NULL, NULL, 'opticien', 'opticiens', 'opticienne', 'opticiennes', 18, '2021-03-21 10:00:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Plombier', 'plombier.png', 'masculin', 'plombiers', NULL, NULL, NULL, NULL, NULL, NULL, 'plombier', 'plombiers', 'plombière', 'plombières', 18, '2021-03-21 10:01:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Policier', 'policier.png', 'masculin', 'policiers', NULL, NULL, NULL, NULL, NULL, NULL, 'policier', 'policiers', 'policière', 'policières', 18, '2021-03-21 10:02:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pompière', 'pompiere.png', 'féminin', 'pompières', NULL, NULL, NULL, NULL, NULL, NULL, 'pompier', 'pompiers', 'pompière', 'pompières', 18, '2021-03-21 10:03:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Psychologue', 'psychologue.png', 'masculin', 'psychologues', NULL, NULL, NULL, NULL, NULL, NULL, 'psychologue', 'psychologues', 'psychologue', 'psychologues', 18, '2021-03-21 10:04:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Scientifique', 'scientifique.png', 'féminin', 'scientifiques', NULL, NULL, NULL, NULL, NULL, NULL, 'scientifique', 'scientifiques', 'scientifique', 'scientifiques', 18, '2021-03-21 10:05:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Compas', 'compas.png', 'masculin', 'compas', NULL, NULL, NULL, NULL, NULL, NULL, 'compas', 'compas', NULL, NULL, 19, '2021-03-21 10:39:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Crayons de couleurs', 'crayonsDeCouleurs.png', 'masculin', 'crayons de couleurs', NULL, NULL, NULL, NULL, NULL, NULL, 'crayon de couleurs', 'crayons de couleurs', NULL, NULL, 19, '2021-03-21 10:40:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Calculatrice', 'calculatrice.png', 'féminin', 'calculatrices', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calculatrice', 'calculatrices', 19, '2021-03-21 10:42:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dictionnaire', 'dictionnaire.png', 'masculin', 'dictionnaires', NULL, NULL, NULL, NULL, NULL, NULL, 'dictionnaire', 'dictionnaires', NULL, NULL, 19, '2021-03-21 10:43:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Feutre', 'feutre.png', 'masculin', 'feutres', NULL, NULL, NULL, NULL, NULL, NULL, 'feutre', 'feutres', NULL, NULL, 19, '2021-03-21 10:44:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Papier', 'papier.png', 'masculin', 'papiers', NULL, NULL, NULL, NULL, NULL, NULL, 'papier', 'papiers', NULL, NULL, 19, '2021-03-21 10:45:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pinceau', 'pinceau.png', 'masculin', 'pinceaux', NULL, NULL, NULL, NULL, NULL, NULL, 'pinceau', 'pinceaux', NULL, NULL, 19, '2021-03-21 10:46:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Récréation', 'recreation.png', 'féminin', 'récréations', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'récréation', 'récréations', 19, '2021-03-21 10:47:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Scotch', 'scotch.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Scotch', NULL, NULL, NULL, 19, '2021-03-21 10:48:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tableau', 'tableau.png', 'masculin', 'tableaux', NULL, NULL, NULL, NULL, NULL, NULL, 'tableau', 'tableaux', NULL, NULL, 19, '2021-03-21 10:49:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Fusée', 'fusee.png', 'féminin', 'fusées', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fusée', 'fusées', 20, '2021-03-21 10:50:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bateau', 'bateau.png', 'masculin', 'bateaux', NULL, NULL, NULL, NULL, NULL, NULL, 'bateau', 'bateaux', NULL, NULL, 20, '2021-03-21 10:51:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Bus', 'bus.png', 'masculin', 'bus', NULL, NULL, NULL, NULL, NULL, NULL, 'bus', 'bus', NULL, NULL, 20, '2021-03-21 10:52:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Camion de pompiers', 'camionDePompiers.png', 'masculin', 'camions de pompiers', NULL, NULL, NULL, NULL, NULL, NULL, 'camion de pompiers', 'camions de pompiers', NULL, NULL, 20, '2021-03-21 10:53:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Camion', 'camion.png', 'masculin', 'camions', NULL, NULL, NULL, NULL, NULL, NULL, 'camion', 'camions', NULL, NULL, 20, '2021-03-21 10:54:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Moto', 'moto.png', 'féminin', 'motos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moto', 'motos', 20, '2021-03-21 10:55:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tricycle', 'tricycle.png', 'masculin', 'tricycles', NULL, NULL, NULL, NULL, NULL, NULL, 'tricycle', 'tricycles', NULL, NULL, 20, '2021-03-21 10:56:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Vélo', 'velo.png', 'masculin', 'vélos', NULL, NULL, NULL, NULL, NULL, NULL, 'vélo', 'vélos', NULL, NULL, 20, '2021-03-21 10:57:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trottinette', 'trottinette.png', 'féminin', 'trottinettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trottinette', 'trottinettes', 20, '2021-03-21 10:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Voiture', 'voiture.png', 'féminin', 'voitures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'voiture', 'voitures', 20, '2021-03-21 10:59:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chemise', 'chemise.png', 'féminin', 'chemises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chemise', 'chemises', 21, '2021-03-21 11:03:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Culotte', 'culotte.png', 'féminin', 'culottes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'culotte', 'culottes', 21, '2021-03-21 11:04:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Anorak', 'anorak.png', 'masculin', 'anoraks', NULL, NULL, NULL, NULL, NULL, NULL, 'anorak', 'anoraks', NULL, NULL, 21, '2021-03-21 11:10:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ciré', 'cire.png', 'masculin', 'cirés', NULL, NULL, NULL, NULL, NULL, NULL, 'cirés', 'cirés', NULL, NULL, 21, '2021-03-21 11:11:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Collant', 'collant.png', 'masculin', 'collants', NULL, NULL, NULL, NULL, NULL, NULL, 'collant', 'collants', NULL, NULL, 21, '2021-03-21 11:12:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Gant', 'gant.png', 'masculin', 'gants', NULL, NULL, NULL, NULL, NULL, NULL, 'gant', 'gants', NULL, NULL, 21, '2021-03-21 11:13:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Jupe', 'jupe.png', 'féminin', 'jupes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jupe', 'jupes', 21, '2021-03-21 11:14:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Maillot de bain', 'maillotDeBain.png', 'masculin', 'maillots de bain', NULL, NULL, NULL, NULL, NULL, NULL, 'maillot de bain', 'maillots de bain', NULL, NULL, 21, '2021-03-21 11:15:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Moufle', 'moufle.png', 'féminin', 'moufles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moufle', 'moufles', 21, '2021-03-21 11:16:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Polo', 'polo.png', 'masculin', 'polos', NULL, NULL, NULL, NULL, NULL, NULL, 'polo', 'polos', NULL, NULL, 21, '2021-03-21 11:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pyjama hôpital', 'pyjamaHopital.png', 'masculin', 'pyjamas hôpital', NULL, NULL, NULL, NULL, NULL, NULL, 'pyjama hôpital', 'pyjamas hôpital', NULL, NULL, 21, '2021-03-21 11:18:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pyjama', 'pyjama.png', 'masculin', 'pyjamas', NULL, NULL, NULL, NULL, NULL, NULL, 'pyjama', 'pyjamas', NULL, NULL, 21, '2021-03-21 11:19:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Robe', 'robe.png', 'féminin', 'robes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'robe', 'robes', 21, '2021-03-21 11:20:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Short', 'short.png', 'masculin', 'shorts', NULL, NULL, NULL, NULL, NULL, NULL, 'short', 'shorts', NULL, NULL, 21, '2021-03-21 11:22:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Slip', 'slip.png', 'masculin', 'slips', NULL, NULL, NULL, NULL, NULL, NULL, 'slip', 'slips', NULL, NULL, 21, '2021-03-21 11:23:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sweet-shirt', 'sweetShirt.png', 'masculin', 'sweet-shirts', NULL, NULL, NULL, NULL, NULL, NULL, 'sweet-shirt', 'sweet-shirts', NULL, NULL, 21, '2021-03-21 11:24:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Veste', 'veste.png', 'féminin', 'vestes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'veste', 'vestes', 21, '2021-03-21 11:25:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Aux', 'aux1.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 21:59:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Chez', 'chez.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:00:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Dans', 'dans.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:01:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Du', 'du.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:02:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['La', 'la.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:03:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Le', 'le.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:04:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Les', 'les.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:05:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mien', 'mien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:06:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Mienne', 'mienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:07:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Miennes', 'miennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:08:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sien', 'sien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:09:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sienne', 'sienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:10:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Siennes', 'siennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:11:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tien', 'tien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:12:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tienne', 'tienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:13:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Tiennes', 'tiennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:14:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ton', 'ton.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:12:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Asseoir', 'asseoir.png', NULL, NULL, 'assieds', 'assieds', 'assied', 'asseyons', 'asseyez', 'asseyent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:25:19', NULL, NULL, 'assiérai', 'assiéras', 'assiéra', 'assiérons', 'assiérez', 'assiéront', 'ai assis', 'as assis', 'a assis', 'avons assis', 'avez assis', 'ont assis'],
            ['Casser', 'casser.png', NULL, NULL, 'casse', 'casses', 'casse', 'cassons', 'cassez', 'cassent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:26:19', NULL, NULL, 'casserai', 'casseras', 'cassera', 'casserons', 'casserez', 'casseront', 'ai cassé', 'as cassé', 'a cassé', 'avons cassé', 'avez cassé', 'ont cassé'],
            ['Cracher', 'cracher.png', NULL, NULL, 'crache', 'craches', 'crache', 'crachons', 'crachez', 'crachent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:27:19', NULL, NULL, 'cracherai', 'cracheras', 'crachera', 'cracherons', 'cracherez', 'cracheront', 'ai craché', 'as craché', 'a craché', 'avons craché', 'avez craché', 'ont craché'],
            ['Crier', 'crier.png', NULL, NULL, 'crie', 'cries', 'crie', 'crions', 'criez', 'crient', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:28:19', NULL, NULL, 'crierai', 'crieras', 'criera', 'crierons', 'crierez', 'crieront', 'ai crié', 'as crié', 'a crié', 'avons crié', 'avez crié', 'ont crié'],
            ['Disputer', 'disputer.png', NULL, NULL, 'dispute', 'disputes', 'dispute', 'disputons', 'disputez', 'disputent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:29:19', NULL, NULL, 'disputerai', 'disputeras', 'disputera', 'disputerons', 'disputerez', 'disputeront', 'ai disputé', 'as disputé', 'a disputé', 'avons disputé', 'avez disputé', 'ont disputé'],
            ['Frapper', 'frapper.png', NULL, NULL, 'frappe', 'frappes', 'frappe', 'frappons', 'frappez', 'frappent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:30:19', NULL, NULL, 'frapperai', 'frapperas', 'frappera', 'frapperons', 'frapperez', 'frapperont', 'ai frappé', 'as frappé', 'a frappé', 'avons frappé', 'avez frappé', 'ont frappé'],
            ['Jeter', 'jeter.png', NULL, NULL, 'jette', 'jettes', 'jette', 'jetons', 'jetez', 'jettent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:31:19', NULL, NULL, 'jetterai', 'jetteras', 'jettera', 'jetterons', 'jetterez', 'jetteront', 'ai jeté', 'as jeté', 'a jeté', 'avons jeté', 'avez jeté', 'ont jeté'],
            ['Griffer', 'griffer.png', NULL, NULL, 'griffe', 'griffes', 'griffe', 'griffons', 'griffez', 'griffent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:32:19', NULL, NULL, 'grifferai', 'grifferas', 'griffera', 'grifferons', 'grifferez', 'grifferont', 'ai griffé', 'as griffé', 'a griffé', 'avons griffé', 'avez griffé', 'ont griffé'],
            ['Mordre', 'mordre.png', NULL, NULL, 'mords', 'mords', 'mord', 'mordons', 'mordez', 'mordent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:33:19', NULL, NULL, 'mordrai', 'mordras', 'mordra', 'mordrons', 'mordrez', 'mordront', 'ai mordu', 'as mordu', 'a mordu', 'avons mordu', 'avez mordu', 'ont mordu'],
            ['Trépigner', 'trepigner.png', NULL, NULL, 'trépigne', 'trépigne', 'trépigne', 'trépignons', 'trépignez', 'trépignent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:34:19', NULL, NULL, 'trépignerai', 'trépigneras', 'trépignera', 'trépignerons', 'trépignerez', 'trépigneront', 'ai trépigné', 'as trépigné', 'a trépigné', 'avons trépigné', 'avez trépigné', 'ont trépigné'],
            ['Soir', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-26 15:39:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Qui', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 15:39:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quoi', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:43:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Matin', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:58:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Matin', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:58:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:59:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:59:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ou', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:00:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ou', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:00:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:01:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:01:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiTrente', 'heure_0h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:02:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiTrente', 'heure_0h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:02:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pourquoi', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pourquoi', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi', 'heure_0h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi', 'heure_0h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neufheuretrente', 'heure_9h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neufheuretrente', 'heure_9h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neuf heure quarante cinq', 'heure_9h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:06:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neuf heure quarante cinq', 'heure_9h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:06:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Neufheure', 'heure_9h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:07:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neufheurequinze', 'heure_9h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:08:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['neufheurequinze', 'heure_9h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:08:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huitheuretrente', 'heure_8h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huitheuretrente', 'heure_8h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure quarante cinq', 'heure_8h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure quarante cinq', 'heure_8h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure quinze', 'heure_8h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure quinze', 'heure_8h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure', 'heure_8h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Huit heure', 'heure_8h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heure', 'heure_7h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heure', 'heure_7h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['sept heure et quart', 'heure_7h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['sept heure et quart', 'heure_7h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heures quinze', 'heure_7h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heures quinze', 'heure_7h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heure trente', 'heure_7h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Sept heure trente', 'heure_7h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures', 'heure_6h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures', 'heure_6h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures et quart', 'heure_6h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures et quart', 'heure_6h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures trente', 'heure_6h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:14:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures trente', 'heure_6h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:14:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures quinze', 'heure_6h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Six heures quinze', 'heure_6h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heure', 'heure_5h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heure', 'heure_5h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heures moins quart', 'heure_5h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heures moins quart', 'heure_5h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heure trente ', 'heure_5h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heure trente ', 'heure_5h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heures moins le quart ', 'heure_5h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Cinq heures moins le quart ', 'heure_5h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures', 'heure_4h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures', 'heure_4h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures  et Quart', 'heure_4h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures  et Quart', 'heure_4h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures et demi\r\n\r\n\r\n\r\n\r\n', 'heure_4h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quatre Heures et demi\r\n\r\n\r\n\r\n\r\n', 'heure_4h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['', 'Trois Heures', 'heure_3h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['', 'Trois Heures', 'heure_3h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures  et quart', 'heure_3h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures  et quart', 'heure_3h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures moins le quart', 'heure_3h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures moins le quart', 'heure_3h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures et demi ', 'heure_3h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Trois Heures et demi ', 'heure_3h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures ', 'heure_2h.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures ', 'heure_2h.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures et quart', 'heure_2h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:21:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures et quart', 'heure_2h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:21:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures   et demi', 'heure_2h30.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures   et demi', 'heure_2h30.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures  moins le quart', 'heure_2h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Deux heures  moins le quart', 'heure_2h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['? ', 'interrogatif.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['? ', 'interrogatif.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Comment', 'interrogatif_comment.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:30:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Comment', 'interrogatif_comment.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:30:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pourquoi ', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Pourquoi ', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quoi ', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quoi ', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Qui ', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Qui ', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ou ', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Ou ', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Que ', 'interrogatif_que.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Que ', 'interrogatif_que.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quand ', 'interrogatif_quand.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Quand ', 'interrogatif_quand.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Matin ', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Matin ', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Soir ', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Soir ', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Après-midi ', 'temps_apresmidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:35:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Après-midi ', 'temps_apresmidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:35:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi ', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:36:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            ['Midi ', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:36:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL]
        ];
        foreach ($data as $row) {
            $pictogram = new Pictogram();
            $pictogram->setName($row[0]);
            $pictogram->setFilename($row[1]);
            if ($row[2] != null) {
                $pictogram->setGenre($row[2]);
            }
            if ($row[3] != null) {
                $pictogram->setPluriel($row[3]);
            }
            //--------Singular------------
            if ($row[4] != null) {
                $pictogram->setPremPersSing($row[4]);
            }
            if ($row[5] != null) {
                $pictogram->setDeuxPersSing($row[5]);
            }
            if ($row[6] != null) {
                $pictogram->setTroisPersSing($row[6]);
            }
            //--------Pluriel------------
            if ($row[7] != null) {
                $pictogram->setPremPersPlur($row[7]);
            }
            if ($row[8] != null) {
                $pictogram->setDeuxPersPlur($row[8]);
            }
            if ($row[9] != null) {
                $pictogram->setTroisPersPlur($row[9]);
            }

            //--------Masculin------------
            if ($row[10] != null) {
                $pictogram->setMasculinSing($row[10]);
            }
            if ($row[11] != null) {
                $pictogram->setMasculinPlur($row[11]);
            }

            //--------Feminin------------
            if ($row[12] != null) {
                $pictogram->setFemininSing($row[12]);
            }
            if ($row[13] != null) {
                $pictogram->setFemininPlur($row[13]);
            }

            /* ********** Setting categories ************ */
            switch ($row[14]) {
                case 1:
                    $pictogram->setCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 2:
                    $pictogram->setCategory($this->cRepo->findOneByName("Boissons"));
                    break;
                case 3:
                    $pictogram->setCategory($this->cRepo->findOneByName("Actions"));
                    break;
                case 4:
                    $pictogram->setCategory($this->cRepo->findOneByName("Adjectifs"));
                    break;
                case 5:
                    $pictogram->setCategory($this->cRepo->findOneByName("Aliments"));
                    break;
                case 6:
                    $pictogram->setCategory($this->cRepo->findOneByName("Animaux"));
                    break;
                case 7:
                    $pictogram->setCategory($this->cRepo->findOneByName("Chiffres"));
                    break;
                case 8:
                    $pictogram->setCategory($this->cRepo->findOneByName("Corps humain"));
                    break;
                case 9:
                    $pictogram->setCategory($this->cRepo->findOneByName("Couleurs"));
                    break;
                case 10:
                    $pictogram->setCategory($this->cRepo->findOneByName("Petits mots"));
                    break;
                case 11:
                    $pictogram->setCategory($this->cRepo->findOneByName("Émotions"));
                    break;
                case 12:
                    $pictogram->setCategory($this->cRepo->findOneByName("Fruits et légumes"));
                    break;
                case 13:
                    $pictogram->setCategory($this->cRepo->findOneByName("Langues Des Signes"));
                    break;
                case 14:
                    $pictogram->setCategory($this->cRepo->findOneByName("Lieux"));
                    break;
                case 15:
                    $pictogram->setCategory($this->cRepo->findOneByName("Météo"));
                    break;
                case 16:
                    $pictogram->setCategory($this->cRepo->findOneByName("Multimédia"));
                    break;
                case 17:
                    $pictogram->setCategory($this->cRepo->findOneByName("Objets"));
                    break;
                case 18:
                    $pictogram->setCategory($this->cRepo->findOneByName("Personnes"));
                    break;
                case 19:
                    $pictogram->setCategory($this->cRepo->findOneByName("Scolarité"));
                    break;
                case 20:
                    $pictogram->setCategory($this->cRepo->findOneByName("Transports"));
                    break;
                case 21:
                    $pictogram->setCategory($this->cRepo->findOneByName("Vêtements"));
                    break;
                case 22:
                    $pictogram->setCategory($this->cRepo->findOneByName("Comportements"));
                    break;
                case 23:
                    $pictogram->setCategory($this->cRepo->findOneByName("Orientation"));
                    break;
                case 24:
                    $pictogram->setCategory($this->cRepo->findOneByName("Autres Mots"));
                    break;
                case 25:
                    $pictogram->setCategory($this->cRepo->findOneByName("Formes"));
                    break;
                case 26:
                    $pictogram->setCategory($this->cRepo->findOneByName("Sports"));
                    break;
                case 31:
                    $pictogram->setCategory($this->cRepo->findOneByName("Sécurité Routière"));
                    break;
                case 33:
                    $pictogram->setCategory($this->cRepo->findOneByName("Jouet"));
                    break;
                case 36:
                    $pictogram->setCategory($this->cRepo->findOneByName("Interrogatif"));
                    break;
                case 37:
                    $pictogram->setCategory($this->cRepo->findOneByName("Journee"));
                    break;
                case 39:
                    $pictogram->setCategory($this->cRepo->findOneByName("Heures"));
                    break;
                case 41:
                    $pictogram->setCategory($this->cRepo->findOneByName("Couverts"));
                    break;
                default:
                    break;
            }

            $pictogram->setUpdatedAt($this->formatDateTimeByString($row[15]));

            /* ********** Setting subcategories ************ */
            if ($row[16] != null) {
                $pictogram->setTherapist($this->thRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
            }

            /* ********** Setting subcategories ************ */
            switch ($row[17]) {
                case 3:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("École"));
                    break;
                case 4:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Maison"));
                    break;
                case 6:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Magasins"));
                    break;
                case 7:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Famille"));
                    break;
                case 8:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Objets de la cuisine"));
                    break;
                case 9:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Objets de la salle de bain"));
                    break;
                case 10:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre A"));
                    break;
                case 11:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre C"));
                    break;
                case 12:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre D"));
                    break;
                case 13:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre E"));
                    break;
                case 14:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre L"));
                    break;
                case 15:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre M"));
                    break;
                case 16:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre N"));
                    break;
                case 17:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre S"));
                    break;
                case 18:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre T"));
                    break;
                case 19:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre U"));
                    break;
                case 20:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Lettre V"));
                    break;
                case 22:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("Magasin"));
                    break;
                case 27:
                    $pictogram->setSubCategory($this->scRepo->findOneByName("bar"));
                    break;
                default:
                    break;
            }

            //--------Futur------------
            if ($row[18] != null) {
                $pictogram->setPremPersSingFutur($row[18]);
            }
            if ($row[19] != null) {
                $pictogram->setDeuxPersSingFutur($row[19]);
            }
            if ($row[20] != null) {
                $pictogram->setTroisPersSingFutur($row[20]);
            }
            if ($row[21] != null) {
                $pictogram->setPremPersPlurFutur($row[21]);
            }
            if ($row[22] != null) {
                $pictogram->setDeuxPersPlurFutur($row[22]);
            }
            if ($row[23] != null) {
                $pictogram->setTroisPersPlurFutur($row[23]);
            }

            //--------Passe------------
            if ($row[24] != null) {
                $pictogram->setPremPersSingPasse($row[24]);
            }
            if ($row[25] != null) {
                $pictogram->setDeuxPersSingPasse($row[25]);
            }
            if ($row[26] != null) {
                $pictogram->setTroisPersSingPasse($row[26]);
            }
            if ($row[27] != null) {
                $pictogram->setPremPersPlurPasse($row[27]);
            }
            if ($row[28] != null) {
                $pictogram->setDeuxPersPlurPasse($row[28]);
            }
            if ($row[29] != null) {
                $pictogram->setTroisPersPlurPasse($row[29]);
            }

            $manager->persist($pictogram);
        }
    }

    private function populateQuestion(ObjectManager $manager)
    {
        $data = [
            [1, 'Quel âge as-tu ?'],
            [2, 'Qu\'as-tu mangé ce matin ?'],
            [3, 'Que veux-tu manger ?'],
            [4, 'Quelle est ta boisson préférée ?'],
            [5, 'Quel est ton sport préféré ?'],
            [6, 'Quel est ton animal préféré ?'],
            [7, 'Quelle est ta couleur préférée ?'],
            [8, 'Avec quoi veux-tu jouer ?'],
            [9, 'Que veux-tu faire plus tard ?'],
            [10, 'Où aimes-tu aller ?'],
            [11, 'Où as-tu mal ?'],
            [12, 'Comment te sens-tu ?'],
            [13, 'Comment te sens-tu quand tu es à l\'école ?'],
            [14, 'Comment te sens-tu quand tu es à la maison ?'],
            [15, 'De quelle couleur sont tes yeux ?'],
            [16, 'Quel temps fait-il aujourd\'hui ?'],
            [17, 'Quels vêtements choisir quand il fait froid ?'],
            [18, 'Combien as-tu de doigts ?'],
            [19, 'Quelle image désigne le cou ?'],
            [20, 'Quelle partie de ton corps permet d\'entendre ?'],
            [21, 'Qui te coupe les cheveux ?'],
            [22, 'Qui éteint le feu ?'],
            [23, 'Sélectionne des légumes ...'],
            [24, 'Où vas-tu acheter le pain ?'],
            [25, 'De quelle couleur est l\'herbe dans le jardin ?'],
            [26, 'Où peux-tu prendre le train ?'],
            [27, 'Avec quel moyen de transport peut-on aller dans l\'espace ?'],
            [28, 'Quel couvert tu veux utiliser ?'],
            [29, 'A quel moment de la journée sommes nous ?'],
            [30, 'Quelle heure est il ?']
        ];
        foreach ($data as $row) {
            $question = new Question();
            $question->setText($row[1]);
            switch ($row[0]) {
                case 1:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Chiffres"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 2:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Boissons"));
                    $question->addCategory($this->cRepo->findOneByName("Fruits et légumes"));
                    $question->addCategory($this->cRepo->findOneByName("Aliments"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 3:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Boissons"));
                    $question->addCategory($this->cRepo->findOneByName("Fruits et légumes"));
                    $question->addCategory($this->cRepo->findOneByName("Aliments"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 4:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Boissons"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 5:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Sports"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 6:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Animaux"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 7:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Couleurs"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 8:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Multimédia"));
                    $question->addCategory($this->cRepo->findOneByName("Objets"));
                    $question->addCategory($this->cRepo->findOneByName("Jouet"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 9:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 10:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Lieux"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 11:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Corps humain"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 12:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Comportements"));
                    $question->addCategory($this->cRepo->findOneByName("Émotions"));
                    $question->addCategory($this->cRepo->findOneByName("Adjectifs"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 13:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Comportements"));
                    $question->addCategory($this->cRepo->findOneByName("Émotions"));
                    $question->addCategory($this->cRepo->findOneByName("Adjectifs"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 14:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Comportements"));
                    $question->addCategory($this->cRepo->findOneByName("Émotions"));
                    $question->addCategory($this->cRepo->findOneByName("Adjectifs"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 15:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Couleurs"));
                    $question->addCategory($this->cRepo->findOneByName("Corps humain"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 16:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Adjectifs"));
                    $question->addCategory($this->cRepo->findOneByName("Météo"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 17:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Vêtements"));
                    $question->addCategory($this->cRepo->findOneByName("Adjectifs"));
                    $question->addCategory($this->cRepo->findOneByName("Météo"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 18:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Corps humain"));
                    $question->addCategory($this->cRepo->findOneByName("Chiffres"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 19:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Corps humain"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 20:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Corps humain"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 21:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Personnes"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 22:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Personnes"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 23:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Fruits et légumes"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 24:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Personnes"));
                    $question->addCategory($this->cRepo->findOneByName("Lieux"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 25:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Couleurs"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 26:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Lieux"));
                    $question->addCategory($this->cRepo->findOneByName("Sécurité Routière"));
                    $question->addCategory($this->cRepo->findOneByName("Transports"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 27:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Transports"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 28:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Couverts"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 29:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Journee"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
                case 30:
                    $question->addCategory($this->cRepo->findOneByName("Petits mots"));
                    $question->addCategory($this->cRepo->findOneByName("Heures"));
                    $question->addCategory($this->cRepo->findOneByName("Actions"));
                    $question->addCategory($this->cRepo->findOneByName("Sujets"));
                    break;
            }
            $manager->persist($question);
        }
    }

    private function populatePatient(ObjectManager $manager)
    {
        $data = [
            [[], 'Cyril', 'Acacio', '1985-12-20', 'Bac +2'],
            [[], 'Simba', 'Rudrauf', '2018-02-01', 'Test'],
            [[], 'Ziggy', 'V', '1999-06-01', 'On ne sait pas'],
            [[], 'Patient désactivé numéro 15', 'Patient désactivé numéro 15', '7119-08-29', 'a'],
            [[], 'John', 'Doe', '2010-10-20', 'Scolarisé dans une centre spécialisé'],
            [[], 'Patient désactivé numéro 17', 'Patient désactivé numéro 17', '2007-02-04', 'Scolarisé dans un centre spécialisé'],
            [[], 'Tristan', 'Rudrauf', '1994-10-15', 'Test'],
            [[], 'Patient désactivé numéro 20', 'Patient désactivé numéro 20', '1994-10-15', 'Test'],
            [[], 'Patient désactivé numéro 21', 'Patient désactivé numéro 21', '2021-07-14', 'Test'],
            [[], 'sa', 'sa', '2022-04-16', 'sa'],
            [[], 'Emilie', 'Ekon', '2005-02-03', 'lycee']
        ];
        foreach ($data as $row) {
            $patient = new Patient();
            $patient->setRoles($row[0]);
            $patient->setFirstName($row[1]);
            $patient->setLastName($row[2]);
            $patient->setBirthDate($this->formatBirthDateByString($row[3]));
            $patient->setSchoolGrade($row[4]);

            $manager->persist($patient);
        }
    }

    private function populateNote(ObjectManager $manager)
    {
        $data = [
            [1, 1, 'Sanguin', '2021-06-24 08:40:13'],
            [1, 2, 'Ceci est un test', '2021-06-24 12:26:15'],
            [1, 14, 'C\'est un chat.', '2021-03-30 12:59:01'],
            [1, 15, 'a', '2021-04-06 12:47:26'],
            [1, 14, 'Beau progrès pour un chat !', '2021-04-15 18:19:51'],
            [1, 16, 'Observation test', '2021-04-28 09:12:47'],
            [1, 16, 'Observation test ajoutée', '2021-05-04 11:26:28'],
            [1, 17, 'Troubles de la concentration', '2021-05-04 16:55:27'],
            [1, 19, 'Ceci est un test.', '2021-06-28 08:29:27'],
            [18, 20, 'test', '2021-07-07 10:34:27'],
            [1, 21, 'Test', '2021-07-27 12:54:10'],
            [21, 22, 'sa', '2022-04-16 11:37:45'],
            [24, 23, 'timide', '2022-11-04 11:04:56']
        ];
        foreach ($data as $row) {
            $note = new Note();

            /* ********** Setting therapists ************ */
            switch ($row[0]) {
                case 1:
                    $note->setTherapist($this->thRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
                    break;
                case 18:
                    $note->setTherapist($this->thRepo->findOneByEmail("palvac@gmail.com"));
                    break;
                case 21:
                    $note->setTherapist($this->thRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
                    break;
                case 24:
                    $note->setTherapist($this->thRepo->findOneByEmail("bleuechabani@gmail.com"));
                    break;
                default:
                    break;
            }

            /* ********** Setting patients ************ */
            switch ($row[1]) {
                case 1:
                    $note->setPatient($this->patRepo->findOneByName("Cyril", "Acacio"));
                    break;
                case 2:
                    $note->setPatient($this->patRepo->findOneByName("Simba", "Rudrauf"));
                    break;
                case 14:
                    $note->setPatient($this->patRepo->findOneByName('Ziggy', 'V'));
                    break;
                case 15:
                    $note->setPatient($this->patRepo->findOneByName('John', 'Doe'));
                    break;
                case 16:
                    $note->setPatient($this->patRepo->findOneByName('Tristan', 'Rudrauf'));
                    break;
                case 17:
                    $note->setPatient($this->patRepo->findOneByName('Emilie', 'Ekon'));
                    break;
                case 19:
                    $note->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 15', 'Patient désactivé numéro 15'));
                    break;
                case 20:
                    $note->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 17', 'Patient désactivé numéro 17'));
                    break;
                case 21:
                    $note->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 20', 'Patient désactivé numéro 20'));
                    break;
                case 22:
                    $note->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 21', 'Patient désactivé numéro 21'));
                    break;
                case 23:
                    $note->setPatient($this->patRepo->findOneByName('sa', 'sa'));
                    break;
                default:
                    break;
            }

            $note->setComment($row[2]);
            $note->setCreatedAt($this->formatDateTimeImmutableByString($row[3]));

            $manager->persist($note);
        }
    }

    private function populateSentence(ObjectManager $manager)
    {
        $data = [
            ['Je Regarder Des Oiseau Correct', NULL, '2021-03-30 13:01:17', 14],
            ['Je regarder mon petit gâteaux', NULL, '2021-03-30 13:09:38', 14],
            ['je vouloir mon gâteaux', NULL, '2021-04-01 20:12:25', 14],
            ['je regarder', NULL, '2021-04-01 20:14:21', 14],
            ['vous', NULL, '2021-04-01 20:14:40', 14],
            ['je regarder des lapin', NULL, '2021-04-01 20:18:41', 14],
            ['vouloir regarder boire', NULL, '2021-04-01 20:20:12', 14],
            ['Je vouloir regarder ton dinosaure décoiffé', NULL, '2021-04-07 10:32:03', 14],
            ['Je vouloir', NULL, '2021-04-09 09:17:12', 14],
            ['Je vouloir', NULL, '2021-04-09 09:18:51', 14],
            ['Je vouloir', NULL, '2021-04-09 09:20:11', 14],
            ['Je vouloir des glace', NULL, '2021-04-15 09:53:17', 14],
            ['Je tu', NULL, '2021-04-15 13:16:13', 14],
            ['Je ne veux pas des sodas', NULL, '2021-04-15 13:18:59', 14],
            ['Je veux des beurres', NULL, '2021-04-15 13:20:19', 14],
            ['Elle ne boit pas ma grenouille', NULL, '2021-04-15 13:22:27', 14],
            ['Je tu', NULL, '2021-04-15 13:23:15', 14],
            ['Je regarde ces fromages', NULL, '2021-04-15 14:33:07', 14],
            ['Je regarde ce canard', NULL, '2021-04-15 18:27:39', 14],
            ['Je ne veux pas des pâtes', NULL, '2021-04-16 11:10:16', 14],
            ['Je regarde des oiseauxxx', NULL, '2021-04-17 12:28:07', 14],
            ['Je tu il nous elle eux', NULL, '2021-04-20 10:30:04', 14],
            ['Je regarde des canards', NULL, '2021-04-20 11:06:55', 14],
            ['Je ne crie pas gros papillon', NULL, '2021-04-20 11:08:19', 14],
            ['Je ne regarde pas ce cheval', NULL, '2021-04-25 22:56:11', 14],
            ['Oui non peur papa papa papa', NULL, '2021-04-26 15:17:41', 14],
            ['Je veux des citrons', NULL, '2021-04-28 10:04:26', 16],
            ['Je ne bois pas mon jus d\'orange', NULL, '2021-04-28 10:05:07', 16],
            ['Je regarde des lapins', NULL, '2021-05-04 11:30:29', 14],
            ['Je suis joyeux', NULL, '2021-05-04 16:56:21', 17],
            ['Tu ne veux pas mon chocolat', NULL, '2021-05-04 16:56:54', 17],
            ['Magasin de glacess maisons pharmacies', NULL, '2021-05-23 19:11:31', 17],
            ['Je veux boire du lait', NULL, '2021-05-26 14:29:59', 14],
            ['Je veux manger des flans', NULL, '2021-05-27 13:21:20', 14],
            ['Je veux manger des flans', NULL, '2021-06-03 12:43:45', 14],
            ['Je regarde manger des grands chats', NULL, '2021-06-15 21:30:33', 14],
            [NULL, '1a3875058dabb2a13b00a233f1e5efe2.mp3', '2021-06-28 07:39:03', 1],
            ['Je bois soda correct beurre cheval cinq', NULL, '2021-06-28 09:28:35', 1],
            [NULL, '406ea0ffe29f456c7c91b74b33b78412.mp3', '2021-07-28 07:10:47', 1],
            [NULL, 'ecb2c0e7966f6a13d5e68f02801d865a.mp3', '2022-04-16 11:38:07', 22]
        ];
        foreach ($data as $row) {
            $sentence = new Sentence();
            if ($row[0] != null) {
                $sentence->setText($row[0]);
            }       
            if ($row[1] != null) {
                $sentence->setAudio($row[1]);
            }     
            
            $sentence->setCreatedAt($this->formatDateTimeImmutableByString($row[2]));

            /* ********** Setting patients ************ */
            switch ($row[3]) {
                case 1:
                    $sentence->setPatient($this->patRepo->findOneByName("Cyril", "Acacio"));
                    break;
                case 2:
                    $sentence->setPatient($this->patRepo->findOneByName("Simba", "Rudrauf"));
                    break;
                case 14:
                    $sentence->setPatient($this->patRepo->findOneByName('Ziggy', 'V'));
                    break;
                case 15:
                    $sentence->setPatient($this->patRepo->findOneByName('John', 'Doe'));
                    break;
                case 16:
                    $sentence->setPatient($this->patRepo->findOneByName('Tristan', 'Rudrauf'));
                    break;
                case 17:
                    $sentence->setPatient($this->patRepo->findOneByName('Emilie', 'Ekon'));
                    break;
                case 19:
                    $sentence->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 15', 'Patient désactivé numéro 15'));
                    break;
                case 20:
                    $sentence->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 17', 'Patient désactivé numéro 17'));
                    break;
                case 21:
                    $sentence->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 20', 'Patient désactivé numéro 20'));
                    break;
                case 22:
                    $sentence->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 21', 'Patient désactivé numéro 21'));
                    break;
                case 23:
                    $sentence->setPatient($this->patRepo->findOneByName('sa', 'sa'));
                    break;
                default:
                    break;
            }

            // /* ********** Link pictograms to sentence ************ */
            // $pictos = explode(" ", $row[0]);
            // foreach ($pictos as $picto) {
            //     if ($picto != null) {
            //         $sentence->addPictogram($this->pictRepo->findOneByName($picto));
            //     }
            // }

            $manager->persist($sentence);
        }
    }
}
