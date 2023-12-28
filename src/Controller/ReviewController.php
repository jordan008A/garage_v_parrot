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

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServicesRepository $servicesRepository, ReviewsRepository $reviewsRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $footerData = $this->footerService->getFooterData();

        // Gérer la soumission du formulaire
        if ($request->isMethod('POST')) {
          $data = $request->request->all();
          dump($data);
          
          // Créer une nouvelle instance de Reviews
          $review = new Reviews();
          $review->setLastname($data['lastname']);
          $review->setFirstname($data['firstname']);
          $review->setText($data['comment']);
          $review->setRate(intval($data['ratingValue']));
          $review->setApproved(false); // Par défaut, non approuvé

          if (!empty($data['subject']) && isset($data['_csrf_token'])){
              //Création du token CSRF
              $csrfToken = new CsrfToken('public-review-form', $data['_csrf_token']);

              // Récupération du service
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
              // Gérer le cas où il y ai un problème avec le service ou le token CSRF
              $this->addFlash('error', 'Une erreur est survenue.');
            }
      }

        // Afficher la page avec les avis existants
        return $this->render('pages/home/index.html.twig', [
            'reviews' => $reviewsRepository->findApprovedReviews(),
            'services' => $servicesRepository->findAll(),
            'footerData' => $footerData,
        ]);
    }

    #[Route('/admin/reviews', name: 'reviews.admin.index', methods: ['GET'])]
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

    #[Route('/admin/reviews/create', name: 'reviews.create', methods: ['POST'])]
    public function create(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        // Gérer la soumission du formulaire
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            // Créer une nouvelle instance de Reviews
            $review = new Reviews();
            $review->setLastname($data['lastname']);
            $review->setFirstname($data['firstname']);
            $review->setText($data['comment']);
            $review->setRate(intval($data['ratingValue']));
            $review->setApproved(false); // Par défaut, approuvé

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
                    return $this->redirectToRoute('reviews.admin.index');
                }
            } else {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }

        return $this->redirectToRoute('reviews.admin.index');
    }

    #[Route('/admin/reviews/delete/{id}', name: 'reviews.delete', methods: ['POST'])]
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

        return $this->redirectToRoute('reviews.admin.index');
    }

    #[Route('/admin/reviews/validate/{id}', name: 'reviews.validate', methods: ['POST'])]
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

        return $this->redirectToRoute('reviews.admin.index');
    }
}
