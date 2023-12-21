<?php

namespace App\Controller;

use App\Entity\Messages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ServicesRepository;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            // Créer une nouvelle instance de Messages
            $message = new Messages();
            $message->setFirstname($data['firstname']);
            $message->setLastname($data['lastname']);
            $message->setEmail($data['email']);
            $message->setPhoneNumber($data['phone']);
            $message->setText($data['comment']);
            
            if (!empty($data['subject']) && isset($data['_csrf_token'])){
              //Création du token CSRF
              $csrfToken = new CsrfToken('contact-index-form', $data['_csrf_token']);

              // Récupération du service
              $serviceId = $data['subject'];
              $service = $servicesRepository->find($serviceId);
              $message->setService($service);
              $errors = $validator->validate($message);

              if (count($errors) > 0 || !$csrfTokenManager->isTokenValid($csrfToken)) {

                $this->addFlash('error', 'Une erreur est survenue.');

              } else {

                $manager->persist($message);
                $manager->flush();
    
                $this->addFlash('success', 'Votre message a été envoyé avec succès.');
                return $this->redirectToRoute('home.index');
              }
            } else {
                // Gérer le cas où il y ai un problème avec le service ou le token CSRF
                $this->addFlash('error', 'Une erreur est survenue.');
            }

          }

        return $this->render('pages/contact/index.html.twig', [
          'services' => $servicesRepository->findAll(),
        ]);
    }
}
