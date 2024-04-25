<?php

namespace App\Controller\Therapist;

use App\Repository\CategoryRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/therapist/session')]
class SessionController extends AbstractController
{
    public function __construct(
        private PatientRepository $patientRepo,
        private CategoryRepository $categoryRepo,
        private PictogramRepository $pictogramRepo,
    ) {
    }

    #[Route('/', name: 'app_therapist_session_index')]
    public function index(Request $request, Session $session): Response
    {
        if (!$session->get('patient')) {
            $this->addFlash('danger', 'Something went wrong');

            return $this->redirectToRoute('therapist_patients_get_all');
        }

        return $this->render('session/index.html.twig', []);
    }

    #[Route('/exchange', name: 'app_therapist_session_exchange')]
    public function openExchange(Request $request, Session $session): Response
    {
        if (!$session->get('patient')) {
            $this->addFlash('danger', 'Something went wrong');

            return $this->redirectToRoute('therapist_patients_get_all');
        }

        $catFilter = $request->query->getString('category', 'all');

        $subcatFilter = $request->query->getString('subcategory', 'none');
        $superCategories = $this->categoryRepo->findAllSuperCategories();
        $subCategories = $catFilter == 'all' ? [] : $this->categoryRepo->findBySuperCategory($catFilter);
        $pictograms = (($subcatFilter == 'none' || $catFilter == 'all') ? [] : $subcatFilter != 'none') ? $this->pictogramRepo->findByCategory($subcatFilter) : $this->pictogramRepo->findByCategory($catFilter);

        return $this->render('session/index.html.twig', [
            'catFilter' => $catFilter,
            'subcatFilter' => $subcatFilter,
            'superCats' => $superCategories,
            'subCats' => $subCategories,
            'pictograms' => $pictograms
        ]);
    }

    #[Route('/dialogue', name: 'app_therapist_session_dialogue')]
    public function openDialogue(Request $request, Session $session): Response
    {
        if (!$session->get('patient')) {
            $this->addFlash('danger', 'Something went wrong');

            return $this->redirectToRoute('therapist_patients_get_all');
        }

        return $this->render('session/index.html.twig', []);
    }

    #[Route('/game', name: 'app_therapist_session_game')]
    public function openGame(Request $request, Session $session): Response
    {
        if (!$session->get('patient')) {
            $this->addFlash('danger', 'Something went wrong');

            return $this->redirectToRoute('therapist_patients_get_all');
        }

        return $this->render('session/index.html.twig', []);
    }

    #[Route('/exit', name: 'app_therapist_session_exit')]
    public function exitAndDestroySession(Request $request, Session $session): Response
    {
        $user = $this->getUser();

        $code = $session->get('patient')->getCode();
        // dd($code);
        $session->remove('patient');
        // $patient = $this->patientRepo->findOneByCode($patientCode);
        // $session->set('patient', $patient);

        return $this->redirectToRoute('therapist_patients_get_one', [
            'code' => $code,
        ]);
    }
}
