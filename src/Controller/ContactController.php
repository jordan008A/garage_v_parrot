<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
