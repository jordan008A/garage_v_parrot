<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OccasionsController extends AbstractController
{
    #[Route('/occasions', name: 'occasions.index', methods: ['GET'] )]
    public function index(): Response
    {
        return $this->render('pages/occasions/details.html.twig', [
            'controller_name' => 'OccasionsController',
        ]);
    }
}
