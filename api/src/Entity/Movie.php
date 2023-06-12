<?php

namespace App\Entity;

use App\Entity\Review;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MovieRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['movie']])]
#[Vich\Uploadable]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('movie')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie', 'seance:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('movie')]
    private ?string $director = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('movie')]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[Vich\UploadableField(mapping: 'imgs', fileNameProperty: 'img')]
    private ?File $imgFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    #[Groups('movie')]
    private ?int $duration = null;

    #[ORM\OneToMany(mappedBy: 'movie_id', targetEntity: Comment::class)]
    #[Groups('movie')]
    private Collection $comments;

    #[ORM\OneToOne(mappedBy: 'movie_id', cascade: ['persist', 'remove'])]
    #[Groups('movie')]
    private ?Review $review_id = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Seance::class)]
    #[Groups('movie')]
    private Collection $seance;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }


    public function getReviewId(): ?Review
    {
        return $this->review_id;
    }

    public function setReviewId(?Review $review_id): self
    {
        $this->review_id = $review_id;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imgFile
     */

    public function setImgFile(?File $imgFile = null): void
    {
        $this->imgFile = $imgFile;

        if (null !== $imgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImgFile()
    {
        return $this->imgFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
