<?php

namespace App\Controller\Therapist;

use App\Entity\Note;
use App\Entity\Patient;
use App\Entity\User;
use App\Form\PatientFormType;
use App\Repository\CategoryRepository;
use App\Repository\InstitutionRepository;
use App\Repository\NoteRepository;
use App\Repository\PatientRepository;
use App\Repository\PictogramRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/therapist/patients')]
class PatientController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepo,
        private NoteRepository $noteRepo,
        private InstitutionRepository $instRepo,
        private PatientRepository $patRepo,
        private CategoryRepository $catRepo,
        private PictogramRepository $pictRepo
    ) {
    }

    #[Route('/', name: "therapist_patients_get_all")]
    public function getAllPatients(Request $request): Response
    {
        // dd($request->getPathInfo());
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;
        /** @var User $user */
        $user = $this->getUser();

        /** @var ArrayCollection $patients */
        $patients = $this->patRepo->findByTherapistWithPaginator($user->getId(), $limit, $page, $sortBy, $sortDir);
        $count = $patients->count();
        $maxPages = ceil($count / $limit);
        if ($page < 1) $page = 1;
        if ($page > $maxPages) $page = $maxPages;

        return $this->render('therapist/index.html.twig', [
            'patients' => $patients,
            'page' => $page,
            'maxPages' => $maxPages,
            'step' => $step,
            'count' => $count,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/create', name: "therapist_patients_create_one")]
    public function createOnePatient(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('therapist_index');
        }

        /** @var User $user */
        $user = $this->getUser();
        
        $patient = new Patient();
        $form = $this->createForm(PatientFormType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $patient->setFirstName($firstName);
            $lastName = $form->get('lastName')->getData();
            $patient->setLastName($lastName);
            $patient->setGrade($form->get('grade')->getData());
            $birthDate = DateTimeImmutable::createFromMutable($form->get('birthDate')->getData());
            $patient->setBirthDate($birthDate);
            $patient->setSex($form->get('sex')->getData());            
            $patient->setIsActive(true);
            $patient->setCreatedAt(new DateTimeImmutable());
            $patient->setUpdatedAt(new DateTimeImmutable());
            $patient->setTherapist($user);
            $code = $user->getFirstName()[0] . $user->getLastName()[0] . '-' . $firstName[0] . $lastName[0] . '-' . $birthDate->format('Ymd');
            $code = $slugger->slug($code);
            $patient->setCode($code);

            $note = new Note();
            $note->setEstimation('initial');
            $note->setComment($form->get('noteComment')->getData());
            $note->setTherapist($user);
            $note->setCreatedAt(new DateTimeImmutable());
            $note->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($note);

            $patient->addNote($note);

            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute("therapist_patients_get_one", [
                'code' => $code
            ]);
        } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        return $this->render('therapist/index.html.twig', [
            'patientForm' => $form,
        ]);
    }

    #[Route('/{code}', name: "therapist_patients_get_one")]
    public function getPatientById($code, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        dd($request->getPathInfo());
        $patient = $this->patRepo->findOneByCode($code);
        // dd($patient);

        return $this->render('therapist/index.html.twig', [
            'patient' => $patient
        ]);
    }

    #[Route('/{code}/delete', name: "therapist_patients_desactivate_one")]
    public function deletePatientById($code): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $patient = $this->patRepo->findOneByCode($code);

        return $this->render('therapist/index.html.twig', [
            'patient' => $patient
        ]);
    }
}
