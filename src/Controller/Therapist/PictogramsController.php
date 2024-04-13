<?php

namespace App\Controller\Therapist;

use App\Entity\Pictogram;
use App\Form\PictogramFormType;
use App\Repository\PictogramRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/therapist/pictograms')]
class PictogramsController extends AbstractController
{
    public function __construct(
        private UserRepository $uRepo,
        private PictogramRepository $pictRepo
    ) {
    }
    
    #[Route('/', name: "therapist_pictograms_get_all")]
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
            'sortBy' => $sortBy,
            'sortDir' => $sortDir
        ]);
    }

    #[Route('/create', name: "therapist_pictograms_create_one")]
    public function createOnePictogram(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute('therapist_index');
        }

        $pictogram = new Pictogram();
        $form = $this->createForm(PictogramFormType::class, $pictogram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictogram->setTitle($form->get('title')->getData());
            $pictogram->setCategory($form->get('category')->getData());
            foreach ($form->get('tags')->getData() as $tag) {
                $pictogram->addTag($tag);
            }
            $imageFile = $form->get('illustration')->getData();
            /** @var UploadedFile $imageFile */
            $imageFile->getClientOriginalName();

            if ($imageFile) {
                $originalFileName = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFileName);
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('pictograms_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                }
                $pictogram->setIllustration($form->get('illustration')->getData());
                $pictogram->setFilename($newFileName);
            }
            $pictogram->setCreatedAt(new DateTimeImmutable());
            $pictogram->setUpdatedAt(new DateTimeImmutable());

            dd($pictogram);
            // $entityManager->persist($pictogram);
            // $entityManager->flush();

            // $id = $this->pictRepo->findOneByFilename($form->get(''));

            // return $this->redirectToRoute("therapist_pictograms_get_one", [
            //     'code' => $id
            // ]);
        } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        return $this->render('therapist/index.html.twig', [
            'pictogramForm' => $form,
        ]);
    }

    #[Route('/{code}', name: "therapist_pictograms_get_one")]
    public function getPictogramByCode($code): Response
    {
        // /** @var User $user */
        // $user = $this->getUser();

        // /** @var pictogram $pictogram */        
        // $pictogram = $this->patRepo->findOneByCode($code);

        // $notes = $pictogram->getNotes();

        return $this->render('therapist/index.html.twig', [
            // 'code' => $code,
            // 'pictogram' => $pictogram,
            // 'notes' => $notes
        ]);
    }

    #[Route('/{code}/update', name: "therapist_pictograms_update_one")]
    public function updatePictogramByCode($code, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // /** @var User $user */
        // $user = $this->getUser();
        // /** @var pictogram $pictogram */
        // $pictogram = $this->patRepo->findOneByCode($code);

        // if (!$pictogram->isIsActive()) {  
        //     $this->addFlash('danger', 'Dossier ' . $code . ' est inactif! Il est interdit changer les données du pictogram!');

        //     return $this->redirectToRoute('therapist_pictograms_get_one', [
        //         'code' => $code
        //     ]);
        // }

        // $form = $this->createForm(pictogramFormType::class, $pictogram);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $firstName = $form->get('firstName')->getData();
        //     $pictogram->setFirstName($firstName);
        //     $lastName = $form->get('lastName')->getData();
        //     $pictogram->setLastName($lastName);
        //     $pictogram->setGrade($form->get('grade')->getData());
        //     $birthDate = DateTimeImmutable::createFromMutable($form->get('birthDate')->getData());
        //     $pictogram->setBirthDate($birthDate);
        //     $pictogram->setSex($form->get('sex')->getData());
        //     $pictogram->setIsActive(true);
        //     $pictogram->setUpdatedAt(new DateTimeImmutable());
        //     $code = substr($user->getFirstName(), 0, 2) . substr($user->getLastName(), 0, 2) . '-' . substr($firstName, 0, 2) . substr($lastName, 0, 2) . '-' . $birthDate->format('Ymd');
        //     $code = strtolower($slugger->slug($code));
        //     $pictogram->setCode($code);

        //     $entityManager->persist($pictogram);
        //     $entityManager->flush();

        //     $this->addFlash('success', 'Les données du pictogram sont mises à jour.');

        //     return $this->redirectToRoute("therapist_pictograms_get_one", [
        //         'code' => $code
        //     ]);
        // } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
        //     $errors = $form->getErrors(true);
        //     foreach ($errors as $error) {
        //         $errorMessages[] = $error->getMessage();
        //     }
        //     $this->addFlash('danger', implode('<br>', $errorMessages));
        // }

        return $this->render('therapist/index.html.twig', [
            // 'pictogramForm' => $form,
            // 'code' => $code,
            // 'pictogram' => $pictogram
        ]);
    }

    #[Route('/{code}/deactivate', name: "therapist_pictograms_deactivate_one")]
    public function desactivatePictogramByCode($code, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // /** @var User $user */
        // $user = $this->getUser();
        // /** @var pictogram $pictogram */
        // $pictogram = $this->patRepo->findOneByCode($code);

        // if (!$pictogram->isIsActive()) {  
        //     $this->addFlash('danger', 'Dossier ' . $code . ' est déjà inactif!');

        //     return $this->redirectToRoute('therapist_pictograms_get_one', [
        //         'code' => $code
        //     ]);
        // }

        // $form = $this->createForm(PasswordFormType::class);
        // $form->handleRequest($request);

        // // creating new error if written institution code doesnt match with the code of the chosen institution 
        // if ($form->isSubmitted() && !$userPasswordHasher->isPasswordValid($user, $form->get('password')->getData())) {
        //     $form->addError(new FormError('Mot de passe est incorrect!'));
        // }

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $pictogram->setIsActive(false);
        //     $pictogram->setUpdatedAt(new DateTimeImmutable());

        //     $entityManager->persist($pictogram);
        //     $entityManager->flush();

        //     $this->addFlash('warning', 'Dossier ' . $code . ' dèsactivé!');

        //     return $this->redirectToRoute('therapist_pictograms_get_one', [
        //         'code' => $code
        //     ]);

        // } else if ($form->isSubmitted() && !$form->isValid()) {
        //     $this->addFlash('danger', 'Mot de passe est incorrect!');
        // }

        return $this->render('therapist/index.html.twig', [
            // 'code' => $code,
            // 'passwordForm' => $form,
        ]);
    }
}
