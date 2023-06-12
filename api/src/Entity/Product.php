<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
<<<<<<< HEAD
=======
#[Get]
#[Patch(security: "is_granted('ROLE_COMPANY')")]
#[GetCollection]
#[Post(security: "is_granted('ROLE_COMPANY')")]

<<<<<<< HEAD
>>>>>>> add security back and frontfront error message login and register
=======
>>>>>>> 7968e518be23b30b2863202c57e0f172ecf74d49
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
