<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Entity\Ticket;
use App\Entity\MovieRoom;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SeanceRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Filesystem\Path;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ApiResource ()]
#[ApiFilter(SearchFilter::class, properties: ['date' => 'exact', 'movie' => 'exact'])]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $start_time = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MovieRoom $movieroom_id = null;

    #[ORM\OneToMany(mappedBy: 'seance_id', targetEntity: Ticket::class)]
    private Collection $tickets;

    #[ORM\ManyToOne(inversedBy: 'seance')]
    private ?Movie $movie = null;

    #[ORM\Column]
    #[Groups('movie')]
    private ?float $price = null;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

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

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getMovieroomId(): ?MovieRoom
    {
        return $this->movieroom_id;
    }

    public function setMovieroomId(?MovieRoom $movieroom_id): self
    {
        $this->movieroom_id = $movieroom_id;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setSeanceId($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getSeanceId() === $this) {
                $ticket->setSeanceId(null);
            }
        }

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    #[Groups('movie')]
    public function getStartTimeFormatted(): string
    {
        return $this->start_time->format('H:i');
    }

    #[Groups('movie')]
    public function getEndTimeFormatted(): string
    {
        return $this->end_time->format('H:i');
    }

    #[Groups('movie')]
    public function getDateFormatted(): ?string
    {
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $date_str = $this->date->format('j F Y'); // formatte la date en utilisant le nom complet du mois en anglais
        $date_str = str_replace($english_months, $french_months, $date_str); // remplace les noms de mois anglais par leurs équivalents français
        
        return $date_str;
    }

}
