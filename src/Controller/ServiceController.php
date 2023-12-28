<?php

namespace App\Controller;

use App\Entity\Services;
use App\Service\FooterService;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    private $footerService;

      public function __construct(FooterService $footerService)
      {
          $this->footerService = $footerService;
      }
      
    #[Route('/services', name: 'services.index', methods: ['GET'])]
    public function index(ServicesRepository $servicesRepository): Response
    {
        $footerData = $this->footerService->getFooterData();
        // Afficher la liste des services
        return $this->render('pages/services/index.html.twig', [
            'services' => $servicesRepository->findAll(),
            'footerData' => $footerData,
        ]);
    }

    #[Route('/admin/services', name: 'services.admin.manage', methods: ['GET'])]
    public function manage(ServicesRepository $servicesRepository): Response
    {
        $footerData = $this->footerService->getFooterData();
        // Afficher la liste des services
        return $this->render('pages/admin/services.html.twig', [
            'services' => $servicesRepository->findAll(),
            'footerData' => $footerData,
        ]);
    }

    #[Route('/admin/services/create', name: 'services.create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
    
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $service = new Services();
            $service->setTitle($data['title']);
            $service->setText($data['content']);

            $file = $request->files->get('image');
            if ($file) {
              $filename = md5(uniqid()) . '.' . $file->guessExtension();
              $file->move($this->getParameter('images_directory'), $filename);
              $service->setPicture($filename);
            }

            if (isset($data['_csrf_token'])){
              //Création du token CSRF
              $csrfToken = new CsrfToken('create-service-form', $data['_csrf_token']);

              
              $errors = $validator->validate($service);

              if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {

                $this->addFlash('error', 'Une erreur est survenue.');

              } else {

                $manager->persist($service);
                $manager->flush();
    
                $this->addFlash('success', 'Votre service a été créé avec succès.');
                return $this->redirectToRoute('services.admin.manage');
              }
            } else {
                // Gérer le cas où il y ai un problème avec le service ou le token CSRF
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
    }

    #[Route('/admin/services/edit/{id}', name: 'services.edit', methods: ['GET'])]
    public function edit(int $id, ServicesRepository $servicesRepository): Response
    {
        // Trouver le service par son ID
        $service = $servicesRepository->find($id);

        // Si le service n'est pas trouvé, renvoyer une erreur 404
        if (!$service) {
            throw $this->createNotFoundException('Le service demandé n\'a pas été trouvé.');
        }

        // Récupérer les données pour le formulaire de mise à jour
        $footerData = $this->footerService->getFooterData();

        // Renvoyer la vue avec les données du service
        return $this->render('pages/admin/services.update.html.twig', [
            'service' => $service,
            'footerData' => $footerData,
        ]);
    }

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
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('images_directory'), $filename);
                $service->setPicture($filename);
            }

            if (isset($data['_csrf_token'])){
              //Création du token CSRF
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
                // Gérer le cas où il y ai un problème avec le service ou le token CSRF
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
    }

    #[Route('/admin/services/delete/{id}', name: 'services.delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $manager): Response
    {
        $service = $manager->getRepository(Services::class)->find($id);

        if ($service) {
            $manager->remove($service);
            $manager->flush();

            $this->addFlash('success', 'Le service a été supprimé.');
        } else {
            $this->addFlash('error', 'Service introuvable.');
        }

        return $this->redirectToRoute('services.admin.manage');
    }
}
