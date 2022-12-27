<?php

namespace App\Entity;

use App\Repository\TemplatesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplatesRepository::class)]
class Templates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $templateKey;

    #[ORM\Column(length: 255)]
    private string $template;

    /**
     * @param string $templateKey
     * @param string $template
     */
    public function __construct(string $templateKey, string $template)
    {
        $this->id = null;
        $this->templateKey = $templateKey;
        $this->template = $template;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplateKey(): string
    {
        return $this->templateKey;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
