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

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager, ValidatorInterface $validator): Response
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
            
            if (!empty($data['subject'])){
              // Récupération du service
              $serviceId = $data['subject'];
              $service = $servicesRepository->find($serviceId);
              $message->setService($service);
              $errors = $validator->validate($message);
              if (count($errors) > 0) {
                foreach ($errors as $error) {
                  $this->addFlash('error', $error->getMessage());
                }
              } else {
                $manager->persist($message);
                $manager->flush();
    
                $this->addFlash('success', 'Votre message a été envoyé avec succès.');
                return $this->redirectToRoute('home.index');
              }
            } else {
                // Gérer le cas où le service n'est pas trouvé
                $this->addFlash('error', 'Sujet non répertorié.');
            }

          }

        return $this->render('pages/contact/index.html.twig', [
          'services' => $servicesRepository->findAll(),
        ]);
    }
}
