<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\UuidV4;

class OccasionController extends AbstractController
{
    #[Route('/occasions', name: 'occasions.index', methods: ['GET'])]
    public function index(CarsRepository $carsRepository): Response
    {

      $carsWithPrimaryPictures = $carsRepository->findCarsWithPrimaryPicture();

    return $this->render('pages/occasions/index.html.twig', [
        'cars' => $carsWithPrimaryPictures,
    ]);
    }

    #[Route('/filter/occasions', name: 'filter_occasions', methods: ['GET'])]
    public function filter(CarsRepository $carsRepository, Request $request): JsonResponse
    {
        $yearMin = $request->query->get('yearMin');
        $yearMax = $request->query->get('yearMax');
        $kmMin = $request->query->get('kmMin');
        $kmMax = $request->query->get('kmMax');
        $priceMin = $request->query->get('priceMin');
        $priceMax = $request->query->get('priceMax');

        // Récupération des voitures filtrées
        $cars = $carsRepository->findFilteredCars($yearMin, $yearMax, $kmMin, $kmMax, $priceMin, $priceMax);

        // Préparation des données pour le JSON
        $carData = [];
        foreach ($cars as $car) {
            $primaryPicture = $car->getPictures()->filter(function($picture) {
                return $picture->isIsPrimary();
            })->first();

            $carData[] = [
                'id' => $car->getId(),
                'title' => $car->getTitle(),
                'brand' => $car->getBrand()->getProperty(),
                'price' => $car->getPrice(),
                'year' => $car->getYear(),
                'mileage' => $car->getMileage(),
                'primaryPictureUrl' => 'assets/img/uploads/' . $primaryPicture->getPicture(),
            ];
        }

        return $this->json(['cars' => $carData]);
    }

    #[Route('/occasions/{id}', name: 'occasions.details', methods: ['GET','POST'])]
    public function details($id, Request $request, CarsRepository $carsRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

      $car = $carsRepository->find($id);
      if (!$car) {
        $this->addFlash('error', "La voiture demandée n'existe pas.");
      }

        if ($request->isMethod('POST')) {
          $data = $request->request->all();

          // Créer une nouvelle instance de Messages
          $message = new Messages();
          $message->setFirstname($data['firstname']);
          $message->setLastname($data['lastname']);
          $message->setEmail($data['email']);
          $message->setPhoneNumber($data['phone']);
          $message->setText($data['comment']);
          $message->setCar($car);
          
          if (isset($data['_csrf_token'])){
            //Création du token CSRF
            $csrfToken = new CsrfToken('contact-details-form', $data['_csrf_token']);
            $errors = $validator->validate($message);

            if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {

              $this->addFlash('error', 'Une erreur est survenue.');

            } else {

              $manager->persist($message);
              $manager->flush();
  
              $this->addFlash('success', 'Votre message a été envoyé avec succès.');
              return $this->redirectToRoute('occasions.index');
            }
          } else {
              // Gérer le cas où il y ai un problème avec le service ou le token CSRF
              $this->addFlash('error', 'Une erreur est survenue.');
          }

        }

        return $this->render('pages/occasions/details.html.twig', [
            'car' => $car,
        ]);
    }
}
