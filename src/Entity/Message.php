<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $clientId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Templates $temptate;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $delayedSend;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private MessageData $MessageData;

    #[ORM\Column]
    private array $emails;

    #[ORM\Column]
    private array $bcc;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $messageSent = null;

    /**
     * @param string $clientId
     * @param Templates $temptate
     * @param array $emails
     * @param array $bcc
     * @param MessageData $MessageData
     * @param \DateTimeImmutable|null $delayedSend
     */
    public function __construct(
        string $clientId,
        Templates $temptate,
        array $emails,
        array $bcc,
        MessageData $MessageData,
        ?\DateTimeImmutable $delayedSend
    ){
        $this->clientId = $clientId;
        $this->temptate = $temptate;
        $this->emails = $emails;
        $this->bcc = $bcc;
        $this->MessageData = $MessageData;
        $this->delayedSend = $delayedSend;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getTemptate(): Templates
    {
        return $this->temptate;
    }

    public function getDelayedSend(): ?\DateTimeImmutable
    {
        return $this->delayedSend;
    }

    public function getMessageData(): MessageData
    {
        return $this->MessageData;
    }

    public function getMessageSent(): ?\DateTimeImmutable
    {
        return $this->messageSent;
    }

    public function setMessageSent(?\DateTimeImmutable $messageSent): self
    {
        $this->messageSent = $messageSent;

        return $this;
    }

    public function getEmails(): array
    {
        return $this->emails;
    }

    public function getBcc(): array
    {
        return $this->bcc;
    }

}
