<?php

namespace App\Controller\Therapist;

use App\Entity\Note;
use App\Entity\Patient;
use App\Entity\User;
use App\Form\NoteFormType;
use App\Form\PasswordFormType;
use App\Form\PatientFormType;
use App\Repository\NoteRepository;
use App\Repository\PatientRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/therapist/patients')]
class PatientController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepo,
        private NoteRepository $noteRepo,
        private PatientRepository $patRepo,
    ) {
    }

    #[Route('/', name: "therapist_patients_get_all")]
    public function getAllPatients(Request $request): Response
    {
        $filter = $request->query->getString('filter', 'all');
        $value = $request->query->getString('value', '');
        $sortBy = $request->query->getString('sortBy', 'id');
        $sortDir = $request->query->getString('sortDir', 'ASC');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $step = 5;
        /** @var User $user */
        $user = $this->getUser();

        /** @var ArrayCollection $patients */
        $patients = $this->patRepo->findByTherapistWithPaginator($user->getId(), $limit, $page, $sortBy, $sortDir);
        $count = $patients->count() != 0 ? $patients->count() : 1;
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
            'sortDir' => $sortDir,
            'filter' => $filter,
            'value' => $value
        ]);
    }

    #[Route('/create', name: "therapist_patients_create_one")]
    public function createOnePatient(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute('therapist_index');
        }

        $patient = new Patient();
        $form = $this->createForm(PatientFormType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $lastName = $form->get('lastName')->getData();
            $patient->setGrade($form->get('grade')->getData());
            $birthDate = DateTimeImmutable::createFromMutable($form->get('birthDate')->getData());
            $sex = $form->get('sex')->getData();
            $patient->setFirstName($firstName);
            $patient->setLastName($lastName);
            $patient->setBirthDate($birthDate);
            $patient->setSex($sex);
            $patient->setIsActive(true);
            $patient->setCreatedAt(new DateTimeImmutable());
            $patient->setUpdatedAt(new DateTimeImmutable());
            $patient->setTherapist($user);
            $code = substr($user->getFirstName(), 0, 2) . substr($user->getLastName(), 0, 2) . '-' . substr($firstName, 0, 2) . substr($lastName, 0, 2) . '-' . uniqid();
            $code = strtolower($slugger->slug($code));
            $patient->setCode($code);

            $note = new Note();
            $note->setEstimation('initial');
            $noteComment = $form->get('noteComment')->getData();
            if ($noteComment == NULL || $noteComment == '') {
                $noteComment = 'Initialisation du dossier de ' . $firstName . ' ' . $lastName;
            }
            $note->setComment($noteComment);
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
    public function getPatientByCode($code): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);

        $notes = $patient->getNotes();

        return $this->render('therapist/index.html.twig', [
            'code' => $code,
            'patient' => $patient,
            'notes' => $notes
        ]);
    }

    #[Route('/{code}/session/create', name: "therapist_patients_create_session")]
    public function createPatientSessionByCode($code, Session $session): Response
    {
        if ($session->get('patient')) {
            // dd($session->get('patient'));
            $session->remove('patient');
            // dd($session->get('patient'));
        }
        /** @var User $user */
        $user = $this->getUser();

        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);
        if (!$patient->isIsActive()) {
            $this->addFlash('danger', 'Patient est inactif, des sessions sont indisponible');
            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code,
            ]);
        }
        $session->set('patient', $patient);
        return $this->redirectToRoute('app_therapist_session_index', []);
    }

    #[Route('/{code}/update', name: "therapist_patients_update_one")]
    public function updatePatientByCode($code, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);

        if (!$patient->isIsActive()) {
            $this->addFlash('danger', 'Dossier ' . $code . ' est inactif! Il est interdit changer les données du patient!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        }

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
            $patient->setUpdatedAt(new DateTimeImmutable());
            $code = substr($user->getFirstName(), 0, 2) . substr($user->getLastName(), 0, 2) . '-' . substr($firstName, 0, 2) . substr($lastName, 0, 2) . '-' . $birthDate->format('Ymd');
            $code = strtolower($slugger->slug($code));
            $patient->setCode($code);

            $entityManager->persist($patient);
            $entityManager->flush();

            $this->addFlash('success', 'Les données du patient sont mises à jour.');

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
            'code' => $code,
            'patient' => $patient
        ]);
    }

    #[Route('/{code}/deactivate', name: "therapist_patients_deactivate_one")]
    public function desactivatePatientByCode($code, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);

        if (!$patient->isIsActive()) {
            $this->addFlash('danger', 'Dossier ' . $code . ' est déjà inactif!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        }

        $form = $this->createForm(PasswordFormType::class);
        $form->handleRequest($request);

        // creating new error if written institution code doesnt match with the code of the chosen institution 
        if ($form->isSubmitted() && !$userPasswordHasher->isPasswordValid($user, $form->get('password')->getData())) {
            $form->addError(new FormError('Mot de passe est incorrect!'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setIsActive(false);
            $patient->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($patient);
            $entityManager->flush();

            $this->addFlash('warning', 'Dossier ' . $code . ' dèsactivé!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        } else if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Mot de passe est incorrect!');
        }

        return $this->render('therapist/index.html.twig', [
            'code' => $code,
            'passwordForm' => $form,
        ]);
    }

    #[Route('/{code}/note/create', name: "therapist_patients_note_create")]
    public function createNoteByPatient($code, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);

        if (!$patient->isIsActive()) {
            $this->addFlash('danger', 'Dossier ' . $code . ' est inactif!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        }

        $note = new Note();

        $form = $this->createForm(NoteFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setEstimation($form->get('estimation')->getData());
            $note->setComment($form->get('comment')->getData());

            $note->setCreatedAt(new DateTimeImmutable());
            $note->setUpdatedAt(new DateTimeImmutable());

            $note->setTherapist($user);
            $note->setPatient($patient);

            $entityManager->persist($note);
            $entityManager->flush();

            $this->addFlash('sucess', 'Nouvelle note du dossier' . $code . ' est créé!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        } else if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Somùething went wrong');
        }

        return $this->render('therapist/index.html.twig', [
            'code' => $code,
            'noteForm' => $form,

        ]);
    }

    #[Route('/{code}/note/{noteId}', name: "therapist_patients_note_get_one")]
    public function getNoteByPatient($code, $noteId, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Patient $patient */
        $patient = $this->patRepo->findOneByCode($code);

        if (!$patient->isIsActive()) {
            $this->addFlash('danger', 'Dossier ' . $code . ' est inactif!');

            return $this->redirectToRoute('therapist_patients_get_one', [
                'code' => $code
            ]);
        }

        $note = $this->noteRepo->findOneById($noteId);


        return $this->render('therapist/index.html.twig', [
            'code' => $code,
            'noteId' => $noteId,
            'note' => $note

        ]);
    }
}
