<?php

namespace App\Entity;

use App\Entity\Seance;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TicketRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\PaymentController;
use Symfony\Component\Serializer\Annotation\Groups;

// use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['read:item:ticket']],
    operations: [
        new Get(),
        new Post(
            controller: PaymentController::class,
            uriTemplate: "/payment/{id}",
            uriVariables: ['id' => new Link(
                fromClass: Seance::class,
                toProperty: 'seance_id',
            )],
        )
    ]
)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('read:item:ticket')]
    private ?float $price = null;
    
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read:item:ticket')]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read:item:ticket')]
    private ?Seance $seance_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSeanceId(): ?Seance
    {
        return $this->seance_id;
    }

    public function setSeanceId(?Seance $seance_id): self
    {
        $this->seance_id = $seance_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
