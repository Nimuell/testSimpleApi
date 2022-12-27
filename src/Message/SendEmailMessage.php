<?php

namespace App\Message;

use DateTimeImmutable;

final class SendEmailMessage
{

    private ?DateTimeImmutable $delayedSend;

    private int $messageId;

    private string $sendFromAddress;

    /**
     * @param DateTimeImmutable|null $delayedSend
     * @param int $messageId
     * @param string $sendFromAddress
     */
    public function __construct(?DateTimeImmutable $delayedSend, int $messageId, string $sendFromAddress)
    {
        $this->delayedSend = $delayedSend;
        $this->messageId = $messageId;
        $this->sendFromAddress = $sendFromAddress;
    }


    /**
     * @return DateTimeImmutable|null
     */
    public function getDelayedSend(): ?DateTimeImmutable
    {
        return $this->delayedSend;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return string
     */
    public function getSendFromAddress(): string
    {
        return $this->sendFromAddress;
    }
}
