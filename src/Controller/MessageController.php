<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Service\FooterService;
use App\Repository\MessagesRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{

  private FooterService $footerService;

    /**
     * Constructor for MessageController
     *
     * @param FooterService $footerService
     */
    public function __construct(FooterService $footerService)
    {
      $this->footerService = $footerService;
    }

  /**
   * Display the contact form and handle form submissions.
   *
   * @param Request $request
   * @param ServicesRepository $servicesRepository
   * @param EntityManagerInterface $manager
   * @param ValidatorInterface $validator
   * @param CsrfTokenManagerInterface $csrfTokenManager
   * @return Response
   */
  #[Route('/contact', name: 'messages.create', methods: ['GET', 'POST'])]
  public function create(Request $request, ServicesRepository $servicesRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    $footerData = $this->footerService->getFooterData();

    if ($request->isMethod('POST')) {
      $data = $request->request->all();

      $message = new Messages();
      $message->setFirstname($data['firstname']);
      $message->setLastname($data['lastname']);
      $message->setEmail($data['email']);
      $message->setPhoneNumber($data['phone']);
      $message->setText($data['comment']);
      
      if (!empty($data['subject']) && isset($data['_csrf_token'])){
        $csrfToken = new CsrfToken('contact-index-form', $data['_csrf_token']);

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
        $this->addFlash('error', 'Veuillez sélectionner un sujet.');
      }

      }

    return $this->render('pages/contact/index.html.twig', [
      'services' => $servicesRepository->findAll(),
      'footerData' => $footerData,
    ]);
  }

  /**
   * Display a list of messages in the admin panel.
   *
   * @param MessagesRepository $messagesRepository
   * @return Response
   */
  #[Route('/admin/messages', name: 'messages.admin.manage', methods: ['GET'])]
  public function index(MessagesRepository $messagesRepository): Response
  {
    $messagesData = [];
    $messages = $messagesRepository->findAll();

    foreach ($messages as $message) {
      $subjectTitle = null;
      if ($message->getCar()) {
        $subjectTitle = $message->getCar()->getTitle();
      } elseif ($message->getService()) {
        $subjectTitle = $message->getService()->getTitle();
      }

      $messagesData[] = [
        'id' => $message->getId(),
        'firstname' => $message->getFirstname(),
        'lastname' => $message->getLastname(),
        'email' => $message->getEmail(),
        'phone' => $message->getPhoneNumber(),
        'text' => $message->getText(),
        'subject' => $subjectTitle
      ];
    }

    $footerData = $this->footerService->getFooterData();

    return $this->render('pages/admin/messages.html.twig', [
      'messages' => $messagesData,
      'footerData' => $footerData,
    ]);
  }

  /**
   * Delete a message in the admin panel.
   *
   * @param MessagesRepository $messagesRepository
   * @return Response
   */
  #[Route('/admin/messages/delete/{id}', name: 'messages.delete', methods: ['POST'])]
  public function delete(int $id, EntityManagerInterface $manager): Response
  {
    $message = $manager->getRepository(Messages::class)->find($id);

    if ($message) {
      $manager->remove($message);
      $manager->flush();

      $this->addFlash('success', 'Le message a été supprimé.');
    } else {
      $this->addFlash('error', 'Message introuvable.');
    }

    return $this->redirectToRoute('messages.admin.manage');
  }

}
