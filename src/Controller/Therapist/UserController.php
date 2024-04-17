<?php

namespace App\Controller\Therapist;

use App\Entity\User;
use App\Form\PasswordFormType;
use App\Form\TherapistUpdateFormType;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/therapist')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $uRepo,
        private InstitutionRepository $iRepo,
        private CategoryRepository $catRepo,
    ) {
    }

    #[Route('/', name: "therapist_index")]
    public function index(): Response
    {
        return $this->redirectToRoute("therapist_profile_show");
    }

    #[Route('/profile', name: "therapist_profile_show")]
    public function profile(): Response
    {
        return $this->render('therapist/index.html.twig');
    }

    #[Route('/profile/update', name: "therapist_profile_update")]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(TherapistUpdateFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $user->setFirstName($firstName);
            $lastName = $form->get('lastName')->getData();
            $user->setLastName($lastName);
            $phoneNumber = $form->get('phoneNumber')->getData();
            $user->setPhoneNumber($phoneNumber);
            $job = $form->get('job')->getData();
            $user->setJob($job);
            $user->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vos données sont mises à jour.');

            return $this->redirectToRoute("therapist_profile_show");
        } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        // TODO: password change fonctionality
        return $this->render('therapist/index.html.twig', [
            'userForm' => $form
        ]);
    }

    #[Route('/profile/desactivate', name: "therapist_profile_desactivate")]
    public function desactivateProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user->isIsActive()) {
            $this->addFlash('danger', 'Le profil ' . $user->getEmail() . ' est déjà inactif!');
            return $this->redirectToRoute('therapist_profile_show');
        }

        $form = $this->createForm(PasswordFormType::class);
        $form->handleRequest($request);

        // creating new error if written institution code doesnt match with the code of the chosen institution 
        if ($form->isSubmitted() && !$userPasswordHasher->isPasswordValid($user, $form->get('password')->getData())) {
            $form->addError(new FormError('Mot de passe est incorrect!'));
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsActive(false);
            $user->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('warning', 'Le profil ' . $user->getEmail() . ' dèsactivé!');

            return $this->redirectToRoute('therapist_profile_show');
        } else if ($form->isSubmitted() && !$form->isValid()) {$errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        return $this->render('therapist/index.html.twig', [
            'passwordForm' => $form,
            'user' => $user
        ]);
    }






    #[Route('/therapists', name: "therapist_therapists")]
    public function getAllTherapists(Request $request): Response
    {
        $criteria = $request->query->getString('filter', 'all');
        $value = $request->query->getString('value', '');
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;

        /** @var ArrayCollection $therapists */
        $therapists = $this->uRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
        $count = $therapists->count();
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('therapist/index.html.twig', [
            'therapists' => $therapists,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
            'filter' => $criteria, 
            'value' => $value
        ]);
    }

    #[Route('/categories', name: "therapist_categories")]
    public function getAllCategories(Request $request): Response
    {
        $criteria = $request->query->getString('filter', 'all');
        $value = $request->query->getString('value', '');
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;
        /** @var ArrayCollection $categories */
        $categories = $this->catRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
        $count = $categories->count();
        $maxPages = floor($count / $limit) + 1;
        if ($page < 1) $page = 1;
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('therapist/index.html.twig', [
            'categories' => $categories,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
            'filter' => $criteria, 
            'value' => $value
        ]);
    }

    #[Route('/institutions', name: "therapist_institutions")]
    public function getAllInstitutions(Request $request): Response
    {
        $criteria = $request->query->getString('filter', 'all');
        $value = $request->query->getString('value', '');
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;
        /** @var ArrayCollection $institutions */
        $institutions = $this->iRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
        $count = $institutions->count();
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('therapist/index.html.twig', [
            'institutions' => $institutions,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
            'filter' => $criteria, 
            'value' => $value
        ]);
    }
}
