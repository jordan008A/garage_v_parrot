<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Messages;
use App\Entity\Pictures;
use App\Service\FooterService;
use App\Repository\CarsRepository;
use App\Repository\BrandsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use App\Repository\MotorTechnologiesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{

  private $footerService;

  /**
   * Constructor for CarController.
   *
   * @param FooterService $footerService
   */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }

  /**
   * Saves an uploaded image file to the specified directory.
   *
   * @param UploadedFile $file
   * @param string $directory
   * @return string
   */
  private function saveImage(UploadedFile $file, $directory): string
  {
    $filename = md5(uniqid()) . '.' . $file->guessExtension();
    $file->move($directory, $filename);
    return $filename;
  }

  /**
   * Deletes an image file from the server.
   *
   * @param string $filename
   * @return bool
   */
  private function deleteImage(string $filename): bool {
    $filePath = $this->getParameter('images_directory') . '/' . $filename;
    
    if (file_exists($filePath)) {
      try {
        unlink($filePath);
        return true;
      } catch (\Exception $e) {
        error_log('Erreur lors de la suppression du fichier: ' . $e->getMessage());
        return false;
      }
    } else {
      error_log('Le fichier à supprimer n\'existe pas: ' . $filePath);
      return false;
    }
  }

  /**
   * Displays a list of cars with their primary pictures.
   *
   * @param CarsRepository $carsRepository
   * @return Response
   */
  #[Route('/occasions', name: 'occasions.index', methods: ['GET'])]
  public function index(CarsRepository $carsRepository): Response
  {

    $carsWithPrimaryPictures = $carsRepository->findCarsWithPrimaryPicture();

    $footerData = $this->footerService->getFooterData();

  return $this->render('pages/occasions/index.html.twig', [
    'cars' => $carsWithPrimaryPictures,
    'footerData' => $footerData,
  ]);
  }

  /**
   * Route to handle the filtering of cars based on user-provided criteria and return a JSON response.
   * Filters cars based on parameters like year, mileage, and price.
   *
   * @param CarsRepository $carsRepository
   * @param Request $request
   * @return JsonResponse
   */
  #[Route('/filter/occasions', name: 'occasions.filter', methods: ['GET'])]
  public function filter(CarsRepository $carsRepository, Request $request): JsonResponse
  {

    $footerData = $this->footerService->getFooterData();

    $yearMin = $request->query->get('yearMin');
    $yearMax = $request->query->get('yearMax');
    $kmMin = $request->query->get('kmMin');
    $kmMax = $request->query->get('kmMax');
    $priceMin = $request->query->get('priceMin');
    $priceMax = $request->query->get('priceMax');

    $cars = $carsRepository->findFilteredCars($yearMin, $yearMax, $kmMin, $kmMax, $priceMin, $priceMax);

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

    return $this->json([
      'cars' => $carData,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Route to display the details of a specific car and handle message submission related to it.
   * Renders the car details view and processes form submissions for inquiries.
   *
   * @param string $id
   * @param Request $request
   * @param CarsRepository $carsRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/occasions/{id}', name: 'occasions.details', methods: ['GET','POST'])]
  public function details($id, Request $request, CarsRepository $carsRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {

    $footerData = $this->footerService->getFooterData();

    $car = $carsRepository->find($id);
    if (!$car) {
    $this->addFlash('error', "La voiture demandée n'existe pas.");
    }

    if ($request->isMethod('POST')) {
      $data = $request->request->all();

      $message = new Messages();
      $message->setFirstname($data['firstname']);
      $message->setLastname($data['lastname']);
      $message->setEmail($data['email']);
      $message->setPhoneNumber($data['phone']);
      $message->setText($data['comment']);
      $message->setCar($car);
      
      if (isset($data['_csrf_token'])){
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
        $this->addFlash('error', 'Une erreur est survenue.');
      }

    }

    return $this->render('pages/occasions/details.html.twig', [
      'car' => $car,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Route for admin to manage car listings, showing all cars and related data for editing or deletion.
   * Renders the admin management view for cars.
   *
   * @param CarsRepository $carsRepository
   * @param BrandsRepository $brandsRepository
   * @param MotorTechnologiesRepository $motorTechnologiesRepository
   * @return Response
   */
  #[Route('/user/voitures', name: 'voitures.admin.manage', methods: ['GET'])]
  public function manage(CarsRepository $carsRepository, BrandsRepository $brandsrepository, MotorTechnologiesRepository $motorTechnologiesrepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    return $this->render('pages/admin/cars.html.twig', [
      'cars' => $carsRepository->findAll(),
      'brands' => $brandsrepository->findAll(),
      'motorTechnologies' => $motorTechnologiesrepository->findAll(),
      'footerData' => $footerData,
    ]);
  }

  /**
   * Route to create a new car entry in the system.
   * Handles the submission of the car creation form and performs data validation and saving.
   *
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @param BrandsRepository $brandsRepository
   * @param MotorTechnologiesRepository $motorTechnologiesRepository
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/voitures/create', name: 'voitures.create', methods: ['POST'])]
  public function create(Request $request, EntityManagerInterface $manager, BrandsRepository $brandsRepository, MotorTechnologiesRepository $motorTechnologiesRepository, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    if ($request->isMethod('POST')) {
      $data = $request->request->all();
    
      if (isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('create-car-form', $data['_csrf_token']);
        if ($csrfTokenManager->isTokenValid($csrfToken)) {
    
          $car = new Cars();
          $car->setTitle($data['title']);
          $car->setPrice($data['price']);
          $car->setYear($data['year']);
          $car->setMileage($data['mileage']);
          $car->setPuissanceDin($data['puissanceDin']);
          $car->setPuissanceFiscale($data['puissanceFiscale']);
          $car->setAutomatically($data['isAutomatically']);

          $brand = $brandsRepository->find($data['brand']);
          $motorTechnologie = $motorTechnologiesRepository->find($data['motorTechnologie']);
          $car->setBrand($brand);
          $car->setMotorTechnologie($motorTechnologie);

          try {
            $file = $request->files->get('primaryImageCarInput');
            if ($file && $file instanceof UploadedFile) {
              $filename = $this->saveImage($file, $this->getParameter('images_directory'));
              $picture = new Pictures();
              $picture->setPicture($filename);
              $picture->setIsPrimary(true);
              $car->addPicture($picture);
            }
  
            $files = $request->files->get('imagesCarInput');
            if ($files && is_array($files)) {
              foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                  $filename = $this->saveImage($file, $this->getParameter('images_directory'));
                  $picture = new Pictures();
                  $picture->setPicture($filename);
                  $picture->setIsPrimary(false);
                  $car->addPicture($picture);
                }
              }
            }
          } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de l\'enregistrement de l\'image : ' . $e->getMessage());
          }
  
          $errors = $validator->validate($car);
          if (count($errors) > 0) {
            foreach ($errors as $error) {
              $this->addFlash('error', $error->getMessage());
            }
          } else {
            $manager->persist($car);
            foreach ($car->getPictures() as $picture) {
              $manager->persist($picture);
            }
            $manager->flush();
  
            $this->addFlash('success', 'Votre voiture a été créée avec succès.');
            return $this->redirectToRoute('voitures.admin.manage');
          }
        } else {
          $this->addFlash('error', 'Token CSRF invalide.');
        }
      } else {
        $this->addFlash('error', 'Une erreur est survenue.');
      }
    }
  
    return $this->redirectToRoute('voitures.admin.manage');
  }


  /**
   * Route for editing an existing car entry.
   * Handles the submission of the car edit form, performs data validation, and updates the car details.
   *
   * @param string $id
   * @param Request $request
   * @param EntityManagerInterface $manager
   * @param BrandsRepository $brandsRepository
   * @param MotorTechnologiesRepository $motorTechnologiesRepository
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/user/voitures/edit/{id}', name: 'voitures.edit', methods: ['GET', 'POST'])]
  public function edit(string $id, Request $request, EntityManagerInterface $manager, BrandsRepository $brandsRepository, MotorTechnologiesRepository $motorTechnologiesRepository, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    $footerData = $this->footerService->getFooterData();

    $car = $manager->getRepository(Cars::class)->find($id);
    if (!$car) {
      $this->addFlash('error', 'Voiture introuvable.');
      return $this->redirectToRoute('voitures.admin.manage');
    }
  
    if ($request->isMethod('POST')) {
      $data = $request->request->all();
  
      $csrfToken = new CsrfToken('edit-car-form', $data['_csrf_token'] ?? '');
      if (!$csrfTokenManager->isTokenValid($csrfToken)) {
        $this->addFlash('error', 'Token de sécurité invalide.');
        return $this->redirectToRoute('voitures.edit', ['id' => $id]);
      }
  
      $car->setTitle($data['title']);
      $car->setPrice($data['price']);
      $car->setYear($data['year']);
      $car->setMileage($data['mileage']);
      $car->setPuissanceDin($data['puissanceDin']);
      $car->setPuissanceFiscale($data['puissanceFiscale']);
      $car->setAutomatically($data['isAutomatically']);
    
      $brand = $brandsRepository->find($data['brand']);
      $motorTechnologie = $motorTechnologiesRepository->find($data['motorTechnologie']);
      $car->setBrand($brand);
      $car->setMotorTechnologie($motorTechnologie);
  
      $errors = $validator->validate($car);
      if (count($errors) > 0) {
        foreach ($errors as $error) {
          $this->addFlash('error', $error->getMessage());
        }
        return $this->redirectToRoute('voitures.edit', ['id' => $id]);
      }
  
      $deletedImagesIds = explode(',', $request->request->get('deletedImages'));
      foreach ($car->getPictures() as $picture) {
        if (in_array($picture->getId(), $deletedImagesIds)) {
          $this->deleteImage($picture->getPicture());
          $manager->remove($picture);
          $manager->flush();
        }
      }
  
      $file = $request->files->get('primaryImageCarInput');
      if ($file && $file instanceof UploadedFile) {
        $filename = $this->saveImage($file, $this->getParameter('images_directory'));
        $picture = new Pictures();
        $picture->setPicture($filename);
        $picture->setIsPrimary(true);
        $car->addPicture($picture);
      }
  
      $files = $request->files->get('imagesCarInput');
      if ($files && is_array($files)) {
        foreach ($files as $file) {
          if ($file instanceof UploadedFile) {
            $filename = $this->saveImage($file, $this->getParameter('images_directory'));
            $picture = new Pictures();
            $picture->setPicture($filename);
            $picture->setIsPrimary(false);
            $car->addPicture($picture);
          }
        }
      }
  
      $manager->persist($car);
      foreach ($car->getPictures() as $picture) {
        $manager->persist($picture);
      }
      $manager->flush();
  
      $this->addFlash('success', 'La voiture a été modifiée avec succès.');
      return $this->redirectToRoute('voitures.admin.manage');
    }
  
    return $this->render('pages/admin/cars.update.html.twig', [
      'car' => $car,
      'brands' => $brandsRepository->findAll(),
      'motorTechnologies' => $motorTechnologiesRepository->findAll(),
      'footerData' => $footerData,
    ]);
  }

  /**
   * Route for deleting a car entry.
   * Handles the deletion of a car and its associated data from the system.
   *
   * @param string $id
   * @param EntityManagerInterface $manager
   * @return Response
   */
  #[Route('/user/voitures/delete/{id}', name: 'voitures.delete', methods: ['POST'])]
  public function delete(string $id, EntityManagerInterface $manager): Response
  {
  $car = $manager->getRepository(Cars::class)->find($id);

  if ($car) {
    foreach ($car->getPictures() as $picture) {
    $filePath = $this->getParameter('images_directory') . '/' . $picture->getPicture();

    if (file_exists($filePath)) {
      try {
      unlink($filePath);
      } catch (\Exception $e) {
      $this->addFlash('error', "Erreur lors de la suppression du fichier image : " . $e->getMessage());
      return $this->redirectToRoute('voitures.admin.manage');
      }
    } else {
      $this->addFlash('warning', "Le fichier image n'existe pas ou a déjà été supprimé : " . $filePath);
    }
    }

    $manager->remove($car);
    $manager->flush();

    $this->addFlash('success', 'La voiture a été supprimée avec succès.');
  } else {
    $this->addFlash('error', 'Voiture introuvable.');
  }

    return $this->redirectToRoute('voitures.admin.manage');
  }
}
