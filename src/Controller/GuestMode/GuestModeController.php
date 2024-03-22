<?php

namespace App\Controller\GuestMode;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/guest')]
class GuestModeController extends AbstractController
{
    #[Route('/', name: 'guest_mode_index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'GuestModeController',
        ]);
    }
}
