<?php

namespace App\Service;

use App\Repository\SchedulesRepository;

class FooterService
{
    private $schedulesRepository;

    public function __construct(SchedulesRepository $schedulesRepository)
    {
        $this->schedulesRepository = $schedulesRepository;
    }

    public function getFooterData()
    {
        return $this->schedulesRepository->findSchedulesOrdered();
    }
}