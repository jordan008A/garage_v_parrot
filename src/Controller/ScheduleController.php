<?php

namespace App\Controller;

use App\Service\FooterService;
use App\Repository\SchedulesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScheduleController extends AbstractController
{
  private FooterService $footerService;

  /**
   * Contructor for ScheduleController
   *
   * @param FooterService $footerService
   */
  public function __construct(FooterService $footerService)
  {
    $this->footerService = $footerService;
  }

  /**
   * Display the schedule management page in the admin panel.
   *
   * @param SchedulesRepository $schedulesRepository
   * @return Response
   */
  #[Route('/admin/schedules/manage', name: 'schedules.admin.manage', methods: ['GET'])]
  public function manage(SchedulesRepository $schedulesRepository): Response
  {
    $footerData = $this->footerService->getFooterData();
    $schedules = $schedulesRepository->findAll();
    $scheduleData = [];

    foreach ($schedules as $schedule) {
      $scheduleData[strtolower($schedule->getDay())] = $schedule->getText();
    }

    return $this->render('pages/admin/schedules.html.twig', [
      'scheduleData' => $scheduleData,
      'footerData' => $footerData,
    ]);
  }


  /**
   * Update schedule information in the admin panel.
   *
   * @param SchedulesRepository $schedulesRepository
   * @return Response
   */
  #[Route('/admin/schedules/update', name: 'schedules.update', methods: ['POST'])]
  public function update(Request $request, SchedulesRepository $schedulesRepository, EntityManagerInterface $manager, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfTokenManager): Response
  {
    $data = $request->request->all();

    if (isset($data['_csrf_token'])) {
      $csrfToken = new CsrfToken('schedule-form', $data['_csrf_token']);
      if (!$csrfTokenManager->isTokenValid($csrfToken)) {
        $this->addFlash('error', 'Token CSRF invalide.');
        return $this->redirectToRoute('schedules.admin.manage');
      }

      foreach ($data as $day => $text) {
        if ($day !== '_csrf_token') {
          $schedule = $schedulesRepository->findOneBy(['day' => ucfirst($day)]);
          if ($schedule) {
            $schedule->setText($text);
            $errors = $validator->validate($schedule);

            if (count($errors) > 0) {
              $this->addFlash('error', 'Une erreur est survenue.');
              return $this->redirectToRoute('schedules.admin.manage');
            } else {
              $manager->persist($schedule);
            }
          }
        }
      }

      $manager->flush();
      $this->addFlash('success', 'Les horaires ont été mis à jour.');
    } else {
      $this->addFlash('error', 'Une erreur est survenue.');
    }

    return $this->redirectToRoute('schedules.admin.manage');
  }
}
