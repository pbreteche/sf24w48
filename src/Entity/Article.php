<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Entity\Enums\ArticleState;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Ignore]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Length(min: 12, max: 255)]
    #[Groups(['teaser'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $body = null;

    #[ORM\Column(enumType: ArticleState::class)]
    #[NotNull]
    #[Groups(['teaser'])]
    private ?ArticleState $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Lifecycle callback example
     *
     * Lightweight callback, but no Dependency Injection.
     */
    #[ORM\PrePersist]
    public function setDefaultTitle(): void
    {
        $this->title ??= 'default value';
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getState(): ?ArticleState
    {
        return $this->state;
    }

    public function setState(ArticleState $state): static
    {
        $this->state = $state;

        return $this;
    }
}
