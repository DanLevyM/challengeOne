<?php

namespace App\Entity;

use App\Entity\Movie;
use App\Entity\Moderation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommentRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('movie')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('movie')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('movie')]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('movie')]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $counter = null;

    #[ORM\OneToOne(mappedBy: 'commentaire_id', cascade: ['persist', 'remove'])]
    private ?Moderation $moderation = null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMovieId(): ?Movie
    {
        return $this->movie_id;
    }

    public function setMovieId(?Movie $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function setCounter(?int $counter): self
    {
        $this->counter = $counter;

        return $this;
    }

    public function getModeration(): ?Moderation
    {
        return $this->moderation;
    }

    public function setModeration(?Moderation $moderation): self
    {
        // unset the owning side of the relation if necessary
        if ($moderation === null && $this->moderation !== null) {
            $this->moderation->setCommentaireId(null);
        }

        // set the owning side of the relation if necessary
        if ($moderation !== null && $moderation->getCommentaireId() !== $this) {
            $moderation->setCommentaireId($this);
        }

        $this->moderation = $moderation;

        return $this;
    }
}
