<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
#[ApiResource]
class Order extends Location
{

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="outgoing_orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $start_location;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class)
     */
    private $end_station;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="orders")
     */
    private $equipment;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
    }

    public function getStartLocation(): ?Station
    {
        return $this->start_location;
    }

    public function setStartLocation(?Station $start_location): self
    {
        $this->start_location = $start_location;

        return $this;
    }

    public function getEndStation(): ?Station
    {
        return $this->end_station;
    }

    public function setEndStation(?Station $end_station): self
    {
        $this->end_station = $end_station;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
            $equipment->setOrders($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getOrders() === $this) {
                $equipment->setOrders(null);
            }
        }

        return $this;
    }
}
