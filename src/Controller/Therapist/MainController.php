<?php

namespace App\Controller\Therapist;

use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\UserRepository;
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
        return $this->render('therapist/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/test', name: "therapist_test")]
    public function test(): Response
    {
        $this->addFlash('danger', "Test of danger flash");
        $this->addFlash('warning', "Test of warning flash");
        $this->addFlash('success', "Test of success flash");
        
        return $this->redirectToRoute("therapist_index");
    }

    #[Route('/profile/edit', name: "therapist_profile_edit")]
    public function profileEdit(): Response
    {
        // TODO: all functionnality
        return $this->render('therapist/index.html.twig', []);
    }

    #[Route('/profile/delete', name: "therapist_profile_delete")]
    public function profileDelete(): Response
    {
        // TODO: all functionnality
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

    // #[Route('/patients', name: "therapist_patients")]
    // public function getAllPatients(Request $request): Response
    // {
    //     $sortBy = $request->query->getString('sortBy', 'id');
    //     $sortDir = $request->query->getString('sortDir', 'ASC');
    //     $page = $request->query->getInt('page', 1);
    //     $limit = 5;
    //     $step = 5;     
    //     /** @var Therapist $user */
    //     $user = $this->getUser();
    //     if (in_array('ROLE_USER', $user->getRoles())) {
    //         /** @var ArrayCollection $patients */
    //         $patients = $this->patRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
    //         $count = $patients->count();
    //         $maxPages = ceil($count / $limit);
    //         if ($page < 1) $page = 1;   
    //         if ($page > $maxPages) $page = $maxPages;
    //     } else {
    //         /** @var ArrayCollection $patients */
    //         $patients = $this->patRepo->findByTherapistWithPaginator($user->getId(), $limit, $page, $sortBy, $sortDir);
    //         $count = $patients->count();
    //         $maxPages = ceil($count / $limit);
    //         if ($page < 1) $page = 1;   
    //         if ($page > $maxPages) $page = $maxPages;
    //     }

    //     return $this->render('therapist/index.html.twig', [
    //         'patients' => $patients,
    //         'page' => $page,
    //         'maxPages' => $maxPages,
    //         'step' => $step,
    //         'count' => $count,
    //         'sortBy' => $sortBy,
    //         'sortDir' => $sortDir
    //     ]);
    // }

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
