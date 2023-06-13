<?php

namespace App\Entity;

use App\Entity\Review;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MovieRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['movie', 'read:review']])]
#[Get()]
#[GetCollection()]
#[Post(security: 'is_granted("ROLE_ADMIN")')]
#[Patch(security: 'is_granted("ROLE_ADMIN")')]

class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('movie')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('movie', 'seance:read')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('movie')]
    private ?string $director = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('movie')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups('movie')]
    private ?int $duration = null;

    #[ORM\OneToMany(mappedBy: 'movie_id', targetEntity: Comment::class)]
    #[Groups('movie')]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Review::class)]
    #[Groups(['movie', 'read:review'])]
    private Collection $reviewed_movies;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Seance::class)]
    #[Groups('movie')]
    private Collection $seance;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->reviewed_movies = new ArrayCollection();
        $this->seance = new ArrayCollection();
    }

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

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $Duration): self
    {
        $this->duration = $Duration;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMovieId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovieId() === $this) {
                $comment->setMovieId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeance(): Collection
    {
        return $this->seance;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seance->contains($seance)) {
            $this->seance->add($seance);
            $seance->setMovie($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seance->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getMovie() === $this) {
                $seance->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviewed_movies;
    }

    public function addReviews(Review $reviewed_movies): self
    {
        if (!$this->reviewed_movies->contains($reviewed_movies)) {
            $this->reviewed_movies->add($reviewed_movies);
            $reviewed_movies->setMovie($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviewed_movies->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getMovie() === $this) {
                $review->setMovie(null);
            }
        }

        return $this;
    }

    #[Groups("movie")]
    public function getReleaseDateFormatted(): ?string
    {

        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $date_str = $this->release_date->format('j F Y'); // formatte la date en utilisant le nom complet du mois en anglais
        $date_str = str_replace($english_months, $french_months, $date_str); // remplace les noms de mois anglais par leurs équivalents français

        return $date_str;
    }
}
