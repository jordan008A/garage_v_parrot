<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    #[Route('/services', name: 'services.index', methods: ['GET'])]
    public function index(ServicesRepository $servicesRepository): Response
    {
        // Afficher la liste des services
        return $this->render('pages/services/index.html.twig', [
            'services' => $servicesRepository->findAll(),
        ]);
    }
}
