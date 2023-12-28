<?php

namespace App\Controller;

use App\Service\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function index()
    {
        $footerData = $this->footerService->getFooterData();

        return $this->render('index.html.twig', [
            'footerData' => $footerData,
        ]);
    }
}
