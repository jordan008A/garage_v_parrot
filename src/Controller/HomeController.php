<?php

namespace App\Controller;

use App\Entity\Reviews;
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

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServicesRepository $servicesRepository, ReviewsRepository $reviewsRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
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
                $csrfToken = new CsrfToken('contact-index-form', $data['_csrf_token']);

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
        ]);
    }
}
