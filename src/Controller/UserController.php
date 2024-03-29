<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\FooterService;
use App\Service\MailerService;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
  private FooterService $footerService;

  /**
   * Constructor for UserController
   *
   * @param FooterService $footerService
   */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }

  /**
   * Display the index page for users.
   *
   * @return Response
   */  
  #[Route('/users', name: 'espace_pro.index', methods: ['GET'])]
  public function index(): Response
  {
    $footerData = $this->footerService->getFooterData();

    return $this->render('pages/admin/index.html.twig', [
      'footerData' => $footerData,
    ]);
  }
  
  /**
   * Display the management page for users in the admin panel.
   *
   * @return Response
   */
  #[Route('/admin/users', name: 'users.admin.manage', methods: ['GET', 'POST'])]
  public function manage(UsersRepository $usersRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    $users = $usersRepository->findAll();

    return $this->render('pages/admin/users.html.twig', [
      'users' => $users,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Create a new user.
   *
   * @return Response
   */
  #[Route('/admin/users/create', name: 'users.create', methods: ['GET', 'POST'])]
  public function create(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordEncoder, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    if ($request->isMethod('POST')) {
      $data = $request->request->all();

      if (isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('create-user-form', $data['_csrf_token']);
        if ($csrfTokenManager->isTokenValid($csrfToken)) {

        $user = new Users();
        $user->setLastname($data['lastname'])
          ->setFirstname($data['firstname'])
          ->setEmail($data['email'])
          ->setPlainPassword($data['password'])
          ->setIsAdmin(false);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'Utilisateur créé avec succès.');
        return $this->redirectToRoute('users.admin.manage');
        } else {
        $this->addFlash('error', 'Token CSRF invalide.');
        }
      } else {
        $this->addFlash('error', 'Une erreur est survenue.');
      }
    }

    return $this->redirectToRoute('users.admin.manage');
  }

  /**
   * Update an existing user.
   *
   * @return Response
   */
  #[Route('/admin/users/update/{id}', name: 'users.update', methods: ['GET', 'POST'])]
  public function update(string $id, Request $request, EntityManagerInterface $manager, CsrfTokenManagerInterface $csrfTokenManager, UsersRepository $usersrepository): Response
  {
    $footerData = $this->footerService->getFooterData();

    $user = $usersrepository->find($id);
    if (!$user) {
      throw $this->createNotFoundException('Utilisateur non trouvé.');
    }
      if ($request->isMethod('POST')) {
      $data = $request->request->all();

      if (isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('update-user-form', $data['_csrf_token']);
        if ($csrfTokenManager->isTokenValid($csrfToken)) {

        $user->setLastname($data['lastname'])
          ->setFirstname($data['firstname'])
          ->setEmail($data['email']);

        $manager->flush();

        $this->addFlash('success', 'Utilisateur mis à jour avec succès.');
        return $this->redirectToRoute('users.admin.manage');
        } else {
        $this->addFlash('error', 'Token CSRF invalide.');
        }
      } else {
        $this->addFlash('error', 'Une erreur est survenue.');
      }
      }

    return $this->render('pages/admin/users.update.html.twig', [
      'user' => $user,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Delete a user.
   *
   * @return Response
   */
  #[Route('/admin/users/delete/{id}', name: 'users.delete', methods: ['POST'])]
  public function delete(Users $user, EntityManagerInterface $manager): Response
  {
    $manager->remove($user);
    $manager->flush();

    $this->addFlash('success', 'Utilisateur supprimé avec succès.');
    return $this->redirectToRoute('users.admin.manage');
  }

  /**
   * Request to reset a user's password.
   *
   * @return Response
   */
  #[Route('/admin/users/request-reset/{id}', name: 'users.request_reset_password', methods: ['POST'])]
  public function requestResetPassword(Users $user, EntityManagerInterface $entityManager, MailerService $mailerService): Response
  {
    $resetToken = bin2hex(random_bytes(32));
    $user->setResetToken($resetToken);

    $user->setResetTokenExpiresAt(new \DateTime('+1 hour'));

    $entityManager->flush();

    try {
      $mailerService->sendResetPasswordEmail($user, $resetToken);
      $this->addFlash('success', 'E-mail de réinitialisation envoyé.');
    } catch (\Exception $e) {
      error_log($e->getMessage());
      $this->addFlash('error', 'Erreur lors de l\'envoi de l\'e-mail.');
    }
    return $this->redirectToRoute('users.admin.manage');
  }

  /**
   * Display the reset password form.
   *
   * @return Response
   */
  #[Route('/reset-password', name: 'reset_password', methods: ['GET'])]
  public function showResetPasswordForm(Request $request, UsersRepository $usersRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    $token = $request->query->get('token');

    $user = $usersRepository->findOneBy(['resetToken' => $token]);

    if (!$user || $user->getResetTokenExpiresAt() < new \DateTime()) {
      $this->addFlash('error', 'Le lien de réinitialisation est invalide ou a expiré.');
      return $this->redirectToRoute('home.index');
    }

    return $this->render('pages/admin/reset_password.html.twig', [
      'resetToken' => $token,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Handle the reset password request.
   *
   * @return Response
   */
  #[Route('/handle-reset-password/{token}', name: 'handle_reset_password', methods: ['GET', 'POST'])]
  public function resetPassword(Request $request, string $token, UsersRepository $usersRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
  {
    $footerData = $this->footerService->getFooterData();
    $user = $usersRepository->findOneBy(['resetToken' => $token]);

    if (!$user || $user->getResetTokenExpiresAt() < new \DateTime()) {
      $this->addFlash('error', 'Le lien de réinitialisation est invalide ou a expiré.');
      return $this->redirectToRoute('home.index');
    }

    if ($request->isMethod('POST')) {
      $newPassword = $request->request->get('password');
      $user->setPlainPassword($newPassword);
      $user->setResetToken(null);
      $user->setResetTokenExpiresAt(null);

      $entityManager->flush();

      $this->addFlash('success', 'Mot de passe réinitialisé avec succès.');
      return $this->redirectToRoute('home.index');
    }

    return $this->render('pages/admin/reset_password.html.twig', [
      'resetToken' => $token,
      'footerData' => $footerData,
    ]);
  }
}
