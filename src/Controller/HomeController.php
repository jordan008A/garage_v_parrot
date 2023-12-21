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

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServicesRepository $servicesRepository, ReviewsRepository $reviewsRepository, EntityManagerInterface $manager, ValidatorInterface $validator): Response
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

            if (!empty($data['subject'])){
                // Récupération du service
                $serviceId = $data['subject'];
                $service = $servicesRepository->find($serviceId);
                $review->setService($service);
                $errors = $validator->validate($review);
                if (count($errors) > 0) {
                  foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                  }
                } else {
                  $manager->persist($review);
                  $manager->flush();
      
                  $this->addFlash('success', 'Votre avis a été envoyé avec succès.');
                  return $this->redirectToRoute('home.index');
                }
              } else {
                  // Gérer le cas où le service n'est pas trouvé
                  $this->addFlash('error', 'Sujet non répertorié.');
              }
        }

        // Afficher la page avec les avis existants
        return $this->render('pages/home/index.html.twig', [
            'reviews' => $reviewsRepository->findApprovedReviews(),
            'services' => $servicesRepository->findAll(),
        ]);
    }
}
