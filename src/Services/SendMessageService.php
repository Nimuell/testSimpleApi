<?php

namespace App\Services;

use App\Entity\Message;
use App\Entity\MessageData;
use App\Message\SendEmailMessage;
use App\Repository\MessageRepository;
use App\Repository\TemplatesRepository;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendMessageService
{
    private string $senderEmail;
    private TemplatesRepository $templatesRepository;
    private MessageRepository $messageRepository;
    private MessageBusInterface $messageBus;

    /**
     * @param string $senderEmail
     * @param TemplatesRepository $templatesRepository
     * @param MessageRepository $messageRepository
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        string $senderEmail,
        TemplatesRepository $templatesRepository,
        MessageRepository $messageRepository,
        MessageBusInterface $messageBus
    ){
        $this->senderEmail = $senderEmail;
        $this->templatesRepository = $templatesRepository;
        $this->messageRepository = $messageRepository;
        $this->messageBus = $messageBus;
    }


    /**
     * @param array $requestBody
     * @return void
     * @throws TransportExceptionInterface
     */
    public function processSendMessage(array $requestBody){
        $delayedSend = null;
        if(is_string($requestBody['delayedSend']) && strlen($requestBody['delayedSend']) > 0){
            $delayedSend = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $requestBody['delayedSend']);
            if(!$delayedSend)
            {
                throw new InvalidArgumentException(
                    "unable to convert delayedSend value: ".$requestBody['delayedSend']
                );
            }
        }
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $requestBody['bodyData']['date']);
        $template = $this->templatesRepository->findOneBy(['templateKey' => $requestBody['templateKey']]);
        if(is_null($template)){
            throw new Exception(); // caught and send as response 400 by controller
        }
        $message = new Message(
            $requestBody['clientId'],
            $template,
            $requestBody['email'],
            $requestBody['bcc'],
            new MessageData(
                $requestBody['bodyData']['subject'],
                $date,
                $requestBody['bodyData']['link']
            ),
            $delayedSend
        );
        $message = $this->messageRepository->save($message);
        $sendEmailMessage = new SendEmailMessage(
            $delayedSend,
            $message->getId(),
            $this->senderEmail
        );
        $this->messageBus->dispatch($sendEmailMessage);
    }
}