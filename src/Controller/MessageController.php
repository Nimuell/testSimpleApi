<?php

namespace App\Controller;

use App\Services\RequestLoggerService;
use App\Services\SendMessageService;
use App\Utils\Validators\SendMessageValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends BaseController
{
    private SendMessageService $sendMessageService;
    private RequestLoggerService $requestLoggerService;

    /**
     * @param SendMessageService $sendMessageService
     * @param RequestLoggerService $requestLoggerService
     */
    public function __construct(
        SendMessageService $sendMessageService,
        RequestLoggerService $requestLoggerService
    ) {
        $this->sendMessageService = $sendMessageService;
        $this->requestLoggerService = $requestLoggerService;
    }


    /**
     * @return JsonResponse
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/message/send', name: 'app_message_send')]
    public function send(): JsonResponse
    {
        $request = Request::createFromGlobals();
        $this->requestLoggerService->logRequest($request);
        $requestBody = $request->toArray();

        try {
            SendMessageValidator::validate($requestBody);
            $this->sendMessageService->processSendMessage($requestBody);
            $responseCode = self::STATUS_ACCEPTED;
        } catch (\Throwable $e) {
            $responseCode = self::STATUS_BAD_REQUEST;
        }
        return $this->json(null, $responseCode);
    }
}
