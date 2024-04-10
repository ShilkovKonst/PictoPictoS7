<?php

namespace App\DataFixtures;

use App\Entity\AudioPhrase;
use App\Entity\Category;
use App\Entity\Institution;
use App\Entity\Note;
use App\Entity\Patient;
use App\Entity\Phrase;
use App\Entity\Pictogram;
use App\Entity\Question;
use App\Entity\Tag;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
  private UserPasswordHasherInterface $hasher;

  private InstitutionRepository $iRepo;
  private UserRepository $uRepo;
  private CategoryRepository $cRepo;
  private PatientRepository $patRepo;
  private TagRepository $tagRepo;

  public function __construct(
    UserPasswordHasherInterface $hasher,

    InstitutionRepository $iRepo,
    UserRepository $uRepo,
    CategoryRepository $cRepo,
    PatientRepository $patRepo,
    TagRepository $tagRepo
  ) {
    $this->hasher = $hasher;

    $this->iRepo = $iRepo;
    $this->uRepo = $uRepo;
    $this->cRepo = $cRepo;
    $this->patRepo = $patRepo;
    $this->tagRepo = $tagRepo;
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

    $this->populateTag($manager);
    $manager->flush();

    $this->populatePictogramPronoun($manager);
    $this->populatePictogramNumber($manager);
    $this->populatePictogramNoun($manager);
    $this->populatePictogramVerb($manager);
    $this->populatePictogramAdjective($manager);
    $this->populatePictogramInterogative($manager);
    $this->populatePictogramTime($manager);
    $this->populatePictogramPreposition($manager);
    $this->populatePictogramOthers($manager);
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

  private function formatDateTimeImmutableByString(string $string): DateTimeImmutable
  {
    return \DateTimeImmutable::createFromFormat('Y-m-d', $string);
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
      $institution->setTitle($row[0]);
      $institution->setCode($row[1]);
      $institution->setEmail($row[2]);
      $institution->setPhoneNumber('123456789');
      $institution->setContactName('Joseph Marsh');
      $institution->setUpdatedAt(new DateTimeImmutable());
      $institution->setCreatedAt(new DateTimeImmutable());


      $manager->persist($institution);
    }
  }

  private function populateTag(ObjectManager $manager)
  {
    $data = [
      'verbe',
      'nom',
      'adjectif',
      'nombre',
      'invariable',
      'interrogatif',
      'pronom_ou_determinant',
      'auxiliaire_avoir',
      'auxiliaire_etre',
      'irregulier',
      'masculin',
      'feminin',
      'singulier',
      'pluriel',
      'premier',
      'deuxieme',
      'troisieme'
    ];
    foreach ($data as $title) {
      $tag = new Tag();
      $tag->setTitle($title);

      $manager->persist($tag);
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
      $user = new User();
      $user->setEmail($row[0]);
      $user->setRoles($row[1]);
      $password = $this->hasher->hashPassword($user, $row[2]);
      $user->setPassword($password);
      $user->setFirstName($row[3]);
      $user->setLastName($row[4]);
      $user->setPhoneNumber('123456789');
      $user->setJob($row[5]);
      $user->setIsActive(true);
      if ($i % 2 == 0) {
        $user->setInstitution($this->iRepo->findOneByTitle("CRP"));
      } else if ($i % 3 == 0) {
        $user->setInstitution($this->iRepo->findOneByTitle("ECAM"));
      } else {
        $user->setInstitution($this->iRepo->findOneByTitle("EntrepriseTest"));
      }
      $user->setUpdatedAt(new DateTimeImmutable());
      $user->setCreatedAt(new DateTimeImmutable());

      $manager->persist($user);
      $i++;
    }
  }

  private function populateCategory(ObjectManager $manager)
  {
    $data = [
      ['Sujets', 'sujets.png'],
      ['Boissons', 'boissons.png'],
      ['Actions', 'actions.png'],
      ['Adjectifs', 'adjectifs.png'],
      ['Aliments', 'aliments.png'],
      ['Animaux', 'animaux.png'],
      ['Chiffres', 'chiffres.png'],
      ['Corps humain', 'corpsHumain.png'],
      ['Couleurs', 'couleurs.png'],
      ['Petits mots', 'determinants.png'],
      ['Émotions', 'emotions.png'],
      ['Fruits et légumes', 'fruitsEtLegumes.png'],
      ['Langues Des Signes', 'langueDesSignes.png'],
      ['Lieux', 'lieux.png'],
      ['Météo', 'meteo.png'],
      ['Multimédia', 'multimedia.png'],
      ['Objets', 'objets.png',],
      ['Personnes', 'personnes.png'],
      ['Scolarité', 'scolarite.png'],
      ['Transports', 'transports.png'],
      ['Vêtements', 'vetements.png'],
      ['Comportements', 'comportements.png'],
      ['Orientation', 'orientation.png'],
      ['Autres Mots', 'autresMots.png'],
      ['Formes', 'formes.png'],
      ['Sports', 'sports.png'],
      ['Sécurité Routière', 'securiteRoutiere.png'],
      ['Jouet', 'jouet.png'],
      ['Interrogatif', 'interrogatif.png'],
      ['Journee', 'Journee.png'],
      ['Heures', 'heures.png'],
      ['Couverts', 'couverts.png']
    ];

    foreach ($data as $row) {
      $category = new Category();
      $category->setTitle($row[0]);
      $category->setFilename($row[1]);
      $category->setUpdatedAt(new DateTimeImmutable());
      $category->setCreatedAt(new DateTimeImmutable());

      $manager->persist($category);
    }
  }

  private function populateSubCategory(ObjectManager $manager)
  {
    $data = [
      ['École', 'ecole.png', 14],
      ['Maison', 'maison.png', 14],
      ['Magasins', 'magasins.png', 14],
      ['Famille', 'Famille.png', 18],
      ['Objets de la cuisine', 'objetsCuisine.png', 17],
      ['Objets de la salle de bain', 'objetsSalleDeBain.png', 17],
      ['Lettre A', 'A.png', 10],
      ['Lettre C', 'C.png', 10],
      ['Lettre D', 'D.png', 10],
      ['Lettre E', 'E.png', 10],
      ['Lettre L', 'L.png', 10],
      ['Lettre M', 'M.png', 10],
      ['Lettre N', 'N.png', 10],
      ['Lettre S', 'S.png', 10],
      ['Lettre T', 'T.png', 10],
      ['Lettre U', 'U.png', 10],
      ['Lettre V', 'V.png', 10],
      ['Magasin', 'magasins.png', 14],
      ['École', 'ecole.png', 14],
      ['maison', 'magasins.png', 14],
      ['Famille', 'famille.png', 18],
      ['maison', 'aquarium1.png', 14],
      ['bar', 'allerAuxToilettes.png', 14]
    ];
    foreach ($data as $row) {
      $subCat = new Category();
      $subCat->setTitle($row[0]);
      $subCat->setFilename($row[1]);
      $subCat->setUpdatedAt(new DateTimeImmutable());
      $subCat->setCreatedAt(new DateTimeImmutable());

      if ($row[2] == 10) {
        $subCat->setSuperCategory($this->cRepo->findOneByTitle("Petits mots"));
      }
      if ($row[2] == 14) {
        $subCat->setSuperCategory($this->cRepo->findOneByTitle("Lieux"));
      }
      if ($row[2] == 18) {
        $subCat->setSuperCategory($this->cRepo->findOneByTitle("Personnes"));
      }
      if ($row[2] == 17) {
        $subCat->setSuperCategory($this->cRepo->findOneByTitle("Objets"));
      }

      $manager->persist($subCat);
    }
  }
  // Pictograms
  private function populatePictogramPronoun(ObjectManager $manager)
  {
    $data = [
      ['Je', 'je.png', 'premier', 'singulier', null],
      ['Tu', 'je.png', 'deuxieme', 'singulier', null],
      ['Il', 'il.png', 'troisieme', 'singulier', 'masculin'],
      ['Elle', 'elle.png', 'troisieme', 'singulier', 'feminin'],
      ['Nous', 'nous.png', 'premier', 'pluriel', null],
      ['Vous', 'vous.png', 'deuxieme', 'pluriel', null],
      ['Ils', 'ils.png', 'troisieme', 'pluriel', 'masculin'],
      ['Elles', 'elles.png', 'troisieme', 'pluriel', 'feminin']
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('pronom_ou_determinant');
      $pictogram->addTag($this->tagRepo->findOneByTitle($row[2]));
      $pictogram->addTag($this->tagRepo->findOneByTitle($row[3]));
      if ($row[4] != null) {
        $pictogram->addTag($this->tagRepo->findOneByTitle($row[4]));
      }
      $pictogram->setCategory($this->cRepo->findOneByTitle("Sujets"));
      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      $manager->persist($pictogram);
    }
  }

  private function populatePictogramNumber(ObjectManager $manager)
  {
    $data = [
      ['Zéro', 'zero.png', 7],
      ['Un', 'un.png', 7],
      ['Deux', 'deux.png', 7],
      ['Trois', 'trois.png', 7],
      ['Quatre', 'quatre.png', 7],
      ['Cinq', 'cinq.png', 7],
      ['Six', 'six.png', 7],
      ['Sept', 'sept.png', 7],
      ['Huit', 'huit.png', 7],
      ['Neuf', 'neuf.png', 7],
      ['Dix', 'dix.png', 7],
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('nombre');
      $pictogram->setCategory($this->cRepo->findOneByTitle("Chiffres"));
      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      $manager->persist($pictogram);
    }
  }

  private function populatePictogramNoun(ObjectManager $manager)
  {
    $data = [
      ['Eau', 'eau.png', 'feminin', 'eau', 'eaux', 2],
      ['Chocolat chaud', 'chocolatChaud.png', 'masculin', 'chocolat chaud', 'chocolats chauds', 2],
      ['Jus d\'orange', 'jusDOrange.png', 'masculin', 'jus d\'orange', 'jus d\'orange', 2],
      ['Soda', 'soda.png', 'masculin', 'soda', 'sodas', 2],
      ['Jus de pomme', 'jusDePomme.png', 'masculin', 'Jus de pomme', 'Jus de pomme', 2],
      ['Café', 'cafe.png', 'masculin', 'café', 'cafés', 2],
      ['Eau du robinet', 'eauDuRobinet.png', 'feminin', 'eau du robinet', 'eaux du robinet', 2],
      ['Jus de raisin', 'jusDeRaisin.png', 'masculin', 'jus de raisin', 'jus de raisin', 2],
      ['Lait', 'lait.png', 'masculin', 'lait', 'laits', 2],
      ['Limonade', 'limonade.png', 'feminin', 'limonade', 'limonades', 2],

      ['Céréales', 'cereales.png', 'feminin', 'céréale', 'céréales', 5],
      ['Dessert', 'dessert.png', 'masculin', 'dessert', 'desserts', 5],
      ['Gâteau', 'gateaux.png', 'masculin', 'gâteau', 'gâteaux', 5],
      ['Glace', 'glace.png', 'feminin', 'glace', 'glaces', 5],
      ['Riz', 'riz.png', 'masculin', 'riz', 'riz', 5],
      ['Beurre', 'beurre.png', 'masculin', 'beurre', 'beurres', 5],
      ['Chocolat', 'chocolat.png', 'masculin', 'chocolat', 'chocolats', 5],
      ['Confiture', 'confiture.png', 'feminin', 'confiture', 'confitures', 5],
      ['Pâtes', 'pates.png', 'feminin', NULL, 'pâtes', 5],
      ['Farine', 'farine.png', 'feminin', 'farine', 'farines', 5],
      ['Flan', 'flan.png', 'masculin', 'flan', 'flans', 5],
      ['Fromage', 'fromage.png', 'masculin', 'fromage', 'fromages', 5],
      ['Jambon', 'jambon.png', 'masculin', 'jambon', 'jambons', 5],
      ['Miel', 'miel.png', 'masculin', 'miel', 'miels', 5],
      ['Moutarde', 'moutarde.png', 'feminin', 'moutarde', 'moutardes', 5],
      ['Oeufs', 'oeufs.png', 'masculin', 'oeuf', 'oeufs', 5],
      ['Pain', 'pain.png', 'masculin', 'pain', 'pains', 5],
      ['Petit pot', 'petitPot.png', 'masculin', 'petit pot', 'petits pots', 5],
      ['Poisson', 'poisson.png', 'masculin', 'poisson', 'poissons', 5],
      ['Poivre', 'poivre.png', 'masculin', 'poivre', 'poivres', 5],
      ['Poulet', 'poulet.png', 'masculin', 'poulet', 'poulets', 5],
      ['Sandwich', 'sandwich.png', 'masculin', 'sandwich', 'sandwichs', 5],
      ['Ketchup', 'ketchup.png', 'masculin', 'ketchup', NULL, 5],
      ['Sel', 'sel.png', 'masculin', 'sel', 'sels', 5],
      ['Sucette', 'sucette.png', 'feminin', 'sucette', 'sucettes', 5],
      ['Viande', 'viande.png', 'feminin', 'viande', 'viandes', 5],
      ['Yaourt', 'yaourt.png', 'masculin', 'yaourt', 'yaourts', 5],

      ['Chat', 'chat.png', 'masculin', 'chat', 'chats', 6],
      ['Chatte', 'chatte.png', 'feminin', 'chatte', 'chattes', 6],
      ['Chien', 'chien.png', 'masculin', 'chien', 'chiens', 6],
      ['Chienne', 'chienne.png', 'feminin', 'chienne', 'chiennes', 6],
      ['Lapin', 'lapin.png', 'masculin', 'lapin', 'lapins', 6],
      ['Lapine', 'lapine.png', 'feminin', 'lapine', 'lapines', 6],
      ['Oiseau', 'oiseau.png', 'masculin', 'oiseau', 'oiseaux', 6],
      ['Oiselle', 'oiselle.png', 'feminin', 'oiselle', 'oiselles', 6],
      ['Poisson', 'poissons.png', 'masculin', 'poisson', 'poissons', 6],
      ['Canard', 'canard.png', 'masculin', 'canard', 'canards', 6],
      ['Cheval', 'cheval.png', 'masculin', 'cheval', 'chevaux', 6],
      ['Cochon', 'cochon.png', 'masculin', 'cochon', 'cochons', 6],
      ['Cochonne', 'cochonne.png', 'feminin', 'cochonne', 'cochonnes', 6],
      ['Crocodile', 'crocodile.png', 'masculin', 'crocodile', 'crocodiles', 6],
      ['Dauphin', 'dauphin.png', 'masculin', 'dauphin', 'dauphins', 6],
      ['Dinosaure', 'dinosaure.png', 'masculin', 'dinosaure', 'dinosaures', 6],
      ['Éléphant', 'elephant.png', 'masculin', 'éléphant', 'éléphants', 6],
      ['Éléphante', 'elephante.png', 'feminin', 'éléphante', 'éléphantes', 6],
      ['Escargot', 'escargot.png', 'masculin', 'escargot', 'escargots', 6],
      ['Grenouille', 'grenouille.png', 'feminin', 'grenouille', 'grenouilles', 6],
      ['Hamster', 'hamster.png', 'masculin', 'hamster', 'hamsters', 6],
      ['Lion', 'lion.png', 'masculin', 'lion', 'lions', 6],
      ['Lionne', 'lionne.png', 'feminin', 'lionne', 'lionnes', 6],
      ['Mouton', 'mouton.png', 'masculin', 'mouton', 'moutons', 6],
      ['Oie', 'oie.png', 'feminin', 'oie', 'oies', 6],
      ['Papillon', 'papillon.png', 'masculin', 'papillon', 'papillons', 6],
      ['Perruche', 'perruche.png', 'feminin', 'perruche', 'perruches', 6],
      ['Poule', 'poule.png', 'feminin', 'poule', 'poules', 6],
      ['Singe', 'singe.png', 'masculin', 'singe', 'singes', 6],
      ['Souris', 'souris.png', 'feminin', 'souris', 'souris', 6],
      ['Tortue', 'tortue.png', 'feminin', 'tortue', 'tortues', 6],
      ['Vache', 'vache.png', 'feminin', 'vache', 'vaches', 6],

      ['Bouche', 'bouche.png', 'feminin', 'bouche', 'bouches', 8],
      ['Mains', 'mains.png', 'feminin', 'main', 'mains', 8],
      ['Nez', 'nez.png', 'masculin', 'nez', 'nez', 8],
      ['Pieds', 'pieds.png', 'masculin', 'pied', 'pieds', 8],
      ['Oreille', 'oreille.png', 'feminin', 'oreille', 'oreilles', 8],
      ['Bras', 'bras.png', 'masculin', 'bras', 'bras', 8],
      ['Cheveux', 'cheveux.png', 'masculin', 'cheveu', 'cheveux', 8],
      ['Cou', 'cou.png', 'masculin', 'cou', 'cous', 8],
      ['Dent', 'dents.png', 'feminin', 'dents', 'dents', 8],
      ['Orteils', 'orteils.png', 'masculin', 'orteil', 'orteils', 8],
      ['Doigts', 'doigts.png', 'masculin', 'doigt', 'doigts', 8],
      ['Dos', 'dos.png', 'masculin', 'dos', 'dos', 8],
      ['Fesses', 'fesses.png', 'feminin', 'fesse', 'fesses', 8],
      ['Jambe', 'jambe.png', 'feminin', 'jambe', 'jambes', 8],
      ['Langue', 'langue.png', 'feminin', 'langue', 'langues', 8],
      ['Nombril', 'nombril.png', 'masculin', 'nombril', 'nombrils', 8],
      ['Nuque', 'nuque.png', 'feminin', 'nuque', 'nuques', 8],
      ['Poitrine', 'poitrine.png', 'feminin', 'poitrine', 'poitrines', 8],
      ['Tête', 'tete.png', 'feminin', 'tête', 'têtes', 8],
      ['Ventre', 'ventre.png', 'masculin', 'ventre', 'ventres', 8],
      ['Yeux', 'yeux.png', 'masculin', 'oeil', 'yeux', 8],

      ['Colère', 'colere.png', 'feminin', 'colère', 'colères', 11],
      ['Peur', 'peur.png', 'feminin', 'peur', 'peurs', 11],
      ['Honte', 'honte.png', 'feminin', 'honte', 'hontes', 11],

      ['Ananas', 'ananas.png', 'masculin', 'ananas', 'ananas', 12],
      ['Aubergine', 'aubergine.png', 'feminin', 'aubergine', 'aubergines', 12],
      ['Brocoli', 'brocoli.png', 'masculin', 'brocoli', 'brocolis', 12],
      ['Cerise', 'cerise.png', 'feminin', 'cerise', 'cerises', 12],
      ['Chou-fleur', 'chouFleur.png', 'masculin', 'chou-fleur', 'choux-fleurs', 12],
      ['Citron', 'citron.png', 'masculin', 'citron', 'citrons', 12],
      ['Cornichon', 'cornichon.png', 'masculin', 'cornichon', 'cornichons', 12],
      ['Framboise', 'framboises.png', 'feminin', 'framboise', 'framboises', 12],
      ['Haricots verts', 'haricotsVerts.png', 'masculin', 'haricot vert', 'haricots verts', 12],
      ['Maïs', 'mais.png', 'masculin', 'maïs', 'maïs', 12],
      ['Myrtille', 'myrtilles.png', 'feminin', 'myrtille', 'myrtilles', 12],
      ['Noix de coco', 'noixDeCoco.png', 'feminin', 'noix de coco', 'noix de coco', 12],
      ['Noix', 'noix.png', 'feminin', 'noix', 'noix', 12],
      ['Oignon', 'oignon.png', 'masculin', 'oignon', 'oignons', 12],
      ['Olive', 'olives.png', 'feminin', 'olive', 'olives', 12],
      ['Pastèque', 'pasteque.png', 'feminin', 'pastèque', 'pastèques', 12],
      ['Poire', 'poire.png', 'feminin', 'poire', 'poires', 12],
      ['Poireau', 'poireaux.png', 'masculin', 'poireau', 'poireaux', 12],
      ['Poivron', 'poivron.png', 'masculin', 'poivron', 'poivrons', 12],
      ['Pomme', 'pomme.png', 'feminin', 'pomme', 'pommes', 12],
      ['Raisin noir', 'raisinsNoirs.png', 'masculin', 'raisin noir', 'raisins noirs', 12],
      ['Salade', 'salade.png', 'feminin', 'salade', 'salades', 12],
      ['Tomate', 'tomate.png', 'feminin', 'tomate', 'tomates', 12],
      ['Banane', 'banane.png', 'feminin', 'banane', 'bananes', 12],
      ['Carotte', 'carotte.png', 'feminin', 'carotte', 'carottes', 12],
      ['Fraise', 'fraise.png', 'feminin', 'fraise', 'fraises', 12],
      ['Orange', 'orange.png', 'feminin', 'orange', 'oranges', 12],
      ['Pomme de terre', 'pommeDeTerre.png', 'feminin', 'pomme de terre', 'pommes de terre', 12],

      ['Hôpital', 'hopital.png', 'masculin', 'hôpital', 'hôpitaux', 14],
      ['Gare', 'gare.png', 'feminin', 'gare', 'gares', 14],
      ['Cinema', 'cinema.png', 'masculin', 'cinema', 'cinemas', 14],
      ['Piscine', 'piscine.png', 'feminin', 'piscine', 'piscines', 14],
      ['Ville', 'ville.png', 'feminin', 'ville', 'villes', 14],

      ['Arc-en-ciel', 'arcEnCiel.png', 'masculin', 'arc-en-ciel', 'arcs-en-ciel', 15],
      ['Soleil', 'soleil.png', 'masculin', 'soleil', 'soleils', 15],
      ['Nuage', 'nuage.png', 'masculin', 'nuage', 'nuages', 15],
      ['Éclair', 'eclair.png', 'masculin', 'éclair', 'éclairs', 15],
      ['Tonnerre', 'tonnerre.png', 'masculin', 'tonnerre', 'tonnerres', 15],
      ['Tornade', 'tornade.png', 'feminin', 'tornade', 'tornades', 15],

      ['Téléphone portable', 'telephonePortable.png', 'masculin', 'téléphone portable', 'téléphones portables', 16],
      ['Télévision', 'television.png', 'feminin', 'télévision', 'télévisions', 16],
      ['Ordinateur', 'ordinateur.png', 'masculin', 'ordinateur', 'ordinateurs', 16],
      ['Ordinateur portable', 'ordinateurPortable.png', 'masculin', 'ordinateur portable', 'ordinateurs portables', 16],
      ['Console', 'console.png', 'feminin', 'console', 'consoles', 16],

      ['Balai', 'balai.png', 'masculin', 'balai', 'balais', 17],
      ['Chaise', 'chaise.png', 'feminin', 'chaise', 'chaises', 17],
      ['Ciseaux', 'ciseaux1.png', 'masculin', NULL, 'ciseaux', 17],
      ['Coussin', 'coussin.png', 'masculin', 'coussin', 'coussins', 17],
      ['Bande dessinée', 'bandeDessinee.png', 'feminin', 'bande dessinée', 'bandes dessinées', 17],
      ['Table', 'table.png', 'feminin', 'table', 'tables', 17],
      ['Bibliothèque', 'bibliotheque.png', 'feminin', 'bibliothèque', 'bibliothèques', 17],
      ['Lampe', 'lampe.png', 'feminin', 'lampe', 'lampes', 17],
      ['Lit', 'lit.png', 'masculin', 'lit', 'lits', 17],
      ['Lunettes', 'lunettes.png', 'feminin', NULL, 'lunettes', 17],
      ['Pèse-personne', 'pesePersonne.png', 'masculin', 'pèse-personne', 'pèse-personnes', 17],
      ['Portefeuille', 'portefeuille.png', 'masculin', 'portefeuille', 'portefeuilles', 17],
      ['Poubelle', 'poubelle.png', 'feminin', 'poubelle', 'poubelles', 17],
      ['Sac à dos', 'sacADos.png', 'masculin', 'sac à dos', 'sacs à dos', 17],
      ['Seau', 'seau.png', 'masculin', 'seau', 'seaux', 17],

      ['Médecin', 'medecin.png', 'masculin', 'médecin', 'médecins', 18],
      ['Orthophoniste', 'orthophoniste.png', 'masculin', 'orthophoniste', 'orthophonistes', 18],
      ['Professeur', 'professeur.png', 'masculin', 'professeur', 'professeurs', 18],
      ['Professeure', 'professeur.png', 'feminin', 'professeure', 'professeures', 18],
      ['Astronaute', 'astronaute.png', 'masculin', 'astronaute', 'astronautes', 18],
      ['Bibliothécaire', 'bibliothecaire.png', 'feminin', 'bibliothécaire', 'bibliothécaires', 18],
      ['Caissière', 'caissiere.png', 'feminin', 'caissière', 'caissières', 18],
      ['Caissier', 'caissier.png', 'masculin', 'caissier', 'caissiers', 18],
      ['Chauffeur de taxi', 'chauffeurDeTaxi.png', 'masculin', 'chauffeur de taxi', 'chauffeurs de taxi', 18],
      ['Chauffeuse de taxi', 'chauffeuseDeTaxi.png', 'feminin', 'chauffeuse de taxi', 'chauffeuses de taxi', 18],
      ['Chef d\'orchestre', 'chefDOrchestre.png', 'masculin', 'chef d\'orchestre', 'chefs d\'orchestre', 18],
      ['Coiffeur', 'coiffeur.png', 'masculin', 'coiffeur', 'coiffeurs', 18],
      ['Coiffeuse', 'coiffeuse.png', 'feminin', 'coiffeuse', 'coiffeuses', 18],
      ['Cuisinier', 'cuisinier.png', 'masculin', 'cuisinier', 'cuisiniers', 18],
      ['Cuisinière', 'cuisiniere.png', 'feminin', 'cuisinière', 'cuisinières', 18],
      ['Danseur', 'danseur.png', 'masculin', 'danseur', 'danseurs', 18],
      ['Danseuse', 'danseuse.png', 'feminin', 'danseuse', 'danseuses', 18],
      ['Informaticien', 'informaticien.png', 'masculin', 'informaticien', 'informaticiens', 18],
      ['Informaticienne', 'informaticienne.png', 'feminin', 'informaticienne', 'informaticiennes', 18],
      ['Livreur', 'livreur.png', 'masculin', 'livreur', 'livreurs', 18],
      ['Livreuse', 'livreuse.png', 'feminin', 'livreuse', 'livreuses', 18],
      ['Moniteur', 'moniteur.png', 'masculin', 'moniteur', 'moniteurs', 18],
      ['Monitrice', 'monitrice.png', 'feminin', 'monitrice', 'monitrices', 18],
      ['Opticien', 'opticien.png', 'masculin', 'opticien', 'opticiens', 18],
      ['Opticienne', 'opticienne.png', 'feminin', 'opticienne', 'opticiennes', 18],
      ['Plombier', 'plombier.png', 'masculin', 'plombier', 'plombiers', 18],
      ['Plombière', 'plombiere.png', 'feminin', 'plombière', 'plombières', 18],
      ['Policier', 'policier.png', 'masculin', 'policier', 'policiers', 18],
      ['Policière', 'policiere.png', 'feminin', 'policière', 'policières', 18],
      ['Pompier', 'pompier.png', 'masculin', 'pompier', 'pompiers', 18],
      ['Pompière', 'pompiere.png', 'feminin', 'pompière', 'pompières', 18],
      ['Psychologue', 'psychologue.png', 'masculin', 'psychologue', 'psychologues', 18],
      ['Scientifique', 'scientifique.png', 'masculin', 'scientifique', 'scientifiques', 18],

      ['Cahier', 'cahier.png', 'masculin', 'cahier', 'cahiers', 19],
      ['Crayon', 'crayon.png', 'masculin', 'crayon', 'crayons', 19],
      ['Gomme', 'gomme.png', 'feminin', 'gomme', 'gommes', 19],
      ['Règle', 'regle.png', 'feminin', 'règle', 'règles', 19],
      ['Stylo', 'stylo.png', 'masculin', 'stylo', 'stylos', 19],
      ['Crayons de couleurs', 'crayonsDeCouleurs.png', 'masculin', 'crayon de couleurs', 'crayons de couleurs', 19],
      ['Calculatrice', 'calculatrice.png', 'feminin', 'calculatrice', 'calculatrices', 19],
      ['Dictionnaire', 'dictionnaire.png', 'masculin', 'dictionnaire', 'dictionnaires', 19],
      ['Feutre', 'feutre.png', 'masculin', 'feutre', 'feutres', 19],
      ['Papier', 'papier.png', 'masculin', 'papier', 'papiers', 19],
      ['Pinceau', 'pinceau.png', 'masculin', 'pinceau', 'pinceaux', 19],
      ['Récréation', 'recreation.png', 'feminin', 'récréation', 'récréations', 19],
      ['Scotch', 'scotch.png', 'masculin', 'scotch', NULL, 19],
      ['Tableau', 'tableau.png', 'masculin', 'tableau', 'tableaux', 19],
      ['Compas', 'compas.png', 'masculin', 'compas', 'compas', 19],

      ['Ambulance', 'ambulance.png', 'feminin', 'ambulance', 'ambulances', 20],
      ['Avion', 'avion.png', 'masculin', 'avion', 'avions', 20],
      ['Métro', 'metro.png', 'masculin', 'métro', 'métros', 20],
      ['Taxi', 'taxi.png', 'masculin', 'taxi', 'taxis', 20],
      ['Train', 'train.png', 'masculin', 'train', 'trains', 20],
      ['Fusée', 'fusee.png', 'feminin', 'fusée', 'fusées', 20],
      ['Bateau', 'bateau.png', 'masculin', 'bateau', 'bateaux', 20],
      ['Bus', 'bus.png', 'masculin', 'bus', 'bus', 20],
      ['Camion de pompiers', 'camionDePompiers.png', 'masculin', 'camion de pompiers', 'camions de pompiers', 20],
      ['Camion', 'camion.png', 'masculin', 'camion', 'camions', 20],
      ['Moto', 'moto.png', 'feminin', 'moto', 'motos', 20],
      ['Tricycle', 'tricycle.png', 'masculin', 'tricycle', 'tricycles', 20],
      ['Vélo', 'velo.png', 'masculin', 'vélo', 'vélos', 20],
      ['Trottinette', 'trottinette.png', 'feminin', 'trottinette', 'trottinettes', 20],
      ['Voiture', 'voiture.png', 'feminin', 'voiture', 'voitures', 20],

      ['Chaussettes', 'chaussettes.png', 'feminin', 'chaussette', 'chaussettes', 21],
      ['Chaussures', 'chaussures.png', 'feminin', 'chaussure', 'chaussures', 21],
      ['Manteau', 'manteau.png', 'masculin', 'manteau', 'manteaux', 21],
      ['Pantalon', 'pantalon.png', 'masculin', 'pantalon', 'pantalons', 21],
      ['Tee-shirt', 'teeShirt.png', 'masculin', 'tee-shirt', 'tee-shirts', 21],
      ['Chemise', 'chemise.png', 'feminin', 'chemise', 'chemises', 21],
      ['Culotte', 'culotte.png', 'feminin', 'culotte', 'culottes', 21],
      ['Anorak', 'anorak.png', 'masculin', 'anorak', 'anoraks', 21],
      ['Ciré', 'cire.png', 'masculin', 'cirés', 'cirés', 21],
      ['Collant', 'collant.png', 'masculin', 'collant', 'collants', 21],
      ['Gant', 'gant.png', 'masculin', 'gant', 'gants', 21],
      ['Jupe', 'jupe.png', 'feminin', 'jupe', 'jupes', 21],
      ['Maillot de bain', 'maillotDeBain.png', 'masculin', 'maillot de bain', 'maillots de bain', 21],
      ['Moufle', 'moufle.png', 'feminin', 'moufle', 'moufles', 21],
      ['Polo', 'polo.png', 'masculin', 'polo', 'polos', 21],
      ['Pyjama hôpital', 'pyjamaHopital.png', 'masculin', 'pyjama hôpital', 'pyjamas hôpital', 21],
      ['Pyjama', 'pyjama.png', 'masculin', 'pyjama', 'pyjamas', 21],
      ['Robe', 'robe.png', 'feminin', 'robe', 'robes', 21],
      ['Short', 'short.png', 'masculin', 'short', 'shorts', 21],
      ['Slip', 'slip.png', 'masculin', 'slip', 'slips', 21],
      ['Sweet-shirt', 'sweetShirt.png', 'masculin', 'sweet-shirt', 'sweet-shirts', 21],
      ['Veste', 'veste.png', 'feminin', 'veste', 'vestes', 21],
      // subcats
      ['École', 'ecole.png', 'feminin', 'école', 'écoles', 33],

      ['Salle de bain', 'salleDeBain.png', 'feminin', 'salle de bain', 'salles de bains', 44],
      ['Chambre à coucher', 'chambreACoucher.png', 'feminin', 'chambre à coucher', 'chambres à coucher', 44],
      ['Maison', 'maison.png', 'feminin', 'maison', 'maisons', 44],
      ['Cuisine', 'cuisine.png', 'feminin', 'cuisine', 'cuisines', 44],
      ['Salon', 'salon.png', 'masculin', 'salon', 'salons', 44],

      ['Boulangerie', 'boulangerie.png', 'feminin', 'boulangerie', 'boulangeries', 66],
      ['Magasin de glaces', 'magasinDeGlaces.png', 'masculin', 'magasin de glaces', 'magasins de glaces', 66],
      ['Pharmacie', 'pharmacie.png', 'feminin', 'pharmacie', 'pharmacies', 66],
      ['Salon de coiffure', 'salonDeCoiffure.png', 'masculin', 'salon de coiffure', 'salons de coiffure', 66],
      ['Supermarché', 'supermarche.png', 'masculin', 'supermarché', 'supermarchés', 66],

      ['Grand-mère', 'grandMere.png', 'feminin', 'grand-mère', 'grand-mères', 77],
      ['Papa', 'papa.png', 'masculin', 'papa', 'papas', 77],
      ['Grand-père', 'grandPere.png', 'masculin', 'grand-père', 'grand-pères', 77],
      ['Maman', 'maman.png', 'feminin', 'maman', 'mamans', 77],

      ['Casserole', 'casserole.png', 'feminin', 'casserole', 'casseroles', 88],
      ['Conserves', 'conserve.png', 'feminin', 'conserve', 'conserves', 88],
      ['Couvert', 'couverts.png', 'masculin', 'couvert', 'couverts', 88],
      ['Réfrigérateur', 'refrigerateur.png', 'masculin', 'réfrigérateur', 'réfrigérateurs', 88],
      ['Tasse', 'tasse.png', 'feminin', 'tasse', 'tasses', 88],
      ['Vaisselle', 'vaisselle.png', 'feminin', 'vaisselle', 'vaisselles', 88],
      ['Couteau', 'couteau.png', 'masculin', 'couteau', 'couteaux', 88],
      ['Cuillère', 'cuillere.png', 'feminin', 'cuillère', 'cuillères', 88],
      ['Fourchette', 'fourchette.png', 'feminin', 'fourchette', 'fourchettes', 88],

      ['Brosse à dents', 'brosseADents.png', 'feminin', 'brosse à dents', 'brosses à dents', 99],
      ['Serviette de bain', 'servietteDeBain.png', 'feminin', 'serviette de bain', 'serviettes de bain', 99],
      ['Affaires de toilettes', 'affairesDeToilette.png', 'feminin', 'affaire de toilettes', 'affaires de toilettes', 99],
      ['Trousse de toilettes', 'trousseDeToilette.png', 'feminin', 'trousse de toilettes', 'trousses de toilettes', 99],

    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('nom');
      $pictogram->addTag($this->tagRepo->findOneByTitle($row[2]));

      $pictogram->setCreatedAt(new DateTimeImmutable());
      $pictogram->setUpdatedAt(new DateTimeImmutable());

      switch ($row[5]) {
        case 2:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Boissons"));
          break;
        case 5:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Aliments"));
          break;
        case 6:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Animaux"));
          break;
        case 8:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Corps humain"));
          break;
        case 11:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Émotions"));
          break;
        case 12:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Fruits et légumes"));
          break;
        case 14:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lieux"));
          break;
        case 15:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Météo"));
          break;
        case 16:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Multimédia"));
          break;
        case 17:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Objets"));
          break;
        case 18:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Personnes"));
          break;
        case 19:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Scolarité"));
          break;
        case 20:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Transports"));
          break;
        case 21:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Vêtements"));
          break;
          //subcats
        case 33:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Ecole"));
          break;
        case 44:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Maison"));
          break;
        case 66:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Magasins"));
          break;
        case 77:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Famille"));
          break;
        case 88:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Objets de la cuisine"));
          break;
        case 99:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Objets de la salle de bain"));
          break;
        default:
          break;
      }
      $manager->persist($pictogram);
    }
  }

  private function populatePictogramVerb(ObjectManager $manager)
  {
    $output = new ConsoleOutput();
    $data = [
      ['Vouloir', 'vouloir.png', 'veux', 'veux', 'veut', 'voulons', 'voulez', 'veulent', 'voudrai', 'voudras', 'voudra', 'voudrons', 'voudrez', 'voudront', 'ai voulu', 'as voulu', 'a voulu', 'avons voulu', 'avez voulu', 'ont voulu', 3],
      ['Regarder', 'regarder.png', 'regarde', 'regardes', 'regarde', 'regardons', 'regardez', 'regardent', 'regarderai', 'regarderas', 'regardera', 'regarderons', 'regarderez', 'regarderont', 'ai regardé', 'as regardé', 'a regardé', 'avons regardé', 'avez regardé', 'ont regardé', 3],
      ['Boire', 'boire.png', 'bois', 'bois', 'boit', 'buvons', 'buvez', 'boivent', 'boirai', 'boiras', 'boira', 'boirons', 'boirez', 'boiront', 'ai bu', 'as bu', 'a bu', 'avons bu', 'avez bu', 'ont bu', 3],
      ['Manger', 'manger.png', 'mange', 'manges', 'mange', 'mangeons', 'mangez', 'mangent', 'mangerai', 'mangeras', 'mangera', 'mangerons', 'mangerez', 'mangeront', 'ai mangé', 'as mangé', 'a mangé', 'avons mangé', 'avez mangé', 'ont mangé', 3],
      ['Aller', 'aller.png', 'vais', 'vas', 'va', 'allons', 'allez', 'vont', 'irai', 'iras', 'ira', 'irons', 'irez', 'iront', 'suis allé', 'es allé', 'est allé', 'sommes allés', 'êtes allés', 'sont allés', 3],
      ['Avoir', 'avoir.png', 'ai', 'as', 'a', 'avons', 'avez', 'ont', 'aurai', 'auras', 'aura', 'aurons', 'aurez', 'auront', 'ai eu', 'as eu', 'a eu', 'avons eu', 'avez eu', 'ont eu', 3],
      ['Aller aux toilettes', 'allerAuxToilettes.png', 'vais aux toilettes', 'vas aux toilettes', 'va aux toilettes', 'allons aux toilettes', 'allez aux toilettes', 'vont aux toilettes', 'irai aux toilettes', 'iras aux toilettes', 'ira aux toilettes', 'irons aux toilettes', 'irez aux toilettes', 'iront aux toilettes', 'suis allé aux toilettes', 'es allé aux toilettes', 'est allé aux toilettes', 'sommes allés aux toilettes', 'êtes allés aux toilettes', 'sont allés aux toilettes', 3],
      ['Couper', 'couper.png', 'coupe', 'coupes', 'coupe', 'coupons', 'coupez', 'coupent', 'couperai', 'couperas', 'coupera', 'couperons', 'couperez', 'couperont', 'ai coupé', 'as coupé', 'a coupé', 'avons coupé', 'avez coupé', 'ont coupé', 3],
      ['Courir', 'courir.png', 'cours', 'cours', 'court', 'courons', 'courez', 'courent', 'courrai', 'courras', 'courra', 'courrons', 'courrez', 'courront', 'ai couru', 'as couru', 'a couru', 'avons couru', 'avez couru', 'ont couru', 3],
      ['Descendre', 'descendre.png', 'descends', 'descends', 'descend', 'descendons', 'descendez', 'descendent', 'descendrai', 'descendras', 'descendra', 'descendrons', 'descendrez', 'descendront', 'ai descendu', 'as descendu', 'a descendu', 'avons descendu', 'avez descendu', 'ont descendu', 3],
      ['Dessiner', 'dessiner.png', 'dessine', 'dessines', 'dessine', 'dessinons', 'dessinez', 'dessinent', 'dessinerai', 'dessineras', 'dessinera', 'dessinerons', 'dessinerez', 'dessineront', 'ai dessiné', 'as dessiné', 'a dessiné', 'avons dessiné', 'avez dessiné', 'ont dessiné', 3],
      ['Écouter', 'ecouter.png', 'écoute', 'écoutes', 'écoute', 'écoutons', 'écoutez', 'écoutent', 'écouterai', 'écouteras', 'écoutera', 'écouterons', 'écouterez', 'écouteront', 'ai écouté', 'as écouté', 'a écouté', 'avons écouté', 'avez écouté', 'ont écouté', 3],
      ['Écrire', 'ecrire.gif', 'écris', 'écris', 'écrit', 'écrivons', 'écrivez', 'écrivent', 'écrirai', 'écriras', 'écrira', 'écrirons', 'écrirez', 'écriront', 'ai écrit', 'as écrit', 'a écrit', 'avons écrit', 'avez écrit', 'ont écrit', 3],
      ['Être', 'etre.png', 'suis', 'es', 'est', 'sommes', 'êtes', 'sont', 'serai', 'seras', 'sera', 'serons', 'serez', 'seront', 'ai été', 'as été', 'a été', 'avons été', 'avez été', 'ont été', 3],
      ['Jouer', 'jouer.png', 'joue', 'joues', 'joue', 'jouons', 'jouez', 'jouent', 'jouerai', 'joueras', 'jouera', 'jouerons', 'jouerez', 'joueront', 'ai joué', 'as joué', 'a joué', 'avons joué', 'avez joué', 'ont joué', 3],
      ['Laver le linge', 'laverLeLinge.png', 'lave le linge', 'laves le linge', 'lave le linge', 'lavons le linge', 'lavez le linge', 'lavent le linge', 'laverai le linge', 'laveras le linge', 'lavera le linge', 'laverons le linge', 'laverez le linge', 'laveront le linge', 'ai lavé le linge', 'as lavé le linge', 'a lavé le linge', 'avons lavé le linge', 'avez lavé le linge', 'ont lavé le linge', 3],
      ['Laver les dents', 'laverLesDents.png', 'lave les dents', 'laves les dents', 'lave les dents', 'lavons les dents', 'lavez les dents', 'lavent les dents', 'laverai les dents', 'laveras les dents', 'lavera les dents', 'laverons les dents', 'laverez les dents', 'laveront les dents', 'ai lavé les dents', 'as lavé les dents', 'a lavé les dents', 'avons lavé les dents', 'avez lavé les dents', 'ont lavé les dents', 3],
      ['Laver', 'laver.png', 'lave', 'laves', 'lave', 'lavons', 'lavez', 'lavent', 'laverai', 'laverai', 'lavera', 'laverons', 'laverez', 'laveront', 'ai lavé', 'as lavé', 'a lavé', 'avons lavé', 'avez lavé', 'ont lavé', 3],
      ['Lire', 'lire.png', 'lis', 'lis', 'lit', 'lisons', 'lisez', 'lisent', 'lirai', 'liras', 'lira', 'lirons', 'lirez', 'liront', 'ai lu', 'as lu', 'a lu', 'avons lu', 'avez lu', 'ont lu', 3],
      ['Monter', 'monter.png', 'monte', 'montes', 'monte', 'montons', 'montez', 'montent', 'monterai', 'monteras', 'montera', 'monterons', 'monterez', 'monteront', 'ai monté', 'as monté', 'a monté', 'avons monté', 'avez monté', 'ont monté', 3],
      ['Se moucher', 'moucher.png', 'me mouche', 'te mouches', 'se mouche', 'nous mouchons', 'vous mouchez', 'se mouchent', 'me moucherai', 'te moucheras', 'se mouchera', 'nous moucherons', 'vous moucherez', 'se moucheront', 'me suis mouché', 't\'es mouché', 's\'est mouché', 'nous sommes mouchés', 'vous êtes mouchés', 'se sont mouchés', 3],
      ['Nager', 'nager.png', 'nage', 'nages', 'nage', 'nageons', 'nagez', 'nagent', 'nagerai', 'nageras', 'nagera', 'nagerons', 'nagerez', 'nageront', 'ai nagé', 'as nagé', 'a nagé', 'avons nagé', 'avez nagé', 'ont nagé', 3],
      ['Prendre un bain', 'prendreUnBain.png', 'prends un bain', 'prends un bain', 'prend un bain', 'prenons un bain', 'prenez un bain', 'prennent un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'prendrai un bain', 'ai pris un bain', 'as pris un bain', 'a pris un bain', 'avons pris un bain', 'avez pris un bain', 'ont pris un bain', 3],
      ['Regarder la télévision', 'regarderLaTelevision.png', 'regarde la télévision', 'regardes la télévision', 'regarde la télévision', 'regardons la télévision', 'regardez la télévision', 'regardent la télévision', 'regarderai la télévision', 'regarderas la télévision', 'regardera la télévision', 'regarderons la télévision', 'regarderez la télévision', 'regarderont la télévision', 'ai regardé la télévision', 'as regardé la télévision', 'a regardé la télévision', 'avons regardé la télévision', 'avez regardé la télévision', 'ont regardé la télévision', 3],
      ['Remplir', 'remplir.png', 'remplis', 'remplis', 'remplit', 'remplissons', 'remplissez', 'remplissent', 'remplirai', 'rempliras', 'remplira', 'remplirons', 'remplirez', 'rempliront', 'ai rempli', 'as rempli', 'a rempli', 'avons rempli', 'avez rempli', 'ont rempli', 3],
      ['Renverser', 'renverser.png', 'renverse', 'renverses', 'renverse', 'renversons', 'renversez', 'renversent', 'renverserai', 'renverseras', 'renversera', 'renverserons', 'renverserez', 'renverseront', 'ai renversé', 'as renversé', 'a renversé', 'avons renversé', 'avez renversé', 'ont renversé', 3],
      ['S\'habiller', 'sHabiller.png', 'm\'habille', 't\'habilles', 's\'habille', 'nous habillons', 'vous habillez', 's\'habillent', 'm\'habillerai', 't\'habilleras', 's\'habillera', 'nous habillerons', 'vous habillerez', 's\'habilleront', 'me suis habillé', 't\'es habillé', 's\'est habillé', 'nous sommes habillés', 'vous êtes habillés', 'se sont habillés', 3],
      ['Salir', 'salir.png', 'salis', 'salis', 'salit', 'salissons', 'salissez', 'salissent', 'salirai', 'saliras', 'salira', 'salirons', 'salirez', 'saliront', 'ai sali', 'as sali', 'a sali', 'avons sali', 'avez sali', 'ont sali', 3],
      ['Se déshabiller', 'seDeshabiller.png', 'me déshabille', 'te déshabilles', 'se déshabille', 'nous déshabillons', 'vous déshabillez', 'se déshabillent', 'me déshabillerai', 'te déshabilleras', 'se déshabillera', 'nous déshabillerons', 'vous déshabillerez', 'se déshabilleront', 'me suis déshabillé', 't\'es déshabillé', 's\'est déshabillé', 'nous sommes déshabillés', 'vous êtes déshabillés', 'se sont déshabillés', 3],
      ['Siffler', 'siffler.png', 'siffle', 'siffles', 'siffle', 'sifflons', 'sifflez', 'sifflent', 'sifflerai', 'siffleras', 'sifflera', 'sifflerons', 'sifflerez', 'siffleront', 'ai sifflé', 'as sifflé', 'a sifflé', 'avons sifflé', 'avez sifflé', 'ont sifflé', 3],
      ['Téléphoner', 'telephoner.png', 'téléphone', 'téléphones', 'téléphone', 'téléphonons', 'téléphonez', 'téléphonent', 'téléphonerai', 'téléphoneras', 'téléphonera', 'téléphonerons', 'téléphonerez', 'téléphoneront', 'ai téléphoné', 'as téléphoné', 'a téléphoné', 'avons téléphoné', 'avez téléphoné', 'ont téléphoné', 3],
      ['Asseoir', 'asseoir.png', 'assieds', 'assieds', 'assied', 'asseyons', 'asseyez', 'asseyent', 'assiérai', 'assiéras', 'assiéra', 'assiérons', 'assiérez', 'assiéront', 'ai assis', 'as assis', 'a assis', 'avons assis', 'avez assis', 'ont assis', 22],
      ['Casser', 'casser.png', 'casse', 'casses', 'casse', 'cassons', 'cassez', 'cassent', 'casserai', 'casseras', 'cassera', 'casserons', 'casserez', 'casseront', 'ai cassé', 'as cassé', 'a cassé', 'avons cassé', 'avez cassé', 'ont cassé', 22],
      ['Cracher', 'cracher.png', 'crache', 'craches', 'crache', 'crachons', 'crachez', 'crachent', 'cracherai', 'cracheras', 'crachera', 'cracherons', 'cracherez', 'cracheront', 'ai craché', 'as craché', 'a craché', 'avons craché', 'avez craché', 'ont craché', 22],
      ['Crier', 'crier.png', 'crie', 'cries', 'crie', 'crions', 'criez', 'crient', 'crierai', 'crieras', 'criera', 'crierons', 'crierez', 'crieront', 'ai crié', 'as crié', 'a crié', 'avons crié', 'avez crié', 'ont crié', 22],
      ['Disputer', 'disputer.png', 'dispute', 'disputes', 'dispute', 'disputons', 'disputez', 'disputent', 'disputerai', 'disputeras', 'disputera', 'disputerons', 'disputerez', 'disputeront', 'ai disputé', 'as disputé', 'a disputé', 'avons disputé', 'avez disputé', 'ont disputé', 22],
      ['Frapper', 'frapper.png', 'frappe', 'frappes', 'frappe', 'frappons', 'frappez', 'frappent', 'frapperai', 'frapperas', 'frappera', 'frapperons', 'frapperez', 'frapperont', 'ai frappé', 'as frappé', 'a frappé', 'avons frappé', 'avez frappé', 'ont frappé', 22],
      ['Jeter', 'jeter.png', 'jette', 'jettes', 'jette', 'jetons', 'jetez', 'jettent', 'jetterai', 'jetteras', 'jettera', 'jetterons', 'jetterez', 'jetteront', 'ai jeté', 'as jeté', 'a jeté', 'avons jeté', 'avez jeté', 'ont jeté', 22],
      ['Griffer', 'griffer.png', 'griffe', 'griffes', 'griffe', 'griffons', 'griffez', 'griffent', 'grifferai', 'grifferas', 'griffera', 'grifferons', 'grifferez', 'grifferont', 'ai griffé', 'as griffé', 'a griffé', 'avons griffé', 'avez griffé', 'ont griffé', 22],
      ['Mordre', 'mordre.png', 'mords', 'mords', 'mord', 'mordons', 'mordez', 'mordent', 'mordrai', 'mordras', 'mordra', 'mordrons', 'mordrez', 'mordront', 'ai mordu', 'as mordu', 'a mordu', 'avons mordu', 'avez mordu', 'ont mordu', 22],
      ['Trépigner', 'trepigner.png', 'trépigne', 'trépigne', 'trépigne', 'trépignons', 'trépignez', 'trépignent', 'trépignerai', 'trépigneras', 'trépignera', 'trépignerons', 'trépignerez', 'trépigneront', 'ai trépigné', 'as trépigné', 'a trépigné', 'avons trépigné', 'avez trépigné', 'ont trépigné', 22],
    ];
    $irregular = [
      "être",
      "avoir",
      "aller",
      "faire",
      "venir",
      "pouvoir",
      "vouloir",
      "devoir",
      "savoir",
      "voir",
      "dire",
      "savoir",
      "falloir",
      "pleuvoir",
      "recevoir",
      "savoir",
      "battre",
      "boire",
      "connaître",
      "courir",
      "croire",
      "devoir",
      "dormir",
      "écrire",
      "lire",
      "mettre",
      "prendre",
      "rire",
      "suivre",
      "vivre"
    ];
    $withEtre = [
      'arriver',
      'descendre',
      'mourir',
      'partir',
      'passer',
      'rester',
      'retourner',
      'sortir',
      'tomber',
      'venir',
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('verbe');

      $pictogram->setCreatedAt(new DateTimeImmutable());
      $pictogram->setUpdatedAt(new DateTimeImmutable());

      if (in_array(strtolower($row[0]), $irregular)) {
        $pictogram->addTag($this->tagRepo->findOneByTitle('irregulier'));
      }
      if (in_array(strtolower($row[0]), $withEtre) || strtolower($row[0][0] == 's')) {
        $pictogram->addTag($this->tagRepo->findOneByTitle('auxiliaire_etre'));
      } else {
        $pictogram->addTag($this->tagRepo->findOneByTitle('auxiliaire_avoir'));
      }

      switch ($row[20]) {
        case 3:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Actions"));
          break;
        case 22:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Comportements"));
          break;
        default:
          $output->writeln($pictogram->getTitle());
          break;
      }

      $manager->persist($pictogram);
    }
  }

  private function populatePictogramAdjective(ObjectManager $manager)
  {
    $data = [
      ['Court', 'court.png', 'court', 'courts', 'courte', 'courtes', 4],
      ['Petit', 'petit.png', 'petit', 'petits', 'petite', 'petites', 4],
      ['Grand', 'grand.png', 'grand', 'grands', 'grande', 'grandes', 4],
      ['Long', 'long.png', 'long', 'longs', 'longue', 'longues', 4],
      ['Correct', 'correct.png', 'correct', 'corrects', 'correcte', 'correctes', 4],
      ['Incorrect', 'incorrect.png', 'incorrect', 'incorrects', 'incorrecte', 'incorrectes', 4],
      ['Accompagnée', 'accompagnee.png', 'accompagné', 'accompagnés', 'accompagnée', 'accompagnées', 4],
      ['Cassé', 'casse.png', 'cassé', 'cassés', 'cassée', 'cassées', 4],
      ['Coiffée', 'coiffee.png', 'coiffé', 'coiffés', 'coiffée', 'coiffées', 4],
      ['Décoiffé', 'décoiffe.png', 'décoiffé', 'décoiffés', 'décoiffée', 'décoiffées', 4],
      ['Dernier', 'dernier.png', 'dernier', 'derniers', 'dernière', 'dernières', 4],
      ['Deuxième', 'deuxieme.png', 'deuxième', 'deuxièmes', 'deuxième', 'deuxièmes', 4],
      ['Étroit', 'etroit.png', 'étroit', 'étroits', 'étroite', 'étroites', 4],
      ['Fermé', 'ferme.png', 'fermé', 'fermés', 'fermée', 'fermées', 4],
      ['Gros', 'gros.png', 'gros', 'gros', 'grosse', 'grosses', 4],
      ['Large', 'large.png', 'large', 'larges', 'large', 'larges', 4],
      ['Lent', 'lent.png', 'lent', 'lents', 'lente', 'lentes', 4],
      ['Mince', 'mince.png', 'mince', 'minces', 'mince', 'minces', 4],
      ['Mouillé', 'mouille.png', 'mouillé', 'mouillés', 'mouillée', 'mouillées', 4],
      ['Ouvert', 'ouvert.png', 'ouvert', 'ouverts', 'ouverte', 'ouvertes', 4],
      ['Premier', 'premier.png', 'premier', 'premiers', 'première', 'premières', 4],
      ['Sec', 'sec.png', 'sec', 'secs', 'sèche', 'sèches', 4],
      ['Seul', 'seul.png', 'seul', 'seuls', 'seule', 'seules', 4],
      ['Vide', 'vide.png', 'vide', 'vides', 'vide', 'vides', 4],
      ['Blanc', 'blanc.png', 'blanc', 'blancs', 'blanche', 'blanches', 9],
      ['Bleu', 'bleu.png', 'bleu', 'bleus', 'bleue', 'bleues', 9],
      ['Rouge', 'rouge.png', 'rouge', 'rouges', 'rouge', 'rouges', 9],
      ['Vert', 'vert.png', 'vert', 'verts', 'verte', 'vertes', 9],
      ['Rose', 'rose.png', 'rose', 'roses', 'rose', 'roses', 9],
      ['Gris', 'gris.png', 'gris', 'gris', 'grise', 'grises', 9],
      ['Jaune', 'jaune.png', 'jaune', 'jaunes', 'jaune', 'jaunes', 9],
      ['Marron', 'marron.png', 'marron', 'marrons', 'marronne', 'marronnes', 9],
      ['Noir', 'noir.png', 'noir', 'noirs', 'noire', 'noires', 9],
      ['Curieux', 'curieux.png', 'curieux', 'curieux', 'curieuse', 'curieuses', 11],
      ['Inquiet', 'inquiet.png', 'inquiet', 'inquiets', 'inquiète', 'inquiètes', 11],
      ['Joyeux', 'joyeux.png', 'joyeux', 'joyeux', 'joyeuse', 'joyeuses', 11],
      ['Amoureux', 'amoureux.png', 'amoureux', 'amoureux', 'amoureuse', 'amoureuses', 11],
      ['Confus', 'confus.png', 'confus', 'confus', 'confuse', 'confuses', 11],
      ['Content', 'content.png', 'content', 'contents', 'contente', 'contentes', 11],
      ['Distrait', 'distrait.png', 'distrait', 'distraits', 'distraite', 'distraites', 11],
      ['Ennuyeux', 'ennuyeux.png', 'ennuyeux', 'ennuyeux', 'ennuyeuse', 'ennuyeuses', 11],
      ['Fatigué', 'fatigue.png', 'fatigué', 'fatigués', 'fatiguée', 'fatiguées', 11],
      ['Surpris', 'surpris.png', 'surpris', 'surpris', 'surprise', 'surprises', 11],
      ['Timide', 'timide.png', 'timide', 'timides', 'timide', 'timides', 11],
      ['Triste', 'triste.png', 'triste', 'tristes', 'triste', 'tristes', 11],
      ['Venteux', 'venteux.png', 'venteux', 'venteux', 'venteuse', 'venteuses', 15],
      ['Pluvieux', 'pluvieux.png', 'pluvieux', 'pluvieux', 'pluvieuse', 'pluvieuses', 15],
      ['Gelée', 'gelee.png', 'gelé', 'gelés', 'gelée', 'gelées', 15],
      ['Brumeux', 'brumeux.png', 'brumeux', 'brumeux', 'brumeuse', 'brumeuses', 15],
      ['Ensoleillé', 'ensoleille.png', 'ensoleillé', 'ensoleillés', 'ensoleillée', 'ensoleillées', 15],
      ['Neigeux', 'neigeux.png', 'neigeux', 'neigeux', 'neigeuse', 'neigeuses', 15],
      ['Nuageux', 'nuageux.png', 'nuageux', 'nuageux', 'nuageuse', 'nuageuses', 15],
      ['Orageux', 'orageux.png', 'orageux', 'orageux', 'orageuse', 'orageuses', 15],
    ];
    $irregular = [
      "bon",
      "mauvais",
      "vieux",
      "nouveau",
      "beau",
      "joli",
      "grand",
      "petit",
      "gros",
      "long",
      "haut",
      "bas",
      "jeune",
      "premier",
      "dernier",
      "meilleur",
      "pire",
      "moindre",
      "supérieur",
      "inférieur",
      "extérieur",
      "prochain",
      "ancien",
      "cher",
      "libre",
      "public",
      "fou",
      "faux",
      "doux",
      "fier",
      "riche",
      "pur",
      "dur",
      "sûr",
      "commun",
      "vif",
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('adjectif');
      
      if (in_array(strtolower($row[0]), $irregular)) {
        $pictogram->addTag($this->tagRepo->findOneByTitle('irregulier'));
      }

      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      switch ($row[6]) {
        case 4:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Adjectifs"));
          break;
        case 9:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Couleurs"));
          break;
        case 11:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Émotions"));
          break;
        case 15:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Météo"));
          break;
        default:
          break;
      }

      $manager->persist($pictogram);
    }
  }
  
  private function populatePictogramInterogative(ObjectManager $manager)
  {
    $data = [
      ['? ', 'interrogatif.png', 36],
      ['Combien', 'interrogatif_combien.png', 36],
      ['Comment', 'interrogatif_comment.png', 36],
      ['Pourquoi', 'interrogatif_pourquoi.png', 36],
      ['Ou ', 'interrogatif_ou.png', 36],
      ['Quand ', 'interrogatif_quand.png', 36],
      ['Que ', 'interrogatif_que.png', 36],
      ['Qui', 'interrogatif_qui.png', 36],
      ['Quoi ', 'interrogatif_quoi.png', 36],
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('interrogatif');
      $pictogram->setCategory($this->cRepo->findOneByTitle("Interrogatif"));
      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      $manager->persist($pictogram);
    }
  }
  
  private function populatePictogramTime(ObjectManager $manager)
  {
    $data = [
      ['Matin', 'temps_matin.png', 37],
      ['Midi', 'temps_midi.png', 37],
      ['Après-midi ', 'temps_apresmidi.png', 37],
      ['Soir ', 'temps_soir.png', 37],

      ['Midi', 'heure_12h.png', 38],
      ['Midi quart', 'heure_12h15.png', 38],
      ['Midi trente', 'heure_12h30.png', 38],
      ['Midi quarante cinq', 'heure_12h45.png', 38],
      ['Neuf heures', 'heure_9h.png', 38],
      ['Neuf heures quinze', 'heure_9h15.png', 38],
      ['Neuf heures trente', 'heure_9h30.png', 38],
      ['Neuf heures quarante cinq', 'heure_9h45.png', 38],
      ['Huit heures', 'heure_8h.png', 38],
      ['Huit heures quinze', 'heure_8h15.png', 38],
      ['Huit heures trente', 'heure_8h30.png', 38],
      ['Huit heures quarante cinq', 'heure_8h45.png', 38],
      ['Sept heures', 'heure_7h.png', 38],
      ['Sept heures quinze', 'heure_7h15.png', 38],
      ['Sept heures trente', 'heure_7h30.png', 38],
      ['Sept heures quarante cinq', 'heure_7h45.png', 38],
      ['Six heures', 'heure_6h.png', 38],
      ['Six heures quinze', 'heure_6h15.png', 38],
      ['Six heures trente', 'heure_6h30.png', 38],
      ['Six heures quarante cinq', 'heure_6h45.png', 38],
      ['Cinq heures', 'heure_5h.png', 38],
      ['Cinq heures quinze', 'heure_5h15.png', 38],
      ['Cinq heures trente', 'heure_5h30.png', 38],
      ['Cinq heures quarante cinq', 'heure_5h45.png', 38],
      ['Quatre heures', 'heure_4h.png', 38],
      ['Quatre heures quinze', 'heure_4h15.png', 38],
      ['Quatre heures trente', 'heure_4h30.png', 38],
      ['Quatre heures quarante cinq', 'heure_4h45.png', 38],
      ['Trois heures', 'heure_3h.png', 38],
      ['Trois heures quinze', 'heure_3h15.png', 38],
      ['Trois heures trente', 'heure_3h30.png', 38],
      ['Trois heures quarante cinq', 'heure_3h45.png', 38],
      ['Deux heures', 'heure_2h.png', 38],
      ['Deux heures quinze', 'heure_2h15.png', 38],
      ['Deux heures trente', 'heure_2h30.png', 38],
      ['Deux heures quarante cinq', 'heure_2h45.png', 38],
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('invariable');
      switch ($row[2]) {
        case 37:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Journee"));
          break;
        case 38:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Heures"));
          break;
        default:
          break;
      }
      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      $manager->persist($pictogram);
    }
  }
  
  private function populatePictogramPreposition(ObjectManager $manager)
  {
    $data = [
      ['Aux', 'aux1.png', 10],
      ['À la', 'aLa.png', 10],
      ['À', 'a.png', 10],
      ['Chez', 'chez.png', 11],
      ['Dans', 'dans.png', 12],
      ['De', 'de.png', 12],
      ['Des', 'des.png', 12],
      ['Du', 'du.png', 12],
      ['Et', 'et.png', 13],
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('invariable');
      switch ($row[2]) {
        case 10:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre A"));
          break;
        case 11:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre C"));
          break;
        case 12:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre D"));
          break;
        case 13:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre E"));
          break;
        default:
          break;
      }
      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      $manager->persist($pictogram);
    }
  }

  private function populatePictogramOthers(ObjectManager $manager)
  {
    $output = new ConsoleOutput();
    $data = [
      ['Eux', 'eux.png', 1, 'troisieme', 'pluriel', 'masculin'],
      ['Moi', 'moi.png', 1, 'premier', 'singulier', null],

      ['Ces', 'ces.png', 11, 'troisieme', 'pluriel', null],
      ['Cet', 'cet.png', 11, 'troisieme', 'singulier', 'masculin'],
      ['Cette', 'cette.png', 11, 'troisieme', 'singulier', 'feminin'],
      ['Ce', 'ce.png', 11, 'troisieme', 'singulier', 'masculin'],

      ['Leur', 'leur.png', 14, null, 'singulier', null],
      ['Leurs', 'leurs.png', 14, null, 'pluriel', null],
      ['La', 'la.png', 14, 'troisieme', 'singulier', 'feminin'],
      ['Le', 'le.png', 14, 'troisieme', 'singulier', 'masculin'],
      ['Les', 'les.png', 14, 'troisieme', 'pluriel', null],

      ['Mon', 'mon.png', 15, 'premier', 'singulier', 'masculin'],
      ['Ma', 'ma.png', 15, 'premier', 'singulier', 'feminin'],
      ['Mes', 'mes.png', 15, 'premier', 'pluriel', null],
      ['Mien', 'mien.png', 15, 'premier', 'singulier', 'masculin'],
      ['Miens', 'miens.png', 15, 'premier', 'pluriel', 'masculin'],
      ['Mienne', 'mienne.png', 15, 'premier', 'singulier', 'feminin'],
      ['Miennes', 'miennes.png', 15, 'premier', 'pluriel', 'feminin'],

      ['Son', 'son.png', 17, 'troisieme', 'singulier', 'masculin'],
      ['Sa', 'sa.png', 17, 'troisieme', 'singulier', 'feminin'],
      ['Ses', 'ses.png', 17, 'troisieme', 'pluriel', null],
      ['Sien', 'sien.png', 17, 'troisieme', 'singulier', 'masculin'],
      ['Siens', 'siens.png', 17, 'troisieme', 'pluriel', 'masculin'],
      ['Sienne', 'sienne.png', 17, 'troisieme', 'singulier', 'feminin'],
      ['Siennes', 'siennes.png', 17, 'troisieme', 'pluriel', 'feminin'],

      ['Ton', 'ton.png', 18, 'deuxieme', 'singulier', 'masculin'],
      ['Ta', 'ta.png', 18, 'deuxieme', 'singulier', 'feminin'],
      ['Tes', 'tes.png', 18, 'deuxieme', 'pluriel', null],
      ['Tien', 'tien.png', 18, 'deuxieme', 'singulier', 'masculin'],
      ['Tiens', 'tiens.png', 18, 'deuxieme', 'pluriel', 'masculin'],
      ['Tienne', 'tienne.png', 18, 'deuxieme', 'singulier', 'feminin'],
      ['Tiennes', 'tiennes.png', 18, 'deuxieme', 'pluriel', 'feminin'],

      ['Une', 'une.png', 19, null, 'singulier', 'feminin'],
      ['Un', 'un1.png', 19, null, 'singulier', 'masculin'],

      ['Notre', 'notre.png', 16, 'premier', 'singulier', null],
      ['Nos', 'nos.png', 16, 'premier', 'pluriel', null],      
      ['Votre', 'votre.png', 20, 'deuxieme', 'singulier', null],
      ['Vos', 'vos.png', 20, 'deuxieme', 'pluriel', null],
    ];
    foreach ($data as $row) {
      $pictogram = new Pictogram();
      $pictogram->setTitle($row[0]);
      $pictogram->setFilename($row[1]);
      $pictogram->setType('pronom_ou_determinant');

      $pictogram->setUpdatedAt(new DateTimeImmutable());
      $pictogram->setCreatedAt(new DateTimeImmutable());

      switch ($row[2]) {
        case 1:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 11:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre C"));
          break;
        case 14:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre L"));
          break;
        case 15:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre M"));
          break;
        case 16:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre N"));
          break;
        case 17:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre S"));
          break;
        case 18:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre T"));
          break;
        case 19:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre U"));
          break;
        case 20:
          $pictogram->setCategory($this->cRepo->findOneByTitle("Lettre V"));
          break;
        default:
          break;
      }

      $manager->persist($pictogram);
    }
  }
  // end pictograms

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
      $question->setUpdatedAt(new DateTimeImmutable());
      $question->setCreatedAt(new DateTimeImmutable());
      switch ($row[0]) {
        case 1:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Chiffres"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 2:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Boissons"));
          $question->addCategory($this->cRepo->findOneByTitle("Fruits et légumes"));
          $question->addCategory($this->cRepo->findOneByTitle("Aliments"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 3:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Boissons"));
          $question->addCategory($this->cRepo->findOneByTitle("Fruits et légumes"));
          $question->addCategory($this->cRepo->findOneByTitle("Aliments"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 4:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Boissons"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 5:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Sports"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 6:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Animaux"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 7:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Couleurs"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 8:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Multimédia"));
          $question->addCategory($this->cRepo->findOneByTitle("Objets"));
          $question->addCategory($this->cRepo->findOneByTitle("Jouet"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 9:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 10:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Lieux"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 11:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Corps humain"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 12:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Comportements"));
          $question->addCategory($this->cRepo->findOneByTitle("Émotions"));
          $question->addCategory($this->cRepo->findOneByTitle("Adjectifs"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 13:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Comportements"));
          $question->addCategory($this->cRepo->findOneByTitle("Émotions"));
          $question->addCategory($this->cRepo->findOneByTitle("Adjectifs"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 14:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Comportements"));
          $question->addCategory($this->cRepo->findOneByTitle("Émotions"));
          $question->addCategory($this->cRepo->findOneByTitle("Adjectifs"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 15:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Couleurs"));
          $question->addCategory($this->cRepo->findOneByTitle("Corps humain"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 16:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Adjectifs"));
          $question->addCategory($this->cRepo->findOneByTitle("Météo"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 17:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Vêtements"));
          $question->addCategory($this->cRepo->findOneByTitle("Adjectifs"));
          $question->addCategory($this->cRepo->findOneByTitle("Météo"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 18:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Corps humain"));
          $question->addCategory($this->cRepo->findOneByTitle("Chiffres"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 19:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Corps humain"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 20:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Corps humain"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 21:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Personnes"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 22:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Personnes"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 23:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Fruits et légumes"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 24:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Personnes"));
          $question->addCategory($this->cRepo->findOneByTitle("Lieux"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 25:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Couleurs"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 26:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Lieux"));
          $question->addCategory($this->cRepo->findOneByTitle("Sécurité Routière"));
          $question->addCategory($this->cRepo->findOneByTitle("Transports"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 27:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Transports"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 28:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Couverts"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 29:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Journee"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        case 30:
          $question->addCategory($this->cRepo->findOneByTitle("Petits mots"));
          $question->addCategory($this->cRepo->findOneByTitle("Heures"));
          $question->addCategory($this->cRepo->findOneByTitle("Actions"));
          $question->addCategory($this->cRepo->findOneByTitle("Sujets"));
          break;
        default:
          break;
      }
      $manager->persist($question);
    }
  }

  private function populatePatient(ObjectManager $manager)
  {
    $data = [
      ['Cyril', 'Acacio', '1985-12-20', 'Bac +2', 'm'],
      ['Simba', 'Rudrauf', '2018-02-01', 'Test', 'm'],
      ['Ziggy', 'V', '1999-06-01', 'On ne sait pas', 'f'],
      ['Patient désactivé numéro 15', 'Patient désactivé numéro 15', '7119-08-29', 'a', 'f'],
      ['John', 'Doe', '2010-10-20', 'Scolarisé dans une centre spécialisé', 'm'],
      ['Patient désactivé numéro 17', 'Patient désactivé numéro 17', '2007-02-04', 'Scolarisé dans un centre spécialisé', 'f'],
      ['Tristan', 'Rudrauf', '1994-10-15', 'Test', 'm'],
      ['Patient désactivé numéro 20', 'Patient désactivé numéro 20', '1994-10-15', 'Test', 'm'],
      ['Patient désactivé numéro 21', 'Patient désactivé numéro 21', '2021-07-14', 'Test', 'f'],
      ['sa', 'sa', '2022-04-16', 'sa', 'm'],
      ['Emilie', 'Ekon', '2005-02-03', 'lycee', 'f']
    ];
    $slugger = new AsciiSlugger();
    foreach ($data as $row) {
      $patient = new Patient();
      $patient->setFirstName($row[0]);
      $patient->setLastName($row[1]);
      $birthDate = $this->formatDateTimeImmutableByString($row[2]);
      $patient->setBirthDate($birthDate);
      $patient->setGrade($row[3]);
      $patient->setSex($row[4]);
      /** @var User $therapist */
      $therapist = $this->uRepo->findOneByEmail('rudrauf.tristan@orange.fr');
      $patient->setTherapist($therapist);
      $patient->setIsActive(true);
      $patient->setUpdatedAt(new DateTimeImmutable());
      $patient->setCreatedAt(new DateTimeImmutable());
      $code = $therapist->getFirstName()[0] . $therapist->getLastName()[0] . '-' . $row[0][0] . $row[1][0] . '-' . $birthDate->format('Ymd');
      $code = $slugger->slug($code);
      $patient->setCode($code);
      

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
          $note->setTherapist($this->uRepo->findOneByEmail("m.benkherrat@ecam-epmi.com"));
          break;
        case 18:
          $note->setTherapist($this->uRepo->findOneByEmail("palvac@gmail.com"));
          break;
        case 21:
          $note->setTherapist($this->uRepo->findOneByEmail("rudrauf.tristan@orange.fr"));
          break;
        case 24:
          $note->setTherapist($this->uRepo->findOneByEmail("bleuechabani@gmail.com"));
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
      $note->setEstimation('progress');
      $note->setUpdatedAt(new DateTimeImmutable());
      $note->setCreatedAt(new DateTimeImmutable());

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
      $phrase = new Phrase();

      $phrase->setUpdatedAt(new DateTimeImmutable());
      $phrase->setCreatedAt(new DateTimeImmutable());

      if ($row[0] != null) {
        $phrase->setText($row[0]);
      } else {
        $phrase->setText('lorem ipsum');
      }

      if ($row[1] != null) {
        $audioPhrase = new AudioPhrase();
        $audioPhrase->setAudioName($row[1]);
        $audioPhrase->setScore(5);
        $audioPhrase->setUpdatedAt(new DateTimeImmutable());
        $audioPhrase->setCreatedAt(new DateTimeImmutable());

        $manager->persist($audioPhrase);

        $phrase->addAudioPhrase($audioPhrase);
      }


      /* ********** Setting patients ************ */
      switch ($row[3]) {
        case 1:
          $phrase->setPatient($this->patRepo->findOneByName("Cyril", "Acacio"));
          break;
        case 2:
          $phrase->setPatient($this->patRepo->findOneByName("Simba", "Rudrauf"));
          break;
        case 14:
          $phrase->setPatient($this->patRepo->findOneByName('Ziggy', 'V'));
          break;
        case 15:
          $phrase->setPatient($this->patRepo->findOneByName('John', 'Doe'));
          break;
        case 16:
          $phrase->setPatient($this->patRepo->findOneByName('Tristan', 'Rudrauf'));
          break;
        case 17:
          $phrase->setPatient($this->patRepo->findOneByName('Emilie', 'Ekon'));
          break;
        case 19:
          $phrase->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 15', 'Patient désactivé numéro 15'));
          break;
        case 20:
          $phrase->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 17', 'Patient désactivé numéro 17'));
          break;
        case 21:
          $phrase->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 20', 'Patient désactivé numéro 20'));
          break;
        case 22:
          $phrase->setPatient($this->patRepo->findOneByName('Patient désactivé numéro 21', 'Patient désactivé numéro 21'));
          break;
        case 23:
          $phrase->setPatient($this->patRepo->findOneByName('sa', 'sa'));
          break;
        default:
          break;
      }

      $manager->persist($phrase);
    }
  }
}
