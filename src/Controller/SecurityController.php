<?php

namespace App\Controller;

use App\Service\FooterService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

  private FooterService $footerService;

  /**
   * Constructor for SecurityController
   *
   * @param FooterService $footerService
   */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }
  
  /**
   * Display the login page and handle authentication errors.
   *
   * @param AuthenticationUtils $authenticationUtils
   * @return Response
   */
  #[Route('/login', name: 'app_login')]
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    $footerData = $this->footerService->getFooterData();
    $error = $authenticationUtils->getLastAuthenticationError();

    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('pages/security/login.html.twig', [
      'last_username' => $lastUsername, 
      'error' => $error,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Logout action (no specific functionality here).
   */
  #[Route('/logout', name: 'app_logout')]
  public function logout()
  {
    // No specific functionality here, handled by Symfony's security system.
  }
}
