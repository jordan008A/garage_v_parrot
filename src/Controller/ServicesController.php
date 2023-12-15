<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'services.index', methods: ['GET'] )]
    public function index(): Response
    {
        return $this->render('pages/services/index.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }
}
