<?php

namespace App\Entity;

use App\Repository\LogsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogsRepository::class)]
class Logs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private \DateTimeImmutable $ReceivedAt;

    #[ORM\Column]
    private array $request;

    #[ORM\Column(length: 255)]
    private string $receivedFrom;

    /**
     * @param array $request
     * @param string $receivedFrom
     */
    public function __construct(array $request, string $receivedFrom)
    {
        $this->ReceivedAt = new \DateTimeImmutable();
        $this->request = $request;
        $this->receivedFrom = $receivedFrom;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceivedAt(): \DateTimeImmutable
    {
        return $this->ReceivedAt;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function getReceivedFrom(): string
    {
        return $this->receivedFrom;
    }

}
