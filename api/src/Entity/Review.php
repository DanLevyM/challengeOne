<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[GetCollection()]
#[Get(normalizationContext: ['groups' => 'read:review'])]
#[ApiFilter(SearchFilter::class, properties: ['validate' => 'exact', 'user_admin_check' => 'exact', 'movie' => 'exact', 'user_admin' => 'exact'])]

class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:review')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('read:review')]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[Groups('read:review')]
    private ?User $user_admin = null;

    #[ORM\ManyToOne()]
    #[Groups('read:review')]
    private ?User $user_admin_check = null;

    #[ORM\Column(nullable: true)]
    #[Groups('read:review')]
    private ?bool $validate = null;


    #[ORM\ManyToOne(inversedBy: 'reviewed_movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read:review')]
    private ?Movie $movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserAdmin(): ?User
    {
        return $this->user_admin;
    }

    public function setUserAdmin(?User $user_admin): self
    {
        $this->user_admin = $user_admin;

        return $this;
    }

    public function getUserAdminCheck(): ?User
    {
        return $this->user_admin_check;
    }

    public function setUserAdminCheck(?User $user_admin_check): self
    {
        $this->user_admin_check = $user_admin_check;

        return $this;
    }

    public function isValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(?bool $validate): self
    {
        $this->validate = $validate;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    #[Groups('read:review')]
    public function getFirstName(): ?string
    {
        return $this->user_admin_check ? $this->user_admin_check->getFirstName() : null;
    }
    
    #[Groups('read:review')]
    public function getLastName(): ?string
    {
        return $this->user_admin_check ? $this->user_admin_check->getLastName() : null;
    }
}
