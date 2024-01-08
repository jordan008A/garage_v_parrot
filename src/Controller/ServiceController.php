<?php

namespace App\Controller;

use App\Entity\Services;
use App\Service\FooterService;
use App\Service\S3ClientService;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
  private S3ClientService $s3ClientService;
  private FooterService $footerService;

    /**
     * Constructor for ServiceController
     *
     * @param FooterService $footerService
     */
    public function __construct(FooterService $footerService, S3ClientService $s3ClientService)
    {
      $this->footerService = $footerService;
      $this->s3ClientService = $s3ClientService;
    }

    private function saveImage(UploadedFile $file): string
    {
      $filename = md5(uniqid()) . '.' . $file->guessExtension();
      $this->s3ClientService->uploadFile($file->getPathname(), $filename);
      return $filename;
    }

  /**
   * Undocumented function
   *
   * @param ServicesRepository $servicesRepository
   * @return Response
   */
  #[Route('/services', name: 'services.index', methods: ['GET'])]
  public function index(ServicesRepository $servicesRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    return $this->render('pages/services/index.html.twig', [
      'services' => $servicesRepository->findAll(),
      'footerData' => $footerData,
    ]);
  }

  /**
   * Display a list of services.
   *
   * @param ServicesRepository $servicesRepository
   * @return Response
   */
  #[Route('/admin/services', name: 'services.admin.manage', methods: ['GET'])]
  public function manage(ServicesRepository $servicesRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    return $this->render('pages/admin/services.html.twig', [
      'services' => $servicesRepository->findAll(),
      'footerData' => $footerData,
    ]);
  }

  /**
   * Display the management page for services in the admin panel.
   *
   * @param ServicesRepository $servicesRepository
   * @return Response
   */
  #[Route('/admin/services/create', name: 'services.create', methods: ['POST'])]
  public function create(Request $request, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    if ($request->isMethod('POST')) {
      $data = $request->request->all();
  
      $service = new Services();
      $service->setTitle($data['title']);
      $service->setText($data['content']);
      $file = $request->files->get('image');
      if (!$file) {
        $this->addFlash('error', 'L\'image ne doit pas être vide.');
        return $this->redirectToRoute('services.admin.manage');
      }
      if (isset($data['_csrf_token'])) {
        $csrfToken = new CsrfToken('create-service-form', $data['_csrf_token']);
        
        $errors = $validator->validate($service);
        
        if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {
          $this->addFlash('error', "Une erreur est survenue.");
          return $this->redirectToRoute('services.admin.manage');
        }
        $filename = $this->saveImage($file);
        $service->setPicture($filename);
        
        $manager->persist($service);
        $manager->flush();
        $this->addFlash('success', 'Votre service a été créé avec succès.');
        return $this->redirectToRoute('services.admin.manage');
      } else {
        $this->addFlash('error', 'Une erreur est survenue.');
        return $this->redirectToRoute('services.admin.manage');
      }
    }

    return $this->redirectToRoute('services.admin.manage');
  }
  

  /**
   * Edit an existing service.
   *
   * @param ServicesRepository $servicesRepository
   * @return Response
   */
  #[Route('/admin/services/edit/{id}', name: 'services.edit', methods: ['GET'])]
  public function edit(int $id, ServicesRepository $servicesRepository): Response
  {
    $service = $servicesRepository->find($id);

    if (!$service) {
      throw $this->createNotFoundException('Le service demandé n\'a pas été trouvé.');
    }

    $footerData = $this->footerService->getFooterData();

    return $this->render('pages/admin/services.update.html.twig', [
      'service' => $service,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Update an existing service.
   *
   * @param ServicesRepository $servicesRepository
   * @return Response
   */
  #[Route('/admin/services/update/{id}', name: 'services.update', methods: ['POST'])]
  public function update(int $id, Request $request, EntityManagerInterface $manager, ServicesRepository $servicesRepository, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    $service = $servicesRepository->find($id);
    if (!$service) {
      throw $this->createNotFoundException('Service non trouvé.');
    }
    if ($request->isMethod('POST')) {
      $data = $request->request->all();

      $service->setTitle($data['title']);
      $service->setText($data['content']);

      $file = $request->files->get('image');
      if ($file) {
          $filename = $this->saveImage($file);
          $service->setPicture($filename);
      }

      if (isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('update-service-form', $data['_csrf_token']);

        
        $errors = $validator->validate($service);

        if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {

        $this->addFlash('error', 'Une erreur est survenue.');

        } else {

        $manager->flush();
  
        $this->addFlash('success', 'Votre service a été modifié avec succès.');
        return $this->redirectToRoute('services.admin.manage');
        }
      } else {
        $this->addFlash('error', 'Une erreur est survenue.');
      }
    }

    return $this->redirectToRoute('services.admin.manage');
  }

  /**
   * Delete a service.
   *
   * @param int $id
   * @param EntityManagerInterface $manager
   * @return Response
   */
  #[Route('/admin/services/delete/{id}', name: 'services.delete', methods: ['POST'])]
  public function delete(int $id, EntityManagerInterface $manager): Response
  {
      $service = $manager->getRepository(Services::class)->find($id);
  
      if ($service) {
          $this->s3ClientService->deleteFile($service->getPicture());
          $manager->remove($service);
          $manager->flush();
  
          $this->addFlash('success', 'Le service a été supprimé.');
      } else {
          $this->addFlash('error', 'Service introuvable.');
      }
  
      return $this->redirectToRoute('services.admin.manage');
  }
}
