<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?User $user_admin = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?User $user_admin_check = null;

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

}
