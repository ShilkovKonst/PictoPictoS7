<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramAdjectiveRepository;
use App\Repository\PictogramNounRepository;
use App\Repository\PictogramOthersRepository;
use App\Repository\PictogramPronounRepository;
use App\Repository\PictogramVerbRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private TherapistRepository $thRepo,
        private InstitutionRepository $iRepo,
        private PatientRepository $patRepo,
        private PictogramNounRepository $pictNounRepo,
        private PictogramPronounRepository $pictPnounRepo,
        private PictogramAdjectiveRepository $pictAdjRepo,
        private PictogramOthersRepository $pictOthRepo,
        private PictogramVerbRepository $pictRepo,
        private CategoryRepository $catRepo,

    ) {
    }

    #[Route('/', name: "admin_index")]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/test', name: "admin_test")]
    public function test(): Response
    {
        $this->addFlash('danger', "Test of danger flash");
        $this->addFlash('warning', "Test of warning flash");
        $this->addFlash('success', "Test of success flash");
        
        return $this->redirectToRoute("admin_index");
    }

    #[Route('/profile/edit', name: "admin_profile_edit")]
    public function profileEdit(): Response
    {
        // TODO: all functionnality
        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/profile/delete', name: "admin_profile_delete")]
    public function profileDelete(): Response
    {
        // TODO: all functionnality
        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/therapists', name: "admin_therapists")]
    public function getAllTherapists(Request $request): Response
    {
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;  
  
        /** @var ArrayCollection $therapists */
        $therapists = $this->thRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
        $count = $therapists->count();
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;   
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('admin/index.html.twig', [
            'therapists' => $therapists,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/patients', name: "admin_patients")]
    public function getAllPatients(Request $request): Response
    {
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;     
        /** @var Therapist $user */
        $user = $this->getUser();
        if (in_array('ROLE_USER', $user->getRoles())) {
            /** @var ArrayCollection $patients */
            $patients = $this->patRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);
            $count = $patients->count();
            $maxPages = ceil($count / $limit);
            if ($page < 1) $page = 1;   
            if ($page > $maxPages) $page = $maxPages;
        } else {
            /** @var ArrayCollection $patients */
            $patients = $this->patRepo->findByTherapistWithPaginator($user->getId(), $limit, $page, $sortBy, $sortDir);
            $count = $patients->count();
            $maxPages = ceil($count / $limit);
            if ($page < 1) $page = 1;   
            if ($page > $maxPages) $page = $maxPages;
        }
        // ask Moncef about link between patient and therapist, now there is no direct connexion between them

        return $this->render('admin/index.html.twig', [
            'patients' => $patients,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/categories', name: "admin_categories")]
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
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;   
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('admin/index.html.twig', [
            'categories' => $categories,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/pictograms', name: "admin_pictograms")]
    public function getAllPictograms(Request $request): Response
    {
        // $sortBy = $request->query->getString('sortBy', 'id');
        // $sortDir = $request->query->getString('sortDir', 'ASC');
        // $page = $request->query->getInt('page', 1);
        // $limit = 5;
        // $step = 5;  
        // /** @var ArrayCollection $categories */
        // $pictograms = $this->pictRepo->findAllWithPaginator($limit, $page, $sortBy, $sortDir);   
        // $count = $categories->count();
        // $maxPages = ceil($count / $limit);
        // if ($page < 1) $page = 1;   
        // if ($page > $maxPages) $page = $maxPages; 

        // return $this->render('admin/index.html.twig', [
        //     'pictograms' => $pictograms,
        //     'page' => $page,
        //     'maxPages' => $maxPages,
        //     'step' => $step,
        //     'count' => $count,
        //     'sortBy' => $sortBy,
        //     'sortDir' => $sortDir
        // ]);

        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/institutions', name: "admin_institutions")]
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

        return $this->render('admin/index.html.twig', [
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
