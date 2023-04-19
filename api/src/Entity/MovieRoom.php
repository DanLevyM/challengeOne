<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieRoomRepository::class)]
#[ApiResource]
class MovieRoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['seance:read'])]
    private ?int $number_places = null;

    #[ORM\OneToMany(mappedBy: 'movieroom_id', targetEntity: Seance::class)]
    private Collection $seances;

    #[ORM\Column(length: 255)]
    #[Groups(['seance:read'])]
    private ?string $room_name = null;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberPlaces(): ?int
    {
        return $this->number_places;
    }

    public function setNumberPlaces(int $number_places): self
    {
        $this->number_places = $number_places;

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setMovieroomId($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getMovieroomId() === $this) {
                $seance->setMovieroomId(null);
            }
        }

        return $this;
    }

    public function getRoomName(): ?string
    {
        return $this->room_name;
    }

    public function setRoomName(?string $room_name): self
    {
        $this->room_name = $room_name;

        return $this;
    }
}
