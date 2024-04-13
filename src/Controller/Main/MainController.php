<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/index.html.twig');
        } 
        if ($this->getUser() && in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles())) {
            return $this->redirectToRoute('guest_mode_index');
        }
        if ($this->getUser() && in_array("ROLE_USER", $this->getUser()->getRoles())) {
            return $this->redirectToRoute('therapist_index');
        }
        return $this->redirectToRoute('app_login');
        // return $this->render('main/index.html.twig', [
        //     'controller_name' => 'MainController',
        // ]);
    }
}