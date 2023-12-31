<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Service\FooterService;
use App\Repository\ReviewsRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

class ReviewController extends AbstractController
{
  private $footerService;

    /**
     * Constructor for ReviewController
     *
     * @param FooterService $footerService
     */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }

  /**
   * Display the home page and handle review submissions.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param ReviewsRepository $reviewsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
  public function index(Request $request, ServicesRepository $servicesRepository, ReviewsRepository $reviewsRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    $footerData = $this->footerService->getFooterData();

    if ($request->isMethod('POST')) {
      $data = $request->request->all();
  
      $review = new Reviews();
      $review->setLastname($data['lastname']);
      $review->setFirstname($data['firstname']);
      $review->setText($data['comment']);
      $review->setRate(intval($data['ratingValue']));
      $review->setApproved(false);

      if (!empty($data['subject']) && isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('public-review-form', $data['_csrf_token']);

        $serviceId = $data['subject'];
        $service = $servicesRepository->find($serviceId);
        $review->setService($service);
        $errors = $validator->validate($review);
        if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {
          $this->addFlash('error', 'Une erreur est survenue.');
        } else {
          $manager->persist($review);
          $manager->flush();
  
          $this->addFlash('success', 'Votre avis a été envoyé avec succès.');
          return $this->redirectToRoute('home.index');
          }
      } else {
        $this->addFlash('error', 'Veuillez sélectionner un sujet.');
      }
    }

    return $this->render('pages/home/index.html.twig', [
    'reviews' => $reviewsRepository->findApprovedReviews(),
    'services' => $servicesRepository->findAll(),
    'footerData' => $footerData,
    ]);
  }

  /**
   * Display a list of reviews in the admin panel.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param ReviewsRepository $reviewsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/reviews', name: 'reviews.admin.manage', methods: ['GET'])]
  public function adminIndex(ReviewsRepository $reviewsRepository, ServicesRepository $servicesRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    $approvedReviews = $reviewsRepository->findBy(['approved' => true]);
    $unapprovedReviews = $reviewsRepository->findBy(['approved' => false]);

    return $this->render('pages/admin/reviews.html.twig', [
    'approvedReviews' => $approvedReviews,
    'unapprovedReviews' => $unapprovedReviews,
    'footerData' => $footerData,
    'services' => $servicesRepository->findAll(),
    ]);
  }

  /**
   * Handle the creation of a review in the admin panel.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param ReviewsRepository $reviewsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/reviews/create', name: 'reviews.create', methods: ['POST'])]
  public function create(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    if ($request->isMethod('POST')) {
    $data = $request->request->all();

    $review = new Reviews();
    $review->setLastname($data['lastname']);
    $review->setFirstname($data['firstname']);
    $review->setText($data['comment']);
    $review->setRate(intval($data['ratingValue']));
    $review->setApproved(false);

      if (!empty($data['subject']) && isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('admin-review-form', $data['_csrf_token']);
        $serviceId = $data['subject'];
        $service = $servicesRepository->find($serviceId);
        $review->setService($service);
        $errors = $validator->validate($review);

        if (count($errors) > 0){
          foreach ($errors as $error) {
          $this->addFlash('error', $error->getMessage());
          }
        }elseif (!$csrfTokenManager->isTokenValid($csrfToken)) {
          $this->addFlash('error', 'Token CSRF invalide.');
        } else {
          $manager->persist($review);
          $manager->flush();
          $this->addFlash('success', 'Votre avis a été envoyé avec succès.');
          return $this->redirectToRoute('reviews.admin.manage');
        }
      } else {
        $this->addFlash('error', 'Veuillez sélectionner un sujet.');
      }
    }

    return $this->redirectToRoute('reviews.admin.manage');
  }

  /**
   * Handle the deletion of a review in the admin panel.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param ReviewsRepository $reviewsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/reviews/delete/{id}', name: 'reviews.delete', methods: ['POST'])]
  public function delete(int $id, EntityManagerInterface $manager, ReviewsRepository $reviewsRepository): Response
  {
    $review = $reviewsRepository->find($id);
    if ($review) {
      $manager->remove($review);
      $manager->flush();
      $this->addFlash('success', 'Avis supprimé avec succès.');
    } else {
      $this->addFlash('error', 'Avis introuvable.');
    }

    return $this->redirectToRoute('reviews.admin.manage');
  }

  /**
   * Handle the validation of a review in the admin panel.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param ReviewsRepository $reviewsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/reviews/validate/{id}', name: 'reviews.validate', methods: ['POST'])]
  public function validate(int $id, EntityManagerInterface $manager, ReviewsRepository $reviewsRepository): Response
  {
    $review = $reviewsRepository->find($id);
    if ($review) {
      $review->setApproved(true);
      $manager->persist($review);
      $manager->flush();
      $this->addFlash('success', 'Avis posté avec succès.');
    } else {
      $this->addFlash('error', 'Avis introuvable.');
    }

    return $this->redirectToRoute('reviews.admin.manage');
  }
}
