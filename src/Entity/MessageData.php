<?php

namespace App\Entity;

use App\Repository\MessageDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageDataRepository::class)]
class MessageData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $date;

    #[ORM\Column]
    private array $link;

    /**
     * @param string|null $subject
     * @param \DateTimeImmutable|null $date
     * @param array $link
     */
    public function __construct(string $subject, \DateTimeImmutable $date, array $link)
    {
        $this->subject = $subject;
        $this->date = $date;
        $this->link = $link;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getLink(): array
    {
        return $this->link;
    }

}
