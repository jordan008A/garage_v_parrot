<?php

namespace App\Controller;

use App\Service\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
  private FooterService $footerService;

  /**
   * Constructor for MainController
   *
   * @param FooterService $footerService
   */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }

  /**
   * Display the home page with footer data.
   *
   * @return Response
   */
  public function index(): Response
  {
    $footerData = $this->footerService->getFooterData();

    return $this->render('index.html.twig', [
      'footerData' => $footerData,
    ]);
  }
}
