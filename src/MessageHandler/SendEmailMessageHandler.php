<?php

namespace App\MessageHandler;

use App\Entity\Message;
use App\Message\SendEmailMessage;
use App\Repository\MessageRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    private MessageRepository $messageRepository;
    private MailerInterface $mailer;
    private BodyRendererInterface $bodyRenderer;

    /**
     * @param MessageRepository $messageRepository
     * @param MailerInterface $mailer
     * @param BodyRendererInterface $bodyRenderer
     */
    public function __construct(
        MessageRepository $messageRepository,
        MailerInterface $mailer,
        BodyRendererInterface $bodyRenderer)
    {
        $this->messageRepository = $messageRepository;
        $this->mailer = $mailer;
        $this->bodyRenderer = $bodyRenderer;
    }

    /**
     * @param SendEmailMessage $sendEmailMessage
     * @return void
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function __invoke(SendEmailMessage $sendEmailMessage)
    {
        if (!is_null($sendEmailMessage->getDelayedSend()))
        {
            $now =  new \DateTimeImmutable();
            if($now->getTimestamp() < $sendEmailMessage->getDelayedSend()->getTimestamp())
            {
                exit;
            }
        }

        $message = $this->messageRepository->find($sendEmailMessage->getMessageId());
        $this->sendMessage($message, $sendEmailMessage->getSendFromAddress());
    }

    /**
     * @param Message $message
     * @param string $sendFrom
     * @return void
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    private function sendMessage(Message $message, string $sendFrom) : void
    {
        $expirationDate = $message->getMessageData()->getDate();
        $now = new \DateTimeImmutable();
        $interval = $now->diff($expirationDate);
        $expiresIn =  $interval->format('%R%a');

        $templateLocation = 'email/'.$message->getTemptate()->getTemplateKey().'.html.twig';

        $email = (new TemplatedEmail())
            ->from($sendFrom)
            ->to(...$message->getEmails())
            ->bcc(...$message->getBcc())
            ->subject($message->getMessageData()->getSubject())
            ->htmlTemplate($templateLocation)
            ->context(['expiresIn' => $expiresIn, 'link' => $message->getMessageData()->getLink()]);

        $this->bodyRenderer->render($email);
        $this->mailer->send($email);
        $message->setMessageSent(new \DateTimeImmutable());
        $this->messageRepository->save($message);
    }
}
