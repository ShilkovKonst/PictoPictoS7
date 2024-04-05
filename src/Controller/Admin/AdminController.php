<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TherapistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private TherapistRepository $thRepo,
        private InstitutionRepository $iRepo,
        private PatientRepository $patRepo,
        private PictogramRepository $pictRepo,
        private CategoryRepository $catRepo,
        private SubCategoryRepository $subCatRepo,

    ) {
    }

    #[Route('/', name: "admin_index")]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
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
    public function getAllTherapists(): Response
    {

        $therapists = $this->thRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'therapists' => $therapists,
        ]);
    }

    #[Route('/patients', name: "admin_patients")]
    public function getAllPatients(): Response
    {
        /** @var Therapist $user */
        $user = $this->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            $patients = $this->patRepo->findAll();
        } else {
            $patients = $this->patRepo->findById($user->getId());
        }
        // ask Moncef about link between patient and therapist, now there is no direct connexion between them

        return $this->render('admin/index.html.twig', [
            'patients' => $patients,
        ]);
    }

    #[Route('/categories', name: "admin_categories")]
    public function getAllCategories(): Response
    {
        $categories = $this->catRepo->findAll();
        $subCategories = $this->subCatRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }

    #[Route('/pictograms', name: "admin_pictograms")]
    public function getAllPictograms(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/institutions', name: "admin_institutions")]
    public function getAllInstitutions(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
