<?php

namespace App\Controller\Therapist;

use App\Form\RegistrationFormType;
use App\Form\TherapistUpdateFormType;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/therapist')]
class MainController extends AbstractController
{
    public function __construct(
        private UserRepository $uRepo,
        private InstitutionRepository $iRepo,
        private PatientRepository $patRepo,
        private CategoryRepository $catRepo,
        private PictogramRepository $pictRepo
    ) {
    }

    #[Route('/', name: "therapist_index")]
    public function index(): Response
    {
        return $this->redirectToRoute("therapist_profile");
    }

    #[Route('/profile', name: "therapist_profile")]
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

            return $this->redirectToRoute("therapist_profile");
        } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        // TODO: all functionality
        return $this->render('therapist/index.html.twig', [
            'userForm' => $form
        ]);
    }

    #[Route('/profile/desactivate', name: "therapist_profile_desactivate")]
    public function deleteProfile(): Response
    {
        // TODO: all functionality
        return $this->render('therapist/index.html.twig', []);
    }






    #[Route('/therapists', name: "therapist_therapists")]
    public function getAllTherapists(Request $request): Response
    {
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
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/categories', name: "therapist_categories")]
    public function getAllCategories(Request $request): Response
    {
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
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/pictograms', name: "therapist_pictograms")]
    public function getAllPictograms(Request $request): Response
    {
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;  
        /** @var ArrayCollection $pictograms */
        $pictograms = $this->pictRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);   
        $count = $pictograms->count();
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;   
        if ($page > $maxPages) $page = $maxPages; 

        return $this->render('therapist/index.html.twig', [
            'pictograms' => $pictograms,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/institutions', name: "therapist_institutions")]
    public function getAllInstitutions(Request $request): Response
    {
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
            'sortDir' => $sortDir
        ]);
    }
}
