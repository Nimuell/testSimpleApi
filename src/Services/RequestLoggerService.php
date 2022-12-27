<?php

namespace App\Services;

use App\Entity\Logs;
use App\Repository\LogsRepository;
use Symfony\Component\HttpFoundation\Request;

class RequestLoggerService
{
    private LogsRepository $logsRepository;

    /**
     * @param LogsRepository $logsRepository
     */
    public function __construct(LogsRepository $logsRepository)
    {
        $this->logsRepository = $logsRepository;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function logRequest(Request $request): void
    {
        $log = new Logs(
            $request->toArray(),
            $request->getClientIp()
        );
        $this->logsRepository->save($log);
    }
}