<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Institution;
use App\Entity\Pictogram;
use App\Entity\SubCategory;
use App\Entity\Therapist;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    private InstitutionRepository $instRepo;
    private TherapistRepository $therapistRepo;
    private CategoryRepository $catRepo;
    private SubCategoryRepository $subCatRepo;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        InstitutionRepository $instRepo,
        TherapistRepository $therapistRepo,
        CategoryRepository $catRepo,
        SubCategoryRepository $subCatRepo
    ) {
        $this->hasher = $hasher;

        $this->instRepo = $instRepo;
        $this->therapistRepo = $therapistRepo;
        $this->catRepo = $catRepo;
        $this->subCatRepo = $subCatRepo;
    }

    public function load(ObjectManager $manager): void
    {
        // populate institutions
        $dataInst = [
            [1, 'CRP', '123456789', 'crp@fake.com'],
            [2, 'EntrepriseTest', 'EntrepriseTest123', 'Entreprise@test.com'],
            [3, 'ECAM', 'ecam123456', 'ecam@gmail.com'],
            [4, 'test', '1234567890', 'test@fake.com']
        ];
        foreach ($dataInst as $row) {
            $institution = new Institution();
            $institution->setId($row[0]);
            $institution->setName($row[1]);
            $institution->setCode($row[2]);
            $institution->setEmail($row[3]);

            $manager->persist($institution);
        }
        $manager->flush();

        // populate therapists with refs to institutions
        $dataTherapist = [
            [2, 'rudrauf.tristan@orange.fr', [], '123456789', 'Tristan', 'Rudrauf', 'Dev', 1],
            [8, 'palvac@gmail.com', [], '123456789', 'Pal', 'Vac', 'Dev', NULL],
            [11, 'm.benkherrat@ecam-epmi.com', ["ROLE_SUPER_ADMIN"], '123456789', 'Moncef', 'Benkherrat', 'SuperAdmin', 2],
            [12, 'palomavacheron@gmail.com', [], '123456789', 'Paloma', 'Vn', 'Développeuse Web', 1],
            [17, 'Thérapeute désactivé numéro 17', [], '123456789', 'Thérapeute désactivé numéro 17', 'Thérapeute désactivé numéro 17', 'Dev', 1],
            [18, 'Thérapeute désactivé numéro 18', [], '123456789', 'Thérapeute désactivé numéro 18', 'Thérapeute désactivé numéro 18', 'Dev', 1],
            [20, 'Thérapeute désactivé numéro 20', [], '123456789', 'Thérapeute désactivé numéro 20', 'Thérapeute désactivé numéro 20', 'Dev', 1],
            [25, 'bleuechabani@gmail.com', ["ROLE_SUPER_ADMIN"], '$2y$13$gSuuOB/ZA1gmkfmcuNgL1.qSB0IMKlzJKWYnBB96nlhSs9C4huhBW', 'ZARGA', 'CHABANI', 'stagaire', 1]
        ];
        foreach ($dataTherapist as $row) {
            $therapist = new Therapist();
            $therapist->setId($row[0]);
            $therapist->setEmail($row[1]);
            $therapist->setRoles($row[2]);
            $password = $this->hasher->hashPassword($therapist, $row[3]);
            $therapist->setPassword($password);
            $therapist->setFirstName($row[4]);
            $therapist->setLastName($row[5]);
            $therapist->setJob($row[6]);
            $therapist->setInstitution($this->instRepo->findOneById($row[7]));
        }
        $manager->flush();

        // populate categories
        $dataCategory = [
            [1, 'Sujets', 'sujets.png', '2021-03-14 15:38:40', NULL],
            [2, 'Boissons', 'boissons.png', '2021-03-15 09:32:15', NULL],
            [3, 'Actions', 'actions.png', '2021-03-15 13:29:34', NULL],
            [4, 'Adjectifs', 'adjectifs.png', '2021-03-15 13:31:46', NULL],
            [5, 'Aliments', 'aliments.png', '2021-03-15 13:33:16', NULL],
            [6, 'Animaux', 'animaux.png', '2021-03-15 13:35:30', NULL],
            [7, 'Chiffres', 'chiffres.png', '2021-03-15 13:37:28', NULL],
            [8, 'Corps humain', 'corpsHumain.png', '2021-03-15 13:39:00', NULL],
            [9, 'Couleurs', 'couleurs.png', '2021-03-15 13:40:02', NULL],
            [10, 'Petits mots', 'determinants.png', '2021-03-15 13:41:46', NULL],
            [11, 'Émotions', 'emotions.png', '2021-03-15 13:44:12', NULL],
            [12, 'Fruits et légumes', 'fruitsEtLegumes.png', '2021-03-15 13:53:03', NULL],
            [13, 'Langues Des Signes', 'langueDesSignes.png', '2021-03-15 13:54:22', NULL],
            [14, 'Lieux', 'lieux.png', '2021-03-15 13:55:46', NULL],
            [15, 'Météo', 'meteo.png', '2021-03-15 13:57:23', NULL],
            [16, 'Multimédia', 'multimedia.png', '2021-03-15 13:58:40', NULL],
            [17, 'Objets', 'objets.png', '2021-03-15 14:00:05', NULL],
            [18, 'Personnes', 'personnes.png', '2021-03-15 14:01:55', NULL],
            [19, 'Scolarité', 'scolarite.png', '2021-03-15 14:03:29', NULL],
            [20, 'Transports', 'transports.png', '2021-03-15 14:05:23', NULL],
            [21, 'Vêtements', 'vetements.png', '2021-03-15 14:06:49', NULL],
            [22, 'Comportements', 'comportements.png', '2021-03-23 15:25:19', NULL],
            [23, 'Orientation', 'orientation.png', '2021-04-27 00:00:00', NULL],
            [24, 'Autres Mots', 'autresMots.png', '2021-04-27 00:04:00', NULL],
            [25, 'Formes', 'formes.png', '2021-05-16 03:00:00', NULL],
            [26, 'Sports', 'sports.png', '2022-04-16 10:07:57', NULL],
            [31, 'Sécurité Routière', 'securiteRoutiere.png', '2021-07-20 14:25:49', NULL],
            [33, 'Jouet', 'jouet.png', '2022-05-03 14:48:06', NULL],
            [36, 'Interrogatif', 'interrogatif.png', '2022-11-10 12:03:02', NULL],
            [37, 'Journee', 'Journee.png', '2022-11-10 12:05:14', NULL],
            [39, 'Heures', 'heures.png', '2022-11-11 10:38:35', NULL],
            [41, 'Couverts', 'couverts.png', '2022-11-22 14:54:44', NULL]
        ];
        foreach ($dataCategory as $row) {
            $category = new Category();
            $category->setId($row[0]);
            $category->setName($row[1]);
            $category->setFilename($row[2]);
            $category->setUpdateAt($this->formatDateTimeByString($row[3]));
            $category->setTherapist($this->therapistRepo->findOneById($row[4]));
        }
        $manager->flush();

        // populate subcategories
        $dataSubCat = [
            [3, 'École', 'ecole.png', '2021-06-28 15:27:18', 14, 1],
            [4, 'Maison', 'maison.png', '2021-06-29 10:27:21', 14, 1],
            [6, 'Magasins', 'magasins.png', '2021-07-21 13:43:47', 14, 1],
            [7, 'Famille', 'Famille.png', '2021-07-21 14:09:31', 18, 1],
            [8, 'Objets de la cuisine', 'objetsCuisine.png', '2021-07-26 07:34:30', 17, 1],
            [9, 'Objets de la salle de bain', 'objetsSalleDeBain.png', '2021-07-26 07:46:03', 17, 1],
            [10, 'Lettre A', 'A.png', '2021-07-27 09:25:22', 10, 1],
            [11, 'Lettre C', 'C.png', '2021-07-27 10:03:44', 10, 1],
            [12, 'Lettre D', 'D.png', '2021-07-27 10:04:12', 10, 1],
            [13, 'Lettre E', 'E.png', '2021-07-27 10:04:27', 10, 1],
            [14, 'Lettre L', 'L.png', '2021-07-27 10:04:48', 10, 1],
            [15, 'Lettre M', 'M.png', '2021-07-27 10:05:03', 10, 1],
            [16, 'Lettre N', 'N.png', '2021-07-27 10:05:27', 10, 1],
            [17, 'Lettre S', 'S.png', '2021-07-27 10:05:51', 10, 1],
            [18, 'Lettre T', 'T.png', '2021-07-27 10:06:19', 10, 1],
            [19, 'Lettre U', 'U.png', '2021-07-27 10:06:35', 10, 1],
            [20, 'Lettre V', 'V.png', '2021-07-27 10:06:48', 10, 1],
            [22, 'Magasin', 'magasins.png', '2022-12-09 16:07:40', 14, 25],
            [23, 'École', 'ecole.png', '2022-12-20 18:44:07', 14, 25],
            [24, 'maison', 'magasins.png', '2022-12-20 18:49:44', 14, 25],
            [25, 'Famille', 'famille.png', '2022-12-20 18:50:56', 18, 25],
            [26, 'maison', 'aquarium1.png', '2023-01-06 14:06:40', 14, 25],
            [27, 'bar', 'allerAuxToilettes.png', '2023-01-06 15:21:34', 14, 25]
        ];
        foreach ($dataSubCat as $row) {
            $subCat = new SubCategory();
            $subCat->setId($row[0]);
            $subCat->setName($row[1]);
            $subCat->setFilename($row[2]);
            $subCat->setUpdateAt($this->formatDateTimeByString($row[3]));
            $subCat->setCategoryId($this->catRepo->findOneById($row[4]));
            $subCat->setTherapist($this->therapistRepo->findOneById($row[5]));
        }
        $manager->flush();

        // populating pictograms
        $dataPicto = [
            [1, 'Je', 'je.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 13:07:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [2, 'Tu', 'tu.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:30:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [3, 'Il', 'il.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:34:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [4, 'Vous', 'vous.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:38:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [5, 'Nous', 'nous.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:40:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [6, 'Elle', 'elle.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-15 14:42:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [7, 'Eau', 'eau.png', 'féminin', 'eaux', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eau', 'eaux', 2, '2021-03-15 14:45:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [8, 'Chocolat chaud', 'chocolatChaud.png', 'masculin', 'chocolats chauds', NULL, NULL, NULL, NULL, NULL, NULL, 'chocolat chaud', 'chocolats chauds', NULL, NULL, 2, '2021-03-15 14:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [9, 'Jus d\'orange', 'jusDOrange.png', 'masculin', 'jus d\'orange', NULL, NULL, NULL, NULL, NULL, NULL, 'jus d\'orange', 'jus d\'orange', NULL, NULL, 2, '2021-03-15 14:51:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [10, 'Soda', 'soda.png', 'masculin', 'sodas', NULL, NULL, NULL, NULL, NULL, NULL, 'soda', 'sodas', NULL, NULL, 2, '2021-03-15 14:52:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [11, 'Jus de pomme', 'jusDePomme.png', 'masculin', 'jus de pomme', NULL, NULL, NULL, NULL, NULL, NULL, 'Jus de pomme', 'Jus de pomme', NULL, NULL, 2, '2021-03-15 14:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [12, 'Vouloir', 'vouloir.png', NULL, NULL, 'veux', 'veux', 'veut', 'voulons', 'voulez', 'veulent', NULL, NULL, NULL, NULL, 3, '2021-03-15 14:59:48', NULL, NULL, 'voudrai', 'voudras', 'voudra', 'voudrons', 'voudrez', 'voudront', 'ai voulu', 'as voulu', 'a voulu', 'avons voulu', 'avez voulu', 'ont voulu'],
            [13, 'Regarder', 'regarder.png', NULL, NULL, 'regarde', 'regardes', 'regarde', 'regardons', 'regardez', 'regardent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:04:19', NULL, NULL, 'regarderai', 'regarderas', 'regardera', 'regarderons', 'regarderez', 'regarderont', 'ai regardé', 'as regardé', 'a regardé', 'avons regardé', 'avez regardé', 'ont regardé'],
            [15, 'Boire', 'boire.png', NULL, NULL, 'bois', 'bois', 'boit', 'buvons', 'buvez', 'boivent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:13:11', NULL, NULL, 'boirai', 'boiras', 'boira', 'boirons', 'boirez', 'boiront', 'ai bu', 'as bu', 'a bu', 'avons bu', 'avez bu', 'ont bu'],
            [16, 'Manger', 'manger.png', NULL, NULL, 'mange', 'manges', 'mange', 'mangeons', 'mangez', 'mangent', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:15:28', NULL, NULL, 'mangerai', 'mangeras', 'mangera', 'mangerons', 'mangerez', 'mangeront', 'ai mangé', 'as mangé', 'a mangé', 'avons mangé', 'avez mangé', 'ont mangé'],
            [17, 'Aller', 'aller.png', NULL, NULL, 'vais', 'vas', 'va', 'allons', 'allez', 'vont', NULL, NULL, NULL, NULL, 3, '2021-03-15 15:18:29', NULL, NULL, 'irai', 'iras', 'ira', 'irons', 'irez', 'iront', 'suis allé', 'es allé', 'est allé', 'sommes allés', 'êtes allés', 'sont allés'],
            [18, 'Court', 'court.png', 'masculin', 'courts', NULL, NULL, NULL, NULL, NULL, NULL, 'court', 'courts', 'courte', 'courtes', 4, '2021-03-15 15:21:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [19, 'Petit', 'petit.png', 'masculin', 'petits', NULL, NULL, NULL, NULL, NULL, NULL, 'petit', 'petits', 'petite', 'petites', 4, '2021-03-15 15:24:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [20, 'Grand', 'grand.png', 'masculin', 'grands', NULL, NULL, NULL, NULL, NULL, NULL, 'grand', 'grands', 'grande', 'grandes', 4, '2021-03-15 15:27:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [21, 'Long', 'long.png', 'masculin', 'longs', NULL, NULL, NULL, NULL, NULL, NULL, 'long', 'longs', 'longue', 'longues', 4, '2021-03-15 15:29:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [22, 'Correct', 'correct.png', 'masculin', 'corrects', NULL, NULL, NULL, NULL, NULL, NULL, 'correct', 'corrects', 'correcte', 'correctes', 4, '2021-03-15 15:33:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [23, 'Incorrect', 'incorrect.png', 'masculin', 'incorrects', NULL, NULL, NULL, NULL, NULL, NULL, 'incorrect', 'incorrects', 'incorrecte', 'incorrectes', 4, '2021-03-15 15:35:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [24, 'Céréales', 'cereales.png', 'féminin', 'céréales', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'céréale', 'céréales', 5, '2021-03-15 15:39:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [25, 'Dessert', 'dessert.png', 'masculin', 'desserts', NULL, NULL, NULL, NULL, NULL, NULL, 'dessert', 'desserts', NULL, NULL, 5, '2021-03-15 15:41:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [26, 'Gâteau', 'gateaux.png', 'masculin', 'gâteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'gâteau', 'gâteaux', NULL, NULL, 5, '2021-03-15 15:44:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [27, 'Glace', 'glace.png', 'féminin', 'glaces', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'glace', 'glaces', 5, '2021-03-15 15:45:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [28, 'Riz', 'riz.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'riz', 'riz', NULL, NULL, 5, '2021-03-15 15:47:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [29, 'Chat', 'chat.png', 'masculin', 'chats', NULL, NULL, NULL, NULL, NULL, NULL, 'chat', 'chats', 'chatte', 'chattes', 6, '2021-03-15 18:06:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [30, 'Chien', 'chien.png', 'masculin', 'chiens', NULL, NULL, NULL, NULL, NULL, NULL, 'chien', 'chiens', 'chienne', 'chiennes', 6, '2021-03-15 18:08:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [31, 'Lapin', 'lapin.png', 'masculin', 'lapins', NULL, NULL, NULL, NULL, NULL, NULL, 'lapin', 'lapins', 'lapine', 'lapines', 6, '2022-11-23 10:22:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [32, 'Oiseau', 'oiseau.png', 'masculin', 'oiseaux', NULL, NULL, NULL, NULL, NULL, NULL, 'oiseau', 'oiseaux', 'oiselle', 'oiselles', 6, '2021-03-15 18:18:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [33, 'Poisson', 'poissons.png', 'masculin', 'poissons', NULL, NULL, NULL, NULL, NULL, NULL, 'poisson', 'poissons', NULL, NULL, 6, '2021-03-15 18:22:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [34, 'Un', 'un.png', 'masculin', 'uns', NULL, NULL, NULL, NULL, NULL, NULL, 'un', 'uns', 'une', 'unes', 7, '2021-03-15 18:36:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [35, 'Deux', 'deux.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'deux', NULL, NULL, NULL, 7, '2021-03-15 18:41:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [36, 'Zéro', 'zero.png', 'masculin', 'zéros', NULL, NULL, NULL, NULL, NULL, NULL, 'zéro', 'zéros', NULL, NULL, 7, '2021-03-15 18:44:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [37, 'Trois', 'trois.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trois', NULL, NULL, NULL, 7, '2021-03-15 18:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [38, 'Quatre', 'quatre.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'quatre', NULL, NULL, NULL, 7, '2021-03-15 18:52:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [39, 'Bouche', 'bouche.png', 'féminin', 'bouches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bouche', 'bouches', 8, '2021-03-15 19:16:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [40, 'Mains', 'mains.png', 'féminin', 'mains', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'main', 'mains', 8, '2021-03-15 19:22:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [41, 'Nez', 'nez.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nez', 'nez', NULL, NULL, 8, '2021-03-15 19:26:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [42, 'Pieds', 'pieds.png', 'masculin', 'pieds', NULL, NULL, NULL, NULL, NULL, NULL, 'pied', 'pieds', NULL, NULL, 8, '2021-03-15 19:27:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [43, 'Oreille', 'oreille.png', 'féminin', 'oreilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'oreille', 'oreilles', 8, '2021-03-15 19:30:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [44, 'Blanc', 'blanc.png', 'masculin', 'blancs', NULL, NULL, NULL, NULL, NULL, NULL, 'blanc', 'blancs', 'blanche', 'blanches', 9, '2021-03-15 21:24:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [45, 'Bleu', 'bleu.png', 'masculin', 'bleus', NULL, NULL, NULL, NULL, NULL, NULL, 'bleu', 'bleus', 'bleue', 'bleues', 9, '2021-03-15 21:27:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [46, 'Rouge', 'rouge.png', 'masculin', 'rouges', NULL, NULL, NULL, NULL, NULL, NULL, 'rouge', 'rouges', 'rouge', 'rouges', 9, '2021-03-15 21:30:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [47, 'Vert', 'vert.png', 'masculin', 'verts', NULL, NULL, NULL, NULL, NULL, NULL, 'vert', 'verts', 'verte', 'vertes', 9, '2021-03-15 21:33:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [48, 'Rose', 'rose.png', 'masculin', 'roses', NULL, NULL, NULL, NULL, NULL, NULL, 'rose', 'roses', 'rose', 'roses', 9, '2021-03-15 21:36:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [49, 'De', 'de.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:47:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [50, 'Des', 'des.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:48:13', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [51, 'Et', 'et.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:50:00', NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [52, 'Mon', 'mon.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:51:31', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [53, 'Ce', 'ce.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-15 21:52:59', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [54, 'Colère', 'colere.png', 'féminin', 'colères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'colère', 'colères', 11, '2021-03-15 21:56:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [55, 'Curieux', 'curieux.png', 'masculin', 'curieux', NULL, NULL, NULL, NULL, NULL, NULL, 'curieux', 'curieux', 'curieuse', 'curieuses', 11, '2021-03-15 21:59:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [56, 'Inquiet', 'inquiet.png', 'masculin', 'inquiets', NULL, NULL, NULL, NULL, NULL, NULL, 'inquiet', 'inquiets', 'inquiète', 'inquiètes', 11, '2021-03-15 22:03:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [57, 'Joyeux', 'joyeux.png', 'masculin', 'joyeux', NULL, NULL, NULL, NULL, NULL, NULL, 'joyeux', 'joyeux', 'joyeuse', 'joyeuses', 11, '2021-03-15 22:06:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [58, 'Peur', 'peur.png', 'féminin', 'peurs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'peur', 'peurs', 11, '2021-03-15 22:09:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [59, 'Banane', 'banane.png', 'féminin', 'bananes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'banane', 'bananes', 12, '2021-03-15 22:12:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [60, 'Carotte', 'carotte.png', 'féminin', 'carottes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carotte', 'carottes', 12, '2021-03-15 22:15:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [61, 'Fraise', 'fraise.png', 'féminin', 'fraises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fraise', 'fraises', 12, '2021-03-15 22:18:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [62, 'Orange', 'orange.png', 'féminin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'orange', 'oranges', 12, '2021-03-15 22:20:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [63, 'Pomme de terre', 'pommeDeTerre.png', 'féminin', 'pommes de terre', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pomme de terre', 'pommes de terre', 12, '2021-03-15 22:22:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [64, 'Cuisine', 'cuisine.png', 'féminin', 'cuisines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cuisine', 'cuisines', NULL, '2021-03-16 08:36:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [65, 'École', 'ecole.png', 'féminin', 'écoles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'école', 'écoles', NULL, '2021-03-16 08:38:41', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [66, 'Hôpital', 'hopital.png', 'masculin', 'hôpitaux', NULL, NULL, NULL, NULL, NULL, NULL, 'hôpital', 'hôpitaux', NULL, NULL, 14, '2021-03-16 08:40:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [67, 'Salle de bain', 'salleDeBain.png', 'féminin', 'salles de bains', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'salle de bain', 'salles de bains', NULL, '2021-03-16 08:42:14', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [68, 'Gare', 'gare.png', 'féminin', 'gares', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gare', 'gares', 14, '2021-03-16 08:43:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [69, 'Soleil', 'soleil.png', 'masculin', 'soleils', NULL, NULL, NULL, NULL, NULL, NULL, 'soleil', 'soleils', NULL, NULL, 15, '2021-03-16 08:45:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [70, 'Venteux', 'venteux.png', 'masculin', 'venteux', NULL, NULL, NULL, NULL, NULL, NULL, 'venteux', 'venteux', 'venteuse', 'venteuses', 15, '2021-03-16 08:48:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [71, 'Nuage', 'nuage.png', 'masculin', 'nuages', NULL, NULL, NULL, NULL, NULL, NULL, 'nuage', 'nuages', NULL, NULL, 15, '2021-03-16 08:49:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [72, 'Pluvieux', 'pluvieux.png', 'masculin', 'pluvieux', NULL, NULL, NULL, NULL, NULL, NULL, 'pluvieux', 'pluvieux', 'pluvieuse', 'pluvieuses', 15, '2021-03-16 08:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [73, 'Gelée', 'gelee.png', 'féminin', 'gelée', NULL, NULL, NULL, NULL, NULL, NULL, 'gelé', 'gelés', 'gelée', 'gelées', 15, '2021-03-16 08:53:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [74, 'Téléphone portable', 'telephonePortable.png', 'masculin', 'téléphones portable', NULL, NULL, NULL, NULL, NULL, NULL, 'téléphone portable', 'téléphones portables', NULL, NULL, 16, '2021-03-16 08:55:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [75, 'Télévision', 'television.png', 'féminin', 'télévisions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'télévision', 'télévisions', 16, '2021-03-16 08:57:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [76, 'Ordinateur', 'ordinateur.png', 'masculin', 'ordinateurs', NULL, NULL, NULL, NULL, NULL, NULL, 'ordinateur', 'ordinateurs', NULL, NULL, 16, '2021-03-16 08:58:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [77, 'Ordinateur portable', 'ordinateurPortable.png', 'masculin', 'ordinateurs portables', NULL, NULL, NULL, NULL, NULL, NULL, 'ordinateur portable', 'ordinateurs portables', NULL, NULL, 16, '2021-03-16 08:59:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [78, 'Console', 'console.png', 'féminin', 'consoles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'console', 'consoles', 16, '2021-03-16 09:00:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [79, 'Bande dessinée', 'bandeDessinee.png', 'féminin', 'bandes dessinées', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bande dessinée', 'bandes dessinées', 17, '2021-03-16 09:16:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [80, 'Brosse à dents', 'brosseADents.png', 'féminin', 'brosses à dents', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'brosse à dents', 'brosses à dents', NULL, '2021-03-16 09:18:04', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [81, 'Couteau', 'couteau.png', 'masculin', 'couteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'couteau', 'couteaux', NULL, NULL, NULL, '2021-03-16 09:19:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [82, 'Cuillère', 'cuillere.png', 'féminin', 'cuillères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cuillère', 'cuillères', NULL, '2021-03-16 09:20:34', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [83, 'Fourchette', 'fourchette.png', 'féminin', 'fourchettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fourchette', 'fourchettes', NULL, '2021-03-16 09:22:43', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [84, 'Table', 'table.png', 'féminin', 'tables', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'table', 'tables', 17, '2021-03-16 09:24:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [85, 'Médecin', 'medecin.png', 'masculin', 'médecins', NULL, NULL, NULL, NULL, NULL, NULL, 'médecin', 'médecins', 'médecin', 'médecins', 18, '2021-03-16 09:26:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [86, 'Grand-mère', 'grandMere.png', 'féminin', 'grands-mères', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'grand-mère', 'grand-mères', NULL, '2021-03-16 09:30:38', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [87, 'Orthophoniste', 'orthophoniste.png', 'masculin', 'orthophonistes', NULL, NULL, NULL, NULL, NULL, NULL, 'orthophoniste', 'orthophonistes', 'orthophoniste', 'orthophonistes', 18, '2021-03-16 09:33:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [88, 'Professeur', 'professeur.png', 'masculin', 'professeurs', NULL, NULL, NULL, NULL, NULL, NULL, 'professeur', 'professeurs', 'professeure', 'professeures', 18, '2021-03-16 09:36:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [89, 'Papa', 'papa.png', 'masculin', 'papas', NULL, NULL, NULL, NULL, NULL, NULL, 'papa', 'papas', NULL, NULL, NULL, '2021-03-16 09:37:41', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [90, 'Cahier', 'cahier.png', 'masculin', 'cahiers', NULL, NULL, NULL, NULL, NULL, NULL, 'cahier', 'cahiers', NULL, NULL, 19, '2021-03-16 09:39:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [91, 'Crayon', 'crayon.png', 'masculin', 'crayons', NULL, NULL, NULL, NULL, NULL, NULL, 'crayon', 'crayons', NULL, NULL, 19, '2021-03-16 09:40:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [92, 'Gomme', 'gomme.png', 'féminin', 'gommes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'gomme', 'gommes', 19, '2021-03-16 09:42:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [93, 'Règle', 'regle.png', 'féminin', 'règles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'règle', 'règles', 19, '2021-03-16 09:43:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [94, 'Stylo', 'stylo.png', 'masculin', 'stylos', NULL, NULL, NULL, NULL, NULL, NULL, 'stylo', 'stylos', NULL, NULL, 19, '2021-03-16 09:44:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [95, 'Ambulance', 'ambulance.png', 'féminin', 'ambulances', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ambulance', 'ambulances', 20, '2021-03-16 09:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [96, 'Avion', 'avion.png', 'masculin', 'avions', NULL, NULL, NULL, NULL, NULL, NULL, 'avion', 'avions', NULL, NULL, 20, '2021-03-16 09:47:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [97, 'Métro', 'metro.png', 'masculin', 'métros', NULL, NULL, NULL, NULL, NULL, NULL, 'métro', 'métros', NULL, NULL, 20, '2021-03-16 09:48:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [98, 'Taxi', 'taxi.png', 'masculin', 'taxis', NULL, NULL, NULL, NULL, NULL, NULL, 'taxi', 'taxis', NULL, NULL, 20, '2021-03-16 09:49:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [99, 'Train', 'train.png', 'masculin', 'trains', NULL, NULL, NULL, NULL, NULL, NULL, 'train', 'trains', NULL, NULL, 20, '2021-03-16 09:51:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [100, 'Chaussettes', 'chaussettes.png', 'féminin', 'chaussettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaussette', 'chaussettes', 21, '2021-03-16 09:53:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [101, 'Chaussures', 'chaussures.png', 'féminin', 'chaussures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaussure', 'chaussures', 21, '2021-03-16 09:54:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [102, 'Manteau', 'manteau.png', 'masculin', 'manteaux', NULL, NULL, NULL, NULL, NULL, NULL, 'manteau', 'manteaux', NULL, NULL, 21, '2021-03-16 09:55:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [103, 'Pantalon', 'pantalon.png', 'masculin', 'pantalons', NULL, NULL, NULL, NULL, NULL, NULL, 'pantalon', 'pantalons', NULL, NULL, 21, '2021-03-16 09:57:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [104, 'Tee-shirt', 'teeShirt.png', 'masculin', 'tee-shirts', NULL, NULL, NULL, NULL, NULL, NULL, 'tee-shirt', 'tee-shirts', NULL, NULL, 21, '2021-03-16 10:00:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [105, 'Avoir', 'avoir.png', NULL, NULL, 'ai', 'as', 'a', 'avons', 'avez', 'ont', NULL, NULL, NULL, NULL, 3, '2021-03-17 12:17:07', NULL, NULL, 'aurai', 'auras', 'aura', 'aurons', 'aurez', 'auront', 'ai eu', 'as eu', 'a eu', 'avons eu', 'avez eu', 'ont eu'],
            [106, 'Eux', 'eux.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-18 13:07:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [107, 'Moi', 'moi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2021-03-18 13:08:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [108, 'Café', 'cafe.png', 'masculin', 'cafés', NULL, NULL, NULL, NULL, NULL, NULL, 'café', 'cafés', NULL, NULL, 2, '2021-03-18 14:45:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [109, 'Eau du robinet', 'eauDuRobinet.png', 'féminin', 'eaux du robinet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eau du robinet', 'eaux du robinet', 2, '2021-03-18 14:46:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [110, 'Jus de raisin', 'jusDeRaisin.png', 'masculin', 'jus de raisin', NULL, NULL, NULL, NULL, NULL, NULL, 'jus de raisin', 'jus de raisin', NULL, NULL, 2, '2021-03-18 14:54:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [111, 'Lait', 'lait.png', 'masculin', 'laits', NULL, NULL, NULL, NULL, NULL, NULL, 'lait', 'laits', NULL, NULL, 2, '2021-03-18 14:55:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [112, 'Limonade', 'limonade.png', 'féminin', 'limonades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'limonade', 'limonades', 2, '2021-03-18 14:56:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [113, 'Aller aux toilettes', 'allerAuxToilettes.png', NULL, NULL, 'vais aux toilettes', 'vas aux toilettes', 'va aux toilettes', 'allons aux toilettes', 'allez aux toilettes', 'vont aux toilettes', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:18:29', NULL, NULL, 'irai aux toilettes', 'iras aux toilettes', 'ira aux toilettes', 'irons aux toilettes', 'irez aux toilettes', 'iront aux toilettes', 'suis allé aux toilettes', 'es allé aux toilettes', 'est allé aux toilettes', 'sommes allés aux toilettes', 'êtes allés aux toilettes', 'sont allés aux toilettes'],
            [114, 'Couper', 'couper.png', NULL, NULL, 'coupe', 'coupes', 'coupe', 'coupons', 'coupez', 'coupent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:24:19', NULL, NULL, 'couperai', 'couperas', 'coupera', 'couperons', 'couperez', 'couperont', 'ai coupé', 'as coupé', 'a coupé', 'avons coupé', 'avez coupé', 'ont coupé'],
            [115, 'Courir', 'courir.png', NULL, NULL, 'cours', 'cours', 'court', 'courons', 'courez', 'courent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:25:19', NULL, NULL, 'courrai', 'courras', 'courra', 'courrons', 'courrez', 'courront', 'ai couru', 'as couru', 'a couru', 'avons couru', 'avez couru', 'ont couru'],
            [116, 'Descendre', 'descendre.png', NULL, NULL, 'descends', 'descends', 'descend', 'descendons', 'descendez', 'descendent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:26:19', NULL, NULL, 'descendrai', 'descendras', 'descendra', 'descendrons', 'descendrez', 'descendront', 'ai descendu', 'as descendu', 'a descendu', 'avons descendu', 'avez descendu', 'ont descendu'],
            [117, 'Dessiner', 'dessiner.png', NULL, NULL, 'dessine', 'dessines', 'dessine', 'dessinons', 'dessinez', 'dessinent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:27:19', NULL, NULL, 'dessinerai', 'dessineras', 'dessinera', 'dessinerons', 'dessinerez', 'dessineront', 'ai dessiné', 'as dessiné', 'a dessiné', 'avons dessiné', 'avez dessiné', 'ont dessiné'],
            [118, 'Écouter', 'ecouter.png', NULL, NULL, 'écoute', 'écoutes', 'écoute', 'écoutons', 'écoutez', 'écoutent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:28:19', NULL, NULL, 'écouterai', 'écouteras', 'écoutera', 'écouterons', 'écouterez', 'écouteront', 'ai écouté', 'as écouté', 'a écouté', 'avons écouté', 'avez écouté', 'ont écouté'],
            [119, 'Écrire', 'ecrire.gif', NULL, NULL, 'écris', 'écris', 'écrit', 'écrivons', 'écrivez', 'écrivent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:29:19', NULL, NULL, 'écrirai', 'écriras', 'écrira', 'écrirons', 'écrirez', 'écriront', 'ai écrit', 'as écrit', 'a écrit', 'avons écrit', 'avez écrit', 'ont écrit'],
            [120, 'Être', 'etre.png', NULL, NULL, 'suis', 'es', 'est', 'sommes', 'êtes', 'sont', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:30:19', NULL, NULL, 'serai', 'seras', 'sera', 'serons', 'serez', 'seront', 'ai été', 'as été', 'a été', 'avons été', 'avez été', 'ont été'],
            [121, 'Jouer', 'jouer.png', NULL, NULL, 'joue', 'joues', 'joue', 'jouons', 'jouez', 'jouent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:31:19', NULL, NULL, 'jouerai', 'joueras', 'jouera', 'jouerons', 'jouerez', 'joueront', 'ai joué', 'as joué', 'a joué', 'avons joué', 'avez joué', 'ont joué'],
            [122, 'Laver le linge', 'laverLeLinge.png', NULL, NULL, 'lave le linge', 'laves le linge', 'lave le linge', 'lavons le linge', 'lavez le linge', 'lavent le linge', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:32:19', NULL, NULL, 'laverai le linge', 'laveras le linge', 'lavera le linge', 'laverons le linge', 'laverez le linge', 'laveront le linge', 'ai lavé le linge', 'as lavé le linge', 'a lavé le linge', 'avons lavé le linge', 'avez lavé le linge', 'ont lavé le linge'],
            [123, 'Laver les dents', 'laverLesDents.png', NULL, NULL, 'lave les dents', 'laves les dents', 'lave les dents', 'lavons les dents', 'lavez les dents', 'lavent les dents', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:33:19', NULL, NULL, 'laverai les dents', 'laveras les dents', 'lavera les dents', 'laverons les dents', 'laverez les dents', 'laveront les dents', 'ai lavé les dents', 'as lavé les dents', 'a lavé les dents', 'avons lavé les dents', 'avez lavé les dents', 'ont lavé les dents'],
            [124, 'Laver', 'laver.png', NULL, NULL, 'lave', 'laves', 'lave', 'lavons', 'lavez', 'lavent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:34:19', NULL, NULL, 'laverai', 'laverai', 'lavera', 'laverons', 'laverez', 'laveront', 'ai lavé', 'as lavé', 'a lavé', 'avons lavé', 'avez lavé', 'ont lavé'],
            [125, 'Lire', 'lire.png', NULL, NULL, 'lis', 'lis', 'lit', 'lisons', 'lisez', 'lisent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:35:19', NULL, NULL, 'lirai', 'liras', 'lira', 'lirons', 'lirez', 'liront', 'ai lu', 'as lu', 'a lu', 'avons lu', 'avez lu', 'ont lu'],
            [126, 'Monter', 'monter.png', NULL, NULL, 'monte', 'montes', 'monte', 'montons', 'montez', 'montent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:36:19', NULL, NULL, 'monterai', 'monteras', 'montera', 'monterons', 'monterez', 'monteront', 'ai monté', 'as monté', 'a monté', 'avons monté', 'avez monté', 'ont monté'],
            [127, 'Se moucher', 'moucher.png', NULL, NULL, 'me mouche', 'te mouches', 'se mouche', 'nous mouchons', 'vous mouchez', 'se mouchent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:37:19', NULL, NULL, 'me moucherai', 'te moucheras', 'se mouchera', 'nous moucherons', 'vous moucherez', 'se moucheront', 'me suis mouché', 't\'es mouché', 's\'est mouché', 'nous sommes mouchés', 'vous êtes mouchés', 'se sont mouchés'],
            [128, 'Nager', 'nager.png', NULL, NULL, 'nage', 'nages', 'nage', 'nageons', 'nagez', 'nagent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:38:19', NULL, NULL, 'nagerai', 'nageras', 'nagera', 'nagerons', 'nagerez', 'nageront', 'ai nagé', 'as nagé', 'a nagé', 'avons nagé', 'avez nagé', 'ont nagé'],
            [129, 'Prendre un bain', 'prendreUnBain.png', NULL, NULL, 'prends un bain', 'prends un bain', 'prend un bain', 'prenons un bain', 'prenez un bain', 'prennent un bain', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:39:19', NULL, NULL, 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'ai pris un bain', 'as pris un bain', 'a pris un bain', 'avons pris un bain', 'avez pris un bain', 'ont pris un bain'],
            [130, 'Regarder la télévision', 'regarderLaTelevision.png', NULL, NULL, 'regarde la télévision', 'regardes la télévision', 'regarde la télévision', 'regardons la télévision', 'regardez la télévision', 'regardent la télévision', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:40:19', NULL, NULL, 'regarderai la télévision', 'regarderas la télévision', 'regardera la télévision', 'regarderons la télévision', 'regarderez la télévision', 'regarderont la télévision', 'ai regardé la télévision', 'as regardé la télévision', 'a regardé la télévision', 'avons regardé la télévision', 'avez regardé la télévision', 'ont regardé la télévision'],
            [131, 'Remplir', 'remplir.png', NULL, NULL, 'remplis', 'remplis', 'remplit', 'remplissons', 'remplissez', 'remplissent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:41:19', NULL, NULL, 'remplirai', 'rempliras', 'remplira', 'remplirons', 'remplirez', 'rempliront', 'ai rempli', 'as rempli', 'a rempli', 'avons rempli', 'avez rempli', 'ont rempli'],
            [132, 'Renverser', 'renverser.png', NULL, NULL, 'renverse', 'renverses', 'renverse', 'renversons', 'renversez', 'renversent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:42:19', NULL, NULL, 'renverserai', 'renverseras', 'renversera', 'renverserons', 'renverserez', 'renverseront', 'ai renversé', 'as renversé', 'a renversé', 'avons renversé', 'avez renversé', 'ont renversé'],
            [133, 'S\'habiller', 'sHabiller.png', NULL, NULL, 'm\'habille', 't\'habilles', 's\'habille', 'nous habillons', 'vous habillez', 's\'habillent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:43:19', NULL, NULL, 'm\'habillerai', 't\'habilleras', 's\'habillera', 'nous habillerons', 'vous habillerez', 's\'habilleront', 'me suis habillé', 't\'es habillé', 's\'est habillé', 'nous sommes habillés', 'vous êtes habillés', 'se sont habillés'],
            [134, 'Salir', 'salir.png', NULL, NULL, 'salis', 'salis', 'salit', 'salissons', 'salissez', 'salissent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:44:19', NULL, NULL, 'salirai', 'saliras', 'salira', 'salirons', 'salirez', 'saliront', 'ai sali', 'as sali', 'a sali', 'avons sali', 'avez sali', 'ont sali'],
            [135, 'Se déshabiller', 'seDeshabiller.png', NULL, NULL, 'me déshabille', 'te déshabilles', 'se déshabille', 'nous déshabillons', 'vous déshabillez', 'se déshabillent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:45:19', NULL, NULL, 'me déshabillerai', 'te déshabilleras', 'se déshabillera', 'nous déshabillerons', 'vous déshabillerez', 'se déshabilleront', 'me suis déshabillé', 't\'es déshabillé', 's\'est déshabillé', 'nous sommes déshabillés', 'vous êtes déshabillés', 'se sont déshabillés'],
            [136, 'Siffler', 'siffler.png', NULL, NULL, 'siffle', 'siffles', 'siffle', 'sifflons', 'sifflez', 'sifflent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:46:19', NULL, NULL, 'sifflerai', 'siffleras', 'sifflera', 'sifflerons', 'sifflerez', 'siffleront', 'ai sifflé', 'as sifflé', 'a sifflé', 'avons sifflé', 'avez sifflé', 'ont sifflé'],
            [137, 'Téléphoner', 'telephoner.png', NULL, NULL, 'téléphone', 'téléphones', 'téléphone', 'téléphonons', 'téléphonez', 'téléphonent', NULL, NULL, NULL, NULL, 3, '2021-03-18 15:47:19', NULL, NULL, 'téléphonerai', 'téléphoneras', 'téléphonera', 'téléphonerons', 'téléphonerez', 'téléphoneront', 'ai téléphoné', 'as téléphoné', 'a téléphoné', 'avons téléphoné', 'avez téléphoné', 'ont téléphoné'],
            [138, 'Accompagnée', 'accompagnee.png', 'féminin', 'accompagnées', NULL, NULL, NULL, NULL, NULL, NULL, 'accompagné', 'accompagnés', 'accompagnée', 'accompagnées', 4, '2021-03-19 15:21:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [139, 'Cassé', 'casse.png', 'masculin', 'cassés', NULL, NULL, NULL, NULL, NULL, NULL, 'cassé', 'cassés', 'cassée', 'cassées', 4, '2021-03-19 15:22:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [140, 'Coiffée', 'coiffee.png', 'féminin', 'coiffées', NULL, NULL, NULL, NULL, NULL, NULL, 'coiffé', 'coiffés', 'coiffée', 'coiffées', 4, '2021-03-19 15:23:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [141, 'Décoiffé', 'décoiffe.png', 'masculin', 'décoiffés', NULL, NULL, NULL, NULL, NULL, NULL, 'décoiffé', 'décoiffés', 'décoiffée', 'décoiffées', 4, '2021-03-19 15:24:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [142, 'Dernier', 'dernier.png', 'masculin', 'derniers', NULL, NULL, NULL, NULL, NULL, NULL, 'dernier', 'derniers', 'dernière', 'dernières', 4, '2021-03-19 15:25:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [143, 'Deuxième', 'deuxieme.png', 'masculin', 'deuxièmes', NULL, NULL, NULL, NULL, NULL, NULL, 'deuxième', 'deuxièmes', 'deuxième', 'deuxièmes', 4, '2021-03-19 15:26:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [144, 'Étroit', 'etroit.png', 'masculin', 'étroits', NULL, NULL, NULL, NULL, NULL, NULL, 'étroit', 'étroits', 'étroite', 'étroites', 4, '2021-03-19 15:27:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [145, 'Fermé', 'ferme.png', 'masculin', 'fermés', NULL, NULL, NULL, NULL, NULL, NULL, 'fermé', 'fermés', 'fermée', 'fermées', 4, '2021-03-19 15:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [146, 'Gros', 'gros.png', 'masculin', 'gros', NULL, NULL, NULL, NULL, NULL, NULL, 'gros', 'gros', 'grosse', 'grosses', 4, '2021-03-19 15:29:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [147, 'Large', 'large.png', 'masculin', 'larges', NULL, NULL, NULL, NULL, NULL, NULL, 'large', 'larges', 'large', 'larges', 4, '2021-03-19 15:30:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [148, 'Lent', 'lent.png', 'masculin', 'lents', NULL, NULL, NULL, NULL, NULL, NULL, 'lent', 'lents', 'lente', 'lentes', 4, '2021-03-19 15:31:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [149, 'Mince', 'mince.png', 'masculin', 'minces', NULL, NULL, NULL, NULL, NULL, NULL, 'mince', 'minces', 'mince', 'minces', 4, '2021-03-19 15:32:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [150, 'Mouillé', 'mouille.png', 'masculin', 'mouillés', NULL, NULL, NULL, NULL, NULL, NULL, 'mouillé', 'mouillés', 'mouillée', 'mouillées', 4, '2021-03-19 15:33:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [151, 'Ouvert', 'ouvert.png', 'masculin', 'ouverts', NULL, NULL, NULL, NULL, NULL, NULL, 'ouvert', 'ouverts', 'ouverte', 'ouvertes', 4, '2021-03-19 15:34:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [152, 'Premier', 'premier.png', 'masculin', 'premiers', NULL, NULL, NULL, NULL, NULL, NULL, 'premier', 'premiers', 'première', 'premières', 4, '2021-03-19 15:35:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [153, 'Sec', 'sec.png', 'masculin', 'secs', NULL, NULL, NULL, NULL, NULL, NULL, 'sec', 'secs', 'sèche', 'sèches', 4, '2021-03-19 15:36:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [154, 'Seul', 'seul.png', 'masculin', 'seuls', NULL, NULL, NULL, NULL, NULL, NULL, 'seul', 'seuls', 'seule', 'seules', 4, '2021-03-19 15:37:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [155, 'Vide', 'vide.png', 'masculin', 'vides', NULL, NULL, NULL, NULL, NULL, NULL, 'vide', 'vides', 'vide', 'vides', 4, '2021-03-19 15:38:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [156, 'Beurre', 'beurre.png', 'masculin', 'beurres', NULL, NULL, NULL, NULL, NULL, NULL, 'beurre', 'beurres', NULL, NULL, 5, '2021-03-19 15:45:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [157, 'Chocolat', 'chocolat.png', 'masculin', 'chocolats', NULL, NULL, NULL, NULL, NULL, NULL, 'chocolat', 'chocolats', NULL, NULL, 5, '2021-03-19 15:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [158, 'Confiture', 'confiture.png', 'féminin', 'confitures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'confiture', 'confitures', 5, '2021-03-19 15:49:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [159, 'Pâtes', 'pates.png', 'féminin', 'pâtes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pâtes', 5, '2021-03-19 15:50:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [160, 'Farine', 'farine.png', 'féminin', 'farines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'farine', 'farines', 5, '2021-03-19 15:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [161, 'Flan', 'flan.png', 'masculin', 'flans', NULL, NULL, NULL, NULL, NULL, NULL, 'flan', 'flans', NULL, NULL, 5, '2021-03-19 15:52:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [162, 'Fromage', 'fromage.png', 'masculin', 'fromages', NULL, NULL, NULL, NULL, NULL, NULL, 'fromage', 'fromages', NULL, NULL, 5, '2021-03-19 15:53:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [163, 'Jambon', 'jambon.png', 'masculin', 'jambons', NULL, NULL, NULL, NULL, NULL, NULL, 'jambon', 'jambons', NULL, NULL, 5, '2021-03-19 15:54:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [164, 'Miel', 'miel.png', 'masculin', 'miels', NULL, NULL, NULL, NULL, NULL, NULL, 'miel', 'miels', NULL, NULL, 5, '2021-03-19 15:55:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [165, 'Moutarde', 'moutarde.png', 'féminin', 'moutardes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moutarde', 'moutardes', 5, '2021-03-19 15:56:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [166, 'Oeufs', 'oeufs.png', 'masculin', 'oeufs', NULL, NULL, NULL, NULL, NULL, NULL, 'oeuf', 'oeufs', NULL, NULL, 5, '2021-03-19 15:57:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [167, 'Pain', 'pain.png', 'masculin', 'pains', NULL, NULL, NULL, NULL, NULL, NULL, 'pain', 'pains', NULL, NULL, 5, '2021-03-19 15:58:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [168, 'Petit pot', 'petitPot.png', 'masculin', 'petits pots', NULL, NULL, NULL, NULL, NULL, NULL, 'petit pot', 'petits pots', NULL, NULL, 5, '2021-03-19 15:59:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [169, 'Poisson', 'poisson.png', 'masculin', 'poisson', NULL, NULL, NULL, NULL, NULL, NULL, 'poisson', 'poissons', NULL, NULL, 5, '2021-03-20 14:39:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [170, 'Poivre', 'poivre.png', 'masculin', 'poivres', NULL, NULL, NULL, NULL, NULL, NULL, 'poivre', 'poivres', NULL, NULL, 5, '2021-03-20 14:40:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [171, 'Poulet', 'poulet.png', 'masculin', 'poulets', NULL, NULL, NULL, NULL, NULL, NULL, 'poulet', 'poulets', NULL, NULL, 5, '2021-03-20 14:41:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [172, 'Sandwich', 'sandwich.png', 'masculin', 'sandwichs', NULL, NULL, NULL, NULL, NULL, NULL, 'sandwich', 'sandwichs', NULL, NULL, 5, '2021-03-20 14:42:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [173, 'Ketchup', 'ketchup.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ketchup', NULL, NULL, NULL, 5, '2021-03-20 14:43:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [174, 'Sel', 'sel.png', 'masculin', 'sels', NULL, NULL, NULL, NULL, NULL, NULL, 'sel', 'sels', NULL, NULL, 5, '2021-03-20 14:44:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [175, 'Sucette', 'sucette.png', 'féminin', 'sucettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sucette', 'sucettes', 5, '2021-03-20 14:46:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [176, 'Viande', 'viande.png', 'féminin', 'viandes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'viande', 'viandes', 5, '2021-03-20 14:47:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [177, 'Yaourt', 'yaourt.png', 'masculin', 'yaourts', NULL, NULL, NULL, NULL, NULL, NULL, 'yaourt', 'yaourts', NULL, NULL, 5, '2021-03-20 14:48:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [178, 'Canard', 'canard.png', 'masculin', 'canards', NULL, NULL, NULL, NULL, NULL, NULL, 'canard', 'canards', NULL, NULL, 6, '2021-03-20 18:08:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [179, 'Cheval', 'cheval.png', 'masculin', 'chevaux', NULL, NULL, NULL, NULL, NULL, NULL, 'cheval', 'chevaux', NULL, NULL, 6, '2021-03-20 18:09:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [180, 'Cochon', 'cochon.png', 'masculin', 'cochons', NULL, NULL, NULL, NULL, NULL, NULL, 'cochon', 'cochons', 'cochonne', 'cochonnes', 6, '2021-03-20 18:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [181, 'Crocodile', 'crocodile.png', 'masculin', 'crocodiles', NULL, NULL, NULL, NULL, NULL, NULL, 'crocodile', 'crocodiles', NULL, NULL, 6, '2021-03-20 18:11:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [182, 'Dauphin', 'dauphin.png', 'masculin', 'dauphins', NULL, NULL, NULL, NULL, NULL, NULL, 'dauphin', 'dauphins', NULL, NULL, 6, '2021-03-20 18:12:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [183, 'Dinosaure', 'dinosaure.png', 'masculin', 'dinosaures', NULL, NULL, NULL, NULL, NULL, NULL, 'dinosaure', 'dinosaures', NULL, NULL, 6, '2021-03-20 18:13:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [184, 'Éléphant', 'elephant.png', 'masculin', 'éléphants', NULL, NULL, NULL, NULL, NULL, NULL, 'éléphant', 'éléphants', 'éléphante', 'éléphantes', 6, '2021-03-20 18:14:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [185, 'Escargot', 'escargot.png', 'masculin', 'escargots', NULL, NULL, NULL, NULL, NULL, NULL, 'escargot', 'escargots', NULL, NULL, 6, '2021-03-20 18:15:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [186, 'Grenouille', 'grenouille.png', 'féminin', 'grenouilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'grenouille', 'grenouilles', 6, '2021-03-20 18:16:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [187, 'Hamster', 'hamster.png', 'masculin', 'hamsters', NULL, NULL, NULL, NULL, NULL, NULL, 'hamster', 'hamsters', NULL, NULL, 6, '2021-03-20 18:17:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [188, 'Lion', 'lion.png', 'masculin', 'lions', NULL, NULL, NULL, NULL, NULL, NULL, 'lion', 'lions', 'lionne', 'lionnes', 6, '2021-03-20 18:18:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [189, 'Mouton', 'mouton.png', 'masculin', 'moutons', NULL, NULL, NULL, NULL, NULL, NULL, 'mouton', 'moutons', NULL, NULL, 6, '2021-03-20 18:19:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [190, 'Oie', 'oie.png', 'féminin', 'oies', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'oie', 'oies', 6, '2021-03-20 18:20:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [191, 'Papillon', 'papillon.png', 'masculin', 'papillons', NULL, NULL, NULL, NULL, NULL, NULL, 'papillon', 'papillons', NULL, NULL, 6, '2021-03-20 18:21:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [192, 'Perruche', 'perruche.png', 'féminin', 'perruches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'perruche', 'perruches', 6, '2021-03-20 18:22:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [193, 'Poule', 'poule.png', 'féminin', 'poules', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poule', 'poules', 6, '2021-03-20 18:23:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [194, 'Singe', 'singe.png', 'masculin', 'singes', NULL, NULL, NULL, NULL, NULL, NULL, 'singe', 'singes', NULL, NULL, 6, '2021-03-20 18:24:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [195, 'Souris', 'souris.png', 'féminin', 'souris', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'souris', 'souris', 6, '2021-03-20 18:25:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [196, 'Tortue', 'tortue.png', 'féminin', 'tortues', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tortue', 'tortues', 6, '2021-03-20 18:26:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [197, 'Vache', 'vache.png', 'féminin', 'vaches', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vache', 'vaches', 6, '2021-03-20 18:27:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [198, 'Cinq', 'cinq.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cinq', NULL, NULL, NULL, 7, '2021-03-20 18:46:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [199, 'Six', 'six.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'six', NULL, NULL, NULL, 7, '2021-03-20 18:47:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [200, 'Sept', 'sept.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sept', NULL, NULL, NULL, 7, '2021-03-20 18:48:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [201, 'Huit', 'huit.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'huit', NULL, NULL, NULL, 7, '2021-03-20 18:49:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [202, 'Neuf', 'neuf.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'neuf', NULL, NULL, NULL, 7, '2021-03-20 18:50:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [203, 'Dix', 'dix.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dix', NULL, NULL, NULL, 7, '2021-03-20 18:51:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [204, 'Bras', 'bras.png', 'masculin', 'bras', NULL, NULL, NULL, NULL, NULL, NULL, 'bras', 'bras', NULL, NULL, 8, '2021-03-20 19:16:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [205, 'Cheveux', 'cheveux.png', 'masculin', 'cheveux', NULL, NULL, NULL, NULL, NULL, NULL, 'cheveu', 'cheveux', NULL, NULL, 8, '2021-03-20 19:17:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [206, 'Cou', 'cou.png', 'masculin', 'cous', NULL, NULL, NULL, NULL, NULL, NULL, 'cou', 'cous', NULL, NULL, 8, '2021-03-20 19:18:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [207, 'Dent', 'dents.png', 'féminin', 'dents', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dents', 'dents', 8, '2021-03-20 19:19:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [208, 'Orteils', 'orteils.png', 'masculin', 'orteils', NULL, NULL, NULL, NULL, NULL, NULL, 'orteil', 'orteils', NULL, NULL, 8, '2021-03-20 19:20:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [209, 'Doigts', 'doigts.png', 'masculin', 'doigts', NULL, NULL, NULL, NULL, NULL, NULL, 'doigt', 'doigts', NULL, NULL, 8, '2021-03-20 19:21:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [210, 'Dos', 'dos.png', 'masculin', 'dos', NULL, NULL, NULL, NULL, NULL, NULL, 'dos', 'dos', NULL, NULL, 8, '2021-03-20 19:22:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [211, 'Fesses', 'fesses.png', 'féminin', 'fesses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fesse', 'fesses', 8, '2021-03-20 19:23:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [212, 'Jambe', 'jambe.png', 'féminin', 'jambes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jambe', 'jambes', 8, '2021-03-20 19:24:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [213, 'Langue', 'langue.png', 'féminin', 'langues', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'langue', 'langues', 8, '2021-03-20 19:25:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [214, 'Nombril', 'nombril.png', 'masculin', 'nombrils', NULL, NULL, NULL, NULL, NULL, NULL, 'nombril', 'nombrils', NULL, NULL, 8, '2021-03-20 19:26:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [215, 'Nuque', 'nuque.png', 'féminin', 'nuques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nuque', 'nuques', 8, '2021-03-20 19:27:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [216, 'Poitrine', 'poitrine.png', 'féminin', 'poitrines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poitrine', 'poitrines', 8, '2021-03-20 19:28:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [217, 'Tête', 'tete.png', 'féminin', 'têtes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tête', 'têtes', 8, '2021-03-20 19:29:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [218, 'Ventre', 'ventre.png', 'masculin', 'ventres', NULL, NULL, NULL, NULL, NULL, NULL, 'ventre', 'ventres', NULL, NULL, 8, '2021-03-20 19:30:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [219, 'Yeux', 'yeux.png', 'masculin', 'yeux', NULL, NULL, NULL, NULL, NULL, NULL, 'oeil', 'yeux', NULL, NULL, 8, '2021-03-20 19:31:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [220, 'Gris', 'gris.png', 'masculin', 'gris', NULL, NULL, NULL, NULL, NULL, NULL, 'gris', 'gris', 'grise', 'grises', 9, '2021-03-20 21:24:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [221, 'Jaune', 'jaune.png', 'masculin', 'jaunes', NULL, NULL, NULL, NULL, NULL, NULL, 'jaune', 'jaunes', 'jaune', 'jaunes', 9, '2021-03-20 21:25:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [222, 'Marron', 'marron.png', 'masculin', 'marrons', NULL, NULL, NULL, NULL, NULL, NULL, 'marron', 'marrons', 'marronne', 'marronnes', 9, '2021-03-20 21:26:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [223, 'Noir', 'noir.png', 'masculin', 'noirs', NULL, NULL, NULL, NULL, NULL, NULL, 'noir', 'noirs', 'noire', 'noires', 9, '2021-03-20 21:27:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [224, 'À la', 'aLa.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:47:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [225, 'À', 'a.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:48:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [226, 'Ces', 'ces.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:49:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [227, 'Cet', 'cet.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:50:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [228, 'Cette', 'cette.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:51:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [229, 'Leur', 'leur.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:52:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [230, 'Leurs', 'leurs.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:53:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [231, 'Ma', 'ma.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:54:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [232, 'Mes', 'mes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:55:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [233, 'Mon', 'mon.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:56:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [234, 'Nos', 'nos.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:57:06', NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [235, 'Notre', 'notre.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:58:06', NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [236, 'Sa', 'sa.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 21:59:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [237, 'Ses', 'ses.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:00:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [238, 'Son', 'son.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:01:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [239, 'Ta', 'ta.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:02:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [240, 'Tes', 'tes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:03:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [241, 'Vos', 'vos.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:04:06', NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [242, 'Votre', 'votre.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-20 22:05:06', NULL, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [243, 'Amoureux', 'amoureux.png', 'masculin', 'amoureux', NULL, NULL, NULL, NULL, NULL, NULL, 'amoureux', 'amoureux', 'amoureuse', 'amoureuses', 11, '2021-03-20 22:20:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [244, 'Confus', 'confus.png', 'masculin', 'confus', NULL, NULL, NULL, NULL, NULL, NULL, 'confus', 'confus', 'confuse', 'confuses', 11, '2021-03-20 22:21:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [245, 'Content', 'content.png', 'masculin', 'contents', NULL, NULL, NULL, NULL, NULL, NULL, 'content', 'contents', 'contente', 'contentes', 11, '2021-03-20 22:22:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [246, 'Distrait', 'distrait.png', 'masculin', 'distraits', NULL, NULL, NULL, NULL, NULL, NULL, 'distrait', 'distraits', 'distraite', 'distraites', 11, '2021-03-20 22:23:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [247, 'Ennuyeux', 'ennuyeux.png', 'masculin', 'ennuyeux', NULL, NULL, NULL, NULL, NULL, NULL, 'ennuyeux', 'ennuyeux', 'ennuyeuse', 'ennuyeuses', 11, '2021-03-20 22:24:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [248, 'Fatigué', 'fatigue.png', 'masculin', 'fatigués', NULL, NULL, NULL, NULL, NULL, NULL, 'fatigué', 'fatigués', 'fatiguée', 'fatiguées', 11, '2021-03-20 22:25:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [249, 'Honte', 'honte.png', 'féminin', 'hontes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'honte', 'hontes', 11, '2021-03-20 22:26:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [250, 'Surpris', 'surpris.png', 'masculin', 'surpris', NULL, NULL, NULL, NULL, NULL, NULL, 'surpris', 'surpris', 'surprise', 'surprises', 11, '2021-03-20 22:27:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [251, 'Timide', 'timide.png', 'masculin', 'timides', NULL, NULL, NULL, NULL, NULL, NULL, 'timide', 'timides', 'timide', 'timides', 11, '2021-03-20 22:28:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [252, 'Triste', 'triste.png', 'masculin', 'tristes', NULL, NULL, NULL, NULL, NULL, NULL, 'triste', 'tristes', 'triste', 'tristes', 11, '2021-03-20 22:29:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [253, 'Ananas', 'ananas.png', 'masculin', 'ananas', NULL, NULL, NULL, NULL, NULL, NULL, 'ananas', 'ananas', NULL, NULL, 12, '2021-03-20 22:32:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [254, 'Aubergine', 'aubergine.png', 'féminin', 'aubergines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aubergine', 'aubergines', 12, '2021-03-20 22:33:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [255, 'Brocoli', 'brocoli.png', 'masculin', 'brocolis', NULL, NULL, NULL, NULL, NULL, NULL, 'brocoli', 'brocolis', NULL, NULL, 12, '2021-03-20 22:34:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [256, 'Cerise', 'cerise.png', 'féminin', 'cerises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cerise', 'cerises', 12, '2021-03-20 22:35:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [257, 'Chou-fleur', 'chouFleur.png', 'masculin', 'choux-fleurs', NULL, NULL, NULL, NULL, NULL, NULL, 'chou-fleur', 'choux-fleurs', NULL, NULL, 12, '2021-03-20 22:36:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [258, 'Citron', 'citron.png', 'masculin', 'citrons', NULL, NULL, NULL, NULL, NULL, NULL, 'citron', 'citrons', NULL, NULL, 12, '2021-03-20 22:37:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [259, 'Cornichon', 'cornichon.png', 'masculin', 'cornichons', NULL, NULL, NULL, NULL, NULL, NULL, 'cornichon', 'cornichons', NULL, NULL, 12, '2021-03-20 22:38:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [260, 'Framboise', 'framboises.png', 'féminin', 'framboises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'framboise', 'framboises', 12, '2021-03-20 22:39:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [261, 'Haricots verts', 'haricotsVerts.png', 'masculin', 'haricots verts', NULL, NULL, NULL, NULL, NULL, NULL, 'haricot vert', 'haricots verts', NULL, NULL, 12, '2021-03-20 22:40:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [262, 'Maïs', 'mais.png', 'masculin', 'maïs', NULL, NULL, NULL, NULL, NULL, NULL, 'maïs', 'maïs', NULL, NULL, 12, '2021-03-20 22:41:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [263, 'Myrtille', 'myrtilles.png', 'féminin', 'myrtilles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'myrtille', 'myrtilles', 12, '2021-03-20 22:42:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [264, 'Noix de coco', 'noixDeCoco.png', 'féminin', 'noix de coco', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'noix de coco', 'noix de coco', 12, '2021-03-20 22:43:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [265, 'Noix', 'noix.png', 'féminin', 'noix', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'noix', 'noix', 12, '2021-03-20 22:44:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [266, 'Oignon', 'oignon.png', 'masculin', 'oignons', NULL, NULL, NULL, NULL, NULL, NULL, 'oignon', 'oignons', NULL, NULL, 12, '2021-03-20 22:45:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [267, 'Olive', 'olives.png', 'féminin', 'olives', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'olive', 'olives', 12, '2021-03-20 22:46:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [268, 'Pastèque', 'pasteque.png', 'féminin', 'pastèques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pastèque', 'pastèques', 12, '2021-03-20 22:47:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [269, 'Poire', 'poire.png', 'féminin', 'poires', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poire', 'poires', 12, '2021-03-20 22:48:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [270, 'Poireau', 'poireaux.png', 'masculin', 'poireaux', NULL, NULL, NULL, NULL, NULL, NULL, 'poireau', 'poireaux', NULL, NULL, 12, '2021-03-20 22:49:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [271, 'Poivron', 'poivron.png', 'masculin', 'poivrons', NULL, NULL, NULL, NULL, NULL, NULL, 'poivron', 'poivrons', NULL, NULL, 12, '2021-03-20 22:49:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [272, 'Pomme', 'pomme.png', 'féminin', 'pommes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pomme', 'pommes', 12, '2021-03-20 22:50:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [273, 'Raisin noir', 'raisinsNoirs.png', 'masculin', 'raisins noirs', NULL, NULL, NULL, NULL, NULL, NULL, 'raisin noir', 'raisins noirs', NULL, NULL, 12, '2021-03-20 22:51:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [274, 'Salade', 'salade.png', 'féminin', 'salades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'salade', 'salades', 12, '2021-03-20 22:52:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [275, 'Tomate', 'tomate.png', 'féminin', 'tomates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tomate', 'tomates', 12, '2021-03-20 22:53:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [276, 'Boulangerie', 'boulangerie.png', 'féminin', 'boulangeries', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'boulangerie', 'boulangeries', NULL, '2021-03-21 08:36:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [277, 'Chambre à coucher', 'chambreACoucher.png', 'féminin', 'chambres à coucher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chambre à coucher', 'chambres à coucher', NULL, '2021-03-21 08:37:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [278, 'Cinema', 'cinema.png', 'masculin', 'cinemas', NULL, NULL, NULL, NULL, NULL, NULL, 'cinema', 'cinemas', NULL, NULL, 14, '2021-03-21 08:38:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [279, 'Magasin de glaces', 'magasinDeGlaces.png', 'masculin', 'magasins de glaces', NULL, NULL, NULL, NULL, NULL, NULL, 'magasin de glaces', 'magasins de glaces', NULL, NULL, NULL, '2021-03-21 08:39:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [280, 'Maison', 'maison.png', 'féminin', 'maisons', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'maison', 'maisons', NULL, '2021-03-21 08:40:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [281, 'Pharmacie', 'pharmacie.png', 'féminin', 'pharmacies', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pharmacie', 'pharmacies', NULL, '2021-03-21 08:41:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [282, 'Piscine', 'piscine.png', 'féminin', 'piscines', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'piscine', 'piscines', 14, '2021-03-21 08:42:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [283, 'Salon de coiffure', 'salonDeCoiffure.png', 'masculin', 'salons de coiffure', NULL, NULL, NULL, NULL, NULL, NULL, 'salon de coiffure', 'salons de coiffure', NULL, NULL, NULL, '2021-03-21 08:43:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [284, 'Salon', 'salon.png', 'masculin', 'salons', NULL, NULL, NULL, NULL, NULL, NULL, 'salon', 'salons', NULL, NULL, NULL, '2021-03-21 08:44:45', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [285, 'Supermarché', 'supermarche.png', 'masculin', 'supermarchés', NULL, NULL, NULL, NULL, NULL, NULL, 'supermarché', 'supermarchés', NULL, NULL, NULL, '2021-03-21 08:45:45', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [286, 'Ville', 'ville.png', 'féminin', 'villes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ville', 'villes', 14, '2021-03-21 08:46:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [287, 'Arc-en-ciel', 'arcEnCiel.png', 'masculin', 'arcs-en-ciel', NULL, NULL, NULL, NULL, NULL, NULL, 'arc-en-ciel', 'arcs-en-ciel', NULL, NULL, 15, '2021-03-21 08:47:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [288, 'Brumeux', 'brumeux.png', 'masculin', 'brumeux', NULL, NULL, NULL, NULL, NULL, NULL, 'brumeux', 'brumeux', 'brumeuse', 'brumeuses', 15, '2021-03-21 08:48:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [289, 'Éclair', 'eclair.png', 'masculin', 'éclairs', NULL, NULL, NULL, NULL, NULL, NULL, 'éclair', 'éclairs', NULL, NULL, 15, '2021-03-21 08:49:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [290, 'Ensoleillé', 'ensoleille.png', 'masculin', 'ensoleillés', NULL, NULL, NULL, NULL, NULL, NULL, 'ensoleillé', 'ensoleillés', 'ensoleillée', 'ensoleillées', 15, '2021-03-21 08:50:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [291, 'Neigeux', 'neigeux.png', 'masculin', 'neigeux', NULL, NULL, NULL, NULL, NULL, NULL, 'neigeux', 'neigeux', 'neigeuse', 'neigeuses', 15, '2021-03-21 08:51:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [292, 'Tonnerre', 'tonnerre.png', 'masculin', 'tonnerres', NULL, NULL, NULL, NULL, NULL, NULL, 'tonnerre', 'tonnerres', NULL, NULL, 15, '2021-03-21 08:53:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [293, 'Nuageux', 'nuageux.png', 'masculin', 'nuageux', NULL, NULL, NULL, NULL, NULL, NULL, 'nuageux', 'nuageux', 'nuageuse', 'nuageuses', 15, '2021-03-21 08:54:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [294, 'Orageux', 'orageux.png', 'masculin', 'orageux', NULL, NULL, NULL, NULL, NULL, NULL, 'orageux', 'orageux', 'orageuse', 'orageuses', 15, '2021-03-21 08:55:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [295, 'Tornade', 'tornade.png', 'féminin', 'tornades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tornade', 'tornades', 15, '2021-03-21 08:56:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [296, 'Bibliothèque', 'bibliotheque.png', 'féminin', 'bibliothèques', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bibliothèque', 'bibliothèques', 17, '2021-03-21 09:16:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [297, 'Casserole', 'casserole.png', 'féminin', 'casseroles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'casserole', 'casseroles', NULL, '2021-03-21 09:18:04', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [298, 'Balai', 'balai.png', 'masculin', 'balais', NULL, NULL, NULL, NULL, NULL, NULL, 'balai', 'balais', NULL, NULL, 17, '2021-03-21 09:19:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [299, 'Chaise', 'chaise.png', 'féminin', 'chaises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chaise', 'chaises', 17, '2021-03-21 09:20:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [300, 'Ciseaux', 'ciseaux1.png', 'masculin', 'ciseaux', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ciseaux', NULL, NULL, 17, '2021-03-21 09:21:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [301, 'Conserves', 'conserve.png', 'féminin', 'conserves', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'conserve', 'conserves', NULL, '2021-03-21 09:22:43', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [302, 'Coussin', 'coussin.png', 'masculin', 'coussins', NULL, NULL, NULL, NULL, NULL, NULL, 'coussin', 'coussins', NULL, NULL, 17, '2021-03-21 09:23:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [303, 'Couvert', 'couverts.png', 'masculin', 'couverts', NULL, NULL, NULL, NULL, NULL, NULL, 'couvert', 'couverts', NULL, NULL, NULL, '2021-03-21 09:24:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [304, 'Lampe', 'lampe.png', 'féminin', 'lampes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lampe', 'lampes', 17, '2021-03-21 09:25:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [305, 'Lit', 'lit.png', 'masculin', 'lits', NULL, NULL, NULL, NULL, NULL, NULL, 'lit', 'lits', NULL, NULL, 17, '2021-03-21 09:26:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [306, 'Lunettes', 'lunettes.png', 'féminin', 'lunettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lunettes', 17, '2021-03-21 09:27:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [307, 'Pèse-personne', 'pesePersonne.png', 'masculin', 'pèse-personnes', NULL, NULL, NULL, NULL, NULL, NULL, 'pèse-personne', 'pèse-personnes', NULL, NULL, 17, '2021-03-21 09:28:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [308, 'Portefeuille', 'portefeuille.png', 'masculin', 'portefeuilles', NULL, NULL, NULL, NULL, NULL, NULL, 'portefeuille', 'portefeuilles', NULL, NULL, 17, '2021-03-21 09:29:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [309, 'Poubelle', 'poubelle.png', 'féminin', 'poubelles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'poubelle', 'poubelles', 17, '2021-03-21 09:30:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [310, 'Réfrigérateur', 'refrigerateur.png', 'masculin', 'réfrigérateurs', NULL, NULL, NULL, NULL, NULL, NULL, 'réfrigérateur', 'réfrigérateurs', NULL, NULL, NULL, '2021-03-21 09:31:21', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [311, 'Sac à dos', 'sacADos.png', 'masculin', 'sacs à dos', NULL, NULL, NULL, NULL, NULL, NULL, 'sac à dos', 'sacs à dos', NULL, NULL, 17, '2021-03-21 09:32:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [312, 'Seau', 'seau.png', 'masculin', 'seaux', NULL, NULL, NULL, NULL, NULL, NULL, 'seau', 'seaux', NULL, NULL, 17, '2021-03-21 09:33:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [313, 'Serviette de bain', 'servietteDeBain.png', 'féminin', 'serviettes de bain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'serviette de bain', 'serviettes de bain', NULL, '2021-03-21 09:34:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [314, 'Affaires de toilettes', 'affairesDeToilette.png', 'féminin', 'affaires de toilettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affaire de toilettes', 'affaires de toilettes', NULL, '2021-03-21 09:35:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [315, 'Trousse de toilettes', 'trousseDeToilette.png', 'féminin', 'trousses de toilettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trousse de toilettes', 'trousses de toilettes', NULL, '2021-03-21 09:36:49', NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [316, 'Tasse', 'tasse.png', 'féminin', 'tasses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tasse', 'tasses', NULL, '2021-03-21 09:37:49', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [317, 'Vaisselle', 'vaisselle.png', 'féminin', 'vaisselles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vaisselle', 'vaisselles', NULL, '2021-03-21 09:38:49', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [318, 'Astronaute', 'astronaute.png', 'masculin', 'astronautes', NULL, NULL, NULL, NULL, NULL, NULL, 'astronaute', 'astronautes', 'astronaute', 'astronautes', 18, '2021-03-21 09:46:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [319, 'Bibliothécaire', 'bibliothecaire.png', 'féminin', 'bibliothécaires', NULL, NULL, NULL, NULL, NULL, NULL, 'bibliothécaire', 'bibliothécaires', 'bibliothécaire', 'bibliothécaires', 18, '2021-03-21 09:48:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [320, 'Caissière', 'caissiere.png', 'féminin', 'caissières', NULL, NULL, NULL, NULL, NULL, NULL, 'caissier', 'caissiers', 'caissière', 'caissières', 18, '2021-03-21 09:49:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [321, 'Chauffeur de taxi', 'chauffeurDeTaxi.png', 'masculin', 'chauffeurs de taxi', NULL, NULL, NULL, NULL, NULL, NULL, 'chauffeur de taxi', 'chauffeurs de taxi', 'chauffeuse de taxi', 'chauffeuses de taxi', 18, '2021-03-21 09:50:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [322, 'Chef d\'orchestre', 'chefDOrchestre.png', 'féminin', 'chefs d\'orchestre', NULL, NULL, NULL, NULL, NULL, NULL, 'chef d\'orchestre', 'chefs d\'orchestre', 'chefs d\'orchestre', 'chefs d\'orchestre', 18, '2021-03-21 09:51:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [323, 'Coiffeuse', 'coiffeuse.png', 'féminin', 'coiffeuses', NULL, NULL, NULL, NULL, NULL, NULL, 'coiffeur', 'coiffeurs', 'coiffeuse', 'coiffeuses', 18, '2021-03-21 09:52:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [324, 'Cuisinier', 'cuisinier.png', 'masculin', 'cuisiniers', NULL, NULL, NULL, NULL, NULL, NULL, 'cuisinier', 'cuisiniers', 'cuisinière', 'cuisinieres', 18, '2021-03-21 09:53:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [325, 'Danseur', 'danseur.png', 'masculin', 'danseurs', NULL, NULL, NULL, NULL, NULL, NULL, 'danseur', 'danseurs', 'danseuse', 'danseuses', 18, '2021-03-21 09:54:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [326, 'Grand-père', 'grandPere.png', 'masculin', 'grands-pères', NULL, NULL, NULL, NULL, NULL, NULL, 'grand-père', 'grand-pères', NULL, NULL, NULL, '2021-03-21 09:55:41', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [327, 'Informaticienne', 'informaticienne.png', 'féminin', 'informaticiennes', NULL, NULL, NULL, NULL, NULL, NULL, 'informaticien', 'informaticiens', 'informaticienne', 'informaticiennes', 18, '2021-03-21 09:56:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [328, 'Livreur', 'livreur.png', 'masculin', 'livreurs', NULL, NULL, NULL, NULL, NULL, NULL, 'livreur', 'livreurs', 'livreuse', 'livreuses', 18, '2021-03-21 09:57:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [329, 'Maman', 'maman.png', 'féminin', 'mamans', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'maman', 'mamans', NULL, '2021-03-21 09:58:04', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [330, 'Moniteur', 'moniteur.png', 'masculin', 'moniteurs', NULL, NULL, NULL, NULL, NULL, NULL, 'moniteur', 'moniteurs', 'monitrice', 'monitrices', 18, '2021-03-21 09:59:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [331, 'Opticien', 'opticien.png', 'masculin', 'opticiens', NULL, NULL, NULL, NULL, NULL, NULL, 'opticien', 'opticiens', 'opticienne', 'opticiennes', 18, '2021-03-21 10:00:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [332, 'Plombier', 'plombier.png', 'masculin', 'plombiers', NULL, NULL, NULL, NULL, NULL, NULL, 'plombier', 'plombiers', 'plombière', 'plombières', 18, '2021-03-21 10:01:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [333, 'Policier', 'policier.png', 'masculin', 'policiers', NULL, NULL, NULL, NULL, NULL, NULL, 'policier', 'policiers', 'policière', 'policières', 18, '2021-03-21 10:02:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [334, 'Pompière', 'pompiere.png', 'féminin', 'pompières', NULL, NULL, NULL, NULL, NULL, NULL, 'pompier', 'pompiers', 'pompière', 'pompières', 18, '2021-03-21 10:03:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [335, 'Psychologue', 'psychologue.png', 'masculin', 'psychologues', NULL, NULL, NULL, NULL, NULL, NULL, 'psychologue', 'psychologues', 'psychologue', 'psychologues', 18, '2021-03-21 10:04:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [336, 'Scientifique', 'scientifique.png', 'féminin', 'scientifiques', NULL, NULL, NULL, NULL, NULL, NULL, 'scientifique', 'scientifiques', 'scientifique', 'scientifiques', 18, '2021-03-21 10:05:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [337, 'Compas', 'compas.png', 'masculin', 'compas', NULL, NULL, NULL, NULL, NULL, NULL, 'compas', 'compas', NULL, NULL, 19, '2021-03-21 10:39:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [338, 'Crayons de couleurs', 'crayonsDeCouleurs.png', 'masculin', 'crayons de couleurs', NULL, NULL, NULL, NULL, NULL, NULL, 'crayon de couleurs', 'crayons de couleurs', NULL, NULL, 19, '2021-03-21 10:40:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [339, 'Calculatrice', 'calculatrice.png', 'féminin', 'calculatrices', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'calculatrice', 'calculatrices', 19, '2021-03-21 10:42:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [340, 'Dictionnaire', 'dictionnaire.png', 'masculin', 'dictionnaires', NULL, NULL, NULL, NULL, NULL, NULL, 'dictionnaire', 'dictionnaires', NULL, NULL, 19, '2021-03-21 10:43:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [341, 'Feutre', 'feutre.png', 'masculin', 'feutres', NULL, NULL, NULL, NULL, NULL, NULL, 'feutre', 'feutres', NULL, NULL, 19, '2021-03-21 10:44:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [342, 'Papier', 'papier.png', 'masculin', 'papiers', NULL, NULL, NULL, NULL, NULL, NULL, 'papier', 'papiers', NULL, NULL, 19, '2021-03-21 10:45:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [343, 'Pinceau', 'pinceau.png', 'masculin', 'pinceaux', NULL, NULL, NULL, NULL, NULL, NULL, 'pinceau', 'pinceaux', NULL, NULL, 19, '2021-03-21 10:46:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [344, 'Récréation', 'recreation.png', 'féminin', 'récréations', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'récréation', 'récréations', 19, '2021-03-21 10:47:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [345, 'Scotch', 'scotch.png', 'masculin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Scotch', NULL, NULL, NULL, 19, '2021-03-21 10:48:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [346, 'Tableau', 'tableau.png', 'masculin', 'tableaux', NULL, NULL, NULL, NULL, NULL, NULL, 'tableau', 'tableaux', NULL, NULL, 19, '2021-03-21 10:49:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [347, 'Fusée', 'fusee.png', 'féminin', 'fusées', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fusée', 'fusées', 20, '2021-03-21 10:50:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [348, 'Bateau', 'bateau.png', 'masculin', 'bateaux', NULL, NULL, NULL, NULL, NULL, NULL, 'bateau', 'bateaux', NULL, NULL, 20, '2021-03-21 10:51:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [349, 'Bus', 'bus.png', 'masculin', 'bus', NULL, NULL, NULL, NULL, NULL, NULL, 'bus', 'bus', NULL, NULL, 20, '2021-03-21 10:52:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [350, 'Camion de pompiers', 'camionDePompiers.png', 'masculin', 'camions de pompiers', NULL, NULL, NULL, NULL, NULL, NULL, 'camion de pompiers', 'camions de pompiers', NULL, NULL, 20, '2021-03-21 10:53:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [351, 'Camion', 'camion.png', 'masculin', 'camions', NULL, NULL, NULL, NULL, NULL, NULL, 'camion', 'camions', NULL, NULL, 20, '2021-03-21 10:54:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [352, 'Moto', 'moto.png', 'féminin', 'motos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moto', 'motos', 20, '2021-03-21 10:55:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [353, 'Tricycle', 'tricycle.png', 'masculin', 'tricycles', NULL, NULL, NULL, NULL, NULL, NULL, 'tricycle', 'tricycles', NULL, NULL, 20, '2021-03-21 10:56:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [354, 'Vélo', 'velo.png', 'masculin', 'vélos', NULL, NULL, NULL, NULL, NULL, NULL, 'vélo', 'vélos', NULL, NULL, 20, '2021-03-21 10:57:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [355, 'Trottinette', 'trottinette.png', 'féminin', 'trottinettes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'trottinette', 'trottinettes', 20, '2021-03-21 10:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [356, 'Voiture', 'voiture.png', 'féminin', 'voitures', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'voiture', 'voitures', 20, '2021-03-21 10:59:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [357, 'Chemise', 'chemise.png', 'féminin', 'chemises', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chemise', 'chemises', 21, '2021-03-21 11:03:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [358, 'Culotte', 'culotte.png', 'féminin', 'culottes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'culotte', 'culottes', 21, '2021-03-21 11:04:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [359, 'Anorak', 'anorak.png', 'masculin', 'anoraks', NULL, NULL, NULL, NULL, NULL, NULL, 'anorak', 'anoraks', NULL, NULL, 21, '2021-03-21 11:10:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [360, 'Ciré', 'cire.png', 'masculin', 'cirés', NULL, NULL, NULL, NULL, NULL, NULL, 'cirés', 'cirés', NULL, NULL, 21, '2021-03-21 11:11:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [361, 'Collant', 'collant.png', 'masculin', 'collants', NULL, NULL, NULL, NULL, NULL, NULL, 'collant', 'collants', NULL, NULL, 21, '2021-03-21 11:12:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [362, 'Gant', 'gant.png', 'masculin', 'gants', NULL, NULL, NULL, NULL, NULL, NULL, 'gant', 'gants', NULL, NULL, 21, '2021-03-21 11:13:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [363, 'Jupe', 'jupe.png', 'féminin', 'jupes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jupe', 'jupes', 21, '2021-03-21 11:14:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [364, 'Maillot de bain', 'maillotDeBain.png', 'masculin', 'maillots de bain', NULL, NULL, NULL, NULL, NULL, NULL, 'maillot de bain', 'maillots de bain', NULL, NULL, 21, '2021-03-21 11:15:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [365, 'Moufle', 'moufle.png', 'féminin', 'moufles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'moufle', 'moufles', 21, '2021-03-21 11:16:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [366, 'Polo', 'polo.png', 'masculin', 'polos', NULL, NULL, NULL, NULL, NULL, NULL, 'polo', 'polos', NULL, NULL, 21, '2021-03-21 11:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [367, 'Pyjama hôpital', 'pyjamaHopital.png', 'masculin', 'pyjamas hôpital', NULL, NULL, NULL, NULL, NULL, NULL, 'pyjama hôpital', 'pyjamas hôpital', NULL, NULL, 21, '2021-03-21 11:18:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [368, 'Pyjama', 'pyjama.png', 'masculin', 'pyjamas', NULL, NULL, NULL, NULL, NULL, NULL, 'pyjama', 'pyjamas', NULL, NULL, 21, '2021-03-21 11:19:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [369, 'Robe', 'robe.png', 'féminin', 'robes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'robe', 'robes', 21, '2021-03-21 11:20:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [370, 'Short', 'short.png', 'masculin', 'shorts', NULL, NULL, NULL, NULL, NULL, NULL, 'short', 'shorts', NULL, NULL, 21, '2021-03-21 11:22:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [371, 'Slip', 'slip.png', 'masculin', 'slips', NULL, NULL, NULL, NULL, NULL, NULL, 'slip', 'slips', NULL, NULL, 21, '2021-03-21 11:23:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [372, 'Sweet-shirt', 'sweetShirt.png', 'masculin', 'sweet-shirts', NULL, NULL, NULL, NULL, NULL, NULL, 'sweet-shirt', 'sweet-shirts', NULL, NULL, 21, '2021-03-21 11:24:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [373, 'Veste', 'veste.png', 'féminin', 'vestes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'veste', 'vestes', 21, '2021-03-21 11:25:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [374, 'Aux', 'aux1.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 21:59:06', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [375, 'Chez', 'chez.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:00:06', NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [376, 'Dans', 'dans.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:01:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [377, 'Du', 'du.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:02:06', NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [378, 'La', 'la.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:03:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [379, 'Le', 'le.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:04:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [380, 'Les', 'les.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:05:06', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [381, 'Mien', 'mien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:06:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [382, 'Mienne', 'mienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:07:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [383, 'Miennes', 'miennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:08:06', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [384, 'Sien', 'sien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:09:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [385, 'Sienne', 'sienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:10:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [386, 'Siennes', 'siennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:11:06', NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [387, 'Tien', 'tien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:12:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [388, 'Tienne', 'tienne.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:13:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [389, 'Tiennes', 'tiennes.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:14:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [390, 'Ton', 'ton.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-22 22:12:06', NULL, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [391, 'Asseoir', 'asseoir.png', NULL, NULL, 'assieds', 'assieds', 'assied', 'asseyons', 'asseyez', 'asseyent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:25:19', NULL, NULL, 'assiérai', 'assiéras', 'assiéra', 'assiérons', 'assiérez', 'assiéront', 'ai assis', 'as assis', 'a assis', 'avons assis', 'avez assis', 'ont assis'],
            [392, 'Casser', 'casser.png', NULL, NULL, 'casse', 'casses', 'casse', 'cassons', 'cassez', 'cassent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:26:19', NULL, NULL, 'casserai', 'casseras', 'cassera', 'casserons', 'casserez', 'casseront', 'ai cassé', 'as cassé', 'a cassé', 'avons cassé', 'avez cassé', 'ont cassé'],
            [393, 'Cracher', 'cracher.png', NULL, NULL, 'crache', 'craches', 'crache', 'crachons', 'crachez', 'crachent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:27:19', NULL, NULL, 'cracherai', 'cracheras', 'crachera', 'cracherons', 'cracherez', 'cracheront', 'ai craché', 'as craché', 'a craché', 'avons craché', 'avez craché', 'ont craché'],
            [394, 'Crier', 'crier.png', NULL, NULL, 'crie', 'cries', 'crie', 'crions', 'criez', 'crient', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:28:19', NULL, NULL, 'crierai', 'crieras', 'criera', 'crierons', 'crierez', 'crieront', 'ai crié', 'as crié', 'a crié', 'avons crié', 'avez crié', 'ont crié'],
            [395, 'Disputer', 'disputer.png', NULL, NULL, 'dispute', 'disputes', 'dispute', 'disputons', 'disputez', 'disputent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:29:19', NULL, NULL, 'disputerai', 'disputeras', 'disputera', 'disputerons', 'disputerez', 'disputeront', 'ai disputé', 'as disputé', 'a disputé', 'avons disputé', 'avez disputé', 'ont disputé'],
            [396, 'Frapper', 'frapper.png', NULL, NULL, 'frappe', 'frappes', 'frappe', 'frappons', 'frappez', 'frappent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:30:19', NULL, NULL, 'frapperai', 'frapperas', 'frappera', 'frapperons', 'frapperez', 'frapperont', 'ai frappé', 'as frappé', 'a frappé', 'avons frappé', 'avez frappé', 'ont frappé'],
            [397, 'Jeter', 'jeter.png', NULL, NULL, 'jette', 'jettes', 'jette', 'jetons', 'jetez', 'jettent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:31:19', NULL, NULL, 'jetterai', 'jetteras', 'jettera', 'jetterons', 'jetterez', 'jetteront', 'ai jeté', 'as jeté', 'a jeté', 'avons jeté', 'avez jeté', 'ont jeté'],
            [398, 'Griffer', 'griffer.png', NULL, NULL, 'griffe', 'griffes', 'griffe', 'griffons', 'griffez', 'griffent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:32:19', NULL, NULL, 'grifferai', 'grifferas', 'griffera', 'grifferons', 'grifferez', 'grifferont', 'ai griffé', 'as griffé', 'a griffé', 'avons griffé', 'avez griffé', 'ont griffé'],
            [399, 'Mordre', 'mordre.png', NULL, NULL, 'mords', 'mords', 'mord', 'mordons', 'mordez', 'mordent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:33:19', NULL, NULL, 'mordrai', 'mordras', 'mordra', 'mordrons', 'mordrez', 'mordront', 'ai mordu', 'as mordu', 'a mordu', 'avons mordu', 'avez mordu', 'ont mordu'],
            [400, 'Trépigner', 'trepigner.png', NULL, NULL, 'trépigne', 'trépigne', 'trépigne', 'trépignons', 'trépignez', 'trépignent', NULL, NULL, NULL, NULL, 22, '2021-03-23 15:34:19', NULL, NULL, 'trépignerai', 'trépigneras', 'trépignera', 'trépignerons', 'trépignerez', 'trépigneront', 'ai trépigné', 'as trépigné', 'a trépigné', 'avons trépigné', 'avez trépigné', 'ont trépigné'],
            [401, 'Soir', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-26 15:39:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [563, 'Qui', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 15:39:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [622, 'Quoi', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:43:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [625, 'Matin', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:58:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [626, 'Matin', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:58:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [627, 'Midi', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:59:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [628, 'Midi', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 15:59:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [629, 'Ou', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:00:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [630, 'Ou', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:00:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [631, 'MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:01:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [632, 'MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:01:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [633, 'MidiTrente', 'heure_0h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:02:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [634, 'MidiTrente', 'heure_0h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:02:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [635, 'Pourquoi', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [636, 'Pourquoi', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [637, 'Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [638, 'Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:03:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [639, 'Midi', 'heure_0h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [640, 'Midi', 'heure_0h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:04:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [641, 'MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [642, 'MidiQuart', 'heure_0h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [643, 'neufheuretrente', 'heure_9h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [644, 'neufheuretrente', 'heure_9h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:05:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [645, 'neuf heure quarante cinq', 'heure_9h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:06:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [646, 'neuf heure quarante cinq', 'heure_9h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:06:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [647, 'Neufheure', 'heure_9h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:07:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [648, 'neufheurequinze', 'heure_9h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:08:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [649, 'neufheurequinze', 'heure_9h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:08:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [650, 'Huitheuretrente', 'heure_8h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [651, 'Huitheuretrente', 'heure_8h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [652, 'Huit heure quarante cinq', 'heure_8h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [653, 'Huit heure quarante cinq', 'heure_8h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:09:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [654, 'Huit heure quinze', 'heure_8h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [655, 'Huit heure quinze', 'heure_8h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [656, 'Huit heure', 'heure_8h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [657, 'Huit heure', 'heure_8h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:10:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [658, 'Sept heure', 'heure_7h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [659, 'Sept heure', 'heure_7h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [660, 'sept heure et quart', 'heure_7h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [661, 'sept heure et quart', 'heure_7h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:11:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [662, 'Sept heures quinze', 'heure_7h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [663, 'Sept heures quinze', 'heure_7h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [664, 'Sept heure trente', 'heure_7h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [665, 'Sept heure trente', 'heure_7h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:12:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [666, 'Six heures', 'heure_6h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [667, 'Six heures', 'heure_6h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [668, 'Six heures et quart', 'heure_6h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [669, 'Six heures et quart', 'heure_6h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:13:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [670, 'Six heures trente', 'heure_6h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:14:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [671, 'Six heures trente', 'heure_6h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:14:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [672, 'Six heures quinze', 'heure_6h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [673, 'Six heures quinze', 'heure_6h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [674, 'Cinq heure', 'heure_5h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [675, 'Cinq heure', 'heure_5h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:15:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [676, 'Cinq heures moins quart', 'heure_5h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [677, 'Cinq heures moins quart', 'heure_5h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [678, 'Cinq heure trente ', 'heure_5h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [679, 'Cinq heure trente ', 'heure_5h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:16:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [680, 'Cinq heures moins le quart ', 'heure_5h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [681, 'Cinq heures moins le quart ', 'heure_5h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [682, 'Quatre Heures', 'heure_4h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [683, 'Quatre Heures', 'heure_4h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:17:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [684, 'Quatre Heures  et Quart', 'heure_4h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [685, 'Quatre Heures  et Quart', 'heure_4h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [686, 'Quatre Heures et demi\r\n\r\n\r\n\r\n\r\n', 'heure_4h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [687, 'Quatre Heures et demi\r\n\r\n\r\n\r\n\r\n', 'heure_4h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:18:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [688, '', 'Trois Heures', 'heure_3h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [689, '', 'Trois Heures', 'heure_3h.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [690, 'Trois Heures  et quart', 'heure_3h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [691, 'Trois Heures  et quart', 'heure_3h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:19:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [692, 'Trois Heures moins le quart', 'heure_3h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [693, 'Trois Heures moins le quart', 'heure_3h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [694, 'Trois Heures et demi ', 'heure_3h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [695, 'Trois Heures et demi ', 'heure_3h30.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [696, 'Deux heures ', 'heure_2h.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [697, 'Deux heures ', 'heure_2h.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:20:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [698, 'Deux heures et quart', 'heure_2h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:21:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [699, 'Deux heures et quart', 'heure_2h15.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:21:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [700, 'Deux heures   et demi', 'heure_2h30.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [701, 'Deux heures   et demi', 'heure_2h30.png\'', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [702, 'Deux heures  moins le quart', 'heure_2h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [703, 'Deux heures  moins le quart', 'heure_2h45.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 38, '2024-03-26 16:28:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [704, '? ', 'interrogatif.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [705, '? ', 'interrogatif.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [706, 'Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [707, 'Combien', 'interrogatif_combien.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:29:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [708, 'Comment', 'interrogatif_comment.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:30:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [709, 'Comment', 'interrogatif_comment.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:30:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [710, 'Pourquoi ', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [711, 'Pourquoi ', 'interrogatif_pourquoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [712, 'Quoi ', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [713, 'Quoi ', 'interrogatif_quoi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:31:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [714, 'Qui ', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [715, 'Qui ', 'interrogatif_qui.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [716, 'Ou ', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [717, 'Ou ', 'interrogatif_ou.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:32:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [718, 'Que ', 'interrogatif_que.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [719, 'Que ', 'interrogatif_que.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [720, 'Quand ', 'interrogatif_quand.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [721, 'Quand ', 'interrogatif_quand.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, '2024-03-26 16:33:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [722, 'Matin ', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [723, 'Matin ', 'temps_matin.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [724, 'Soir ', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [725, 'Soir ', 'temps_soir.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [726, 'Après-midi ', 'temps_apresmidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:35:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [727, 'Après-midi ', 'temps_apresmidi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:35:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [728, 'Midi ', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:36:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [729, 'Midi ', 'temps_midi.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, '2024-03-26 16:36:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL]
        ];
        foreach ($dataPicto as $row) {
            $pictogram = new Pictogram();
            $pictogram->setId($row[0]);
            $pictogram->setName($row[1]);
            $pictogram->setFilename($row[2]);

            $pictogram->setGenre($row[3]);
            $pictogram->setPluriel($row[4]);

            $pictogram->setPremPersSing($row[5]);
            $pictogram->setDeuxPersSing($row[6]);
            $pictogram->setTroisPersSing($row[7]);

            $pictogram->setPremPersPlur($row[8]);
            $pictogram->setDeuxPersPlur($row[9]);
            $pictogram->setTroisPersPlur($row[10]);

            $pictogram->setMasculinSing($row[11]);
            $pictogram->setMasculinPlur($row[12]);

            $pictogram->setFemininSing($row[13]);
            $pictogram->setFemininPlur($row[14]);
            
            $pictogram->setCategory($this->catRepo->findOneById($row[15]));
            $pictogram->setUpdatedAt($this->formatDateTimeByString($row[16]));
            $pictogram->setTherapist($this->therapistRepo->findOneById($row[17]));
            $pictogram->setSubCategory($this->subCatRepo->findOneById($row[18]));
            
            $pictogram->setPremPersSingFutur($row[19]);
            $pictogram->setDeuxPersSingFutur($row[20]);
            $pictogram->setTroisPersSingFutur($row[21]);

            $pictogram->setPremPersPlurFutur($row[22]);
            $pictogram->setDeuxPersPlurFutur($row[23]);
            $pictogram->setTroisPersPlurFutur($row[24]);

            $pictogram->setPremPersSingPasse($row[25]);
            $pictogram->setDeuxPersSingPasse($row[26]);
            $pictogram->setTroisPersSingPasse($row[27]);
            
            $pictogram->setPremPersPlurPasse($row[28]);
            $pictogram->setDeuxPersPlurPasse($row[29]);
            $pictogram->setTroisPersPlurPasse($row[30]);
        }
        $manager->flush();
    }

    private function formatDateTimeByString(string $string): DateTime  {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $string);
    }
}
