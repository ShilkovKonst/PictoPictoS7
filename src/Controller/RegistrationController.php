<?php

namespace App\Controller;

use App\Entity\Therapist;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\InstitutionRepository;
use App\Security\EmailVerifier;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private InstitutionRepository $iRepo,
        private LoggerInterface $logger,
    ) {
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() != null) {
            return $this->redirectToRoute('therapist_index');
        }
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // creating new error if written institution code doesnt match with the code of the chosen institution 
        if ($form->isSubmitted() && $form->get('codeInstitution')->getData() != $form->get('institution')->getData()->getCode()) {
            $form->get('codeInstitution')->addError(new FormError('Le champ du code de l\'Institut doit correspondre au code de l\'Institut choisi'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setJob($form->get('job')->getData());
            $user->setInstitution($this->iRepo->findOneByCode($form->get('codeInstitution')->getData()));

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $user->setIsActive(true);
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('konst.shilkov@gmail.com', 'PictoPicto'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            $this->addFlash('warning', 'Un email avec les instructions de confirmation a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception.');
            
            return $security->login($user, 'form_login', 'main');
        } else if ($form->isSubmitted() && !$form->isValid()) { // if something went wrong - generate and send to front all the errors to show to the user
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            $this->addFlash('danger', implode('<br>', $errorMessages));
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('danger', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse email a été vérifiée.');

        return $this->redirectToRoute('therapist_index');
    }
    
    #[Route('/verify/email/resend', name: 'app_verify_email_resend')]
    public function resendVerifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        /** @var User $user */
        $user=$this->getUser();
        if (!$user) {
            $this->addFlash('danger', "Vous devez être connecté pour accéder à cette page!");
            return $this->redirectToRoute('app_login');
        }        
        if ($user->isVerified()) {
            $this->addFlash('warning', "Votre compte est déjà activé.");
            return $this->redirectToRoute('therapist_index');
        }

        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('konst.shilkov@gmail.com', 'PictoPicto'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
        $this->addFlash('warning', 'Un email avec les instructions de confirmation a été envoyé à votre adresse email. Veuillez vérifier votre boîte de réception.');

        return $this->redirectToRoute('therapist_index');
    }
}
