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
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="incoming_orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $end_location;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="order")
     */
    private $equipment;

    /**
     * @ORM\OneToMany(targetEntity=Transport::class, mappedBy="order")
     */
    private $transports;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->transports = new ArrayCollection();
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

    /**
     * @return Collection|Transport[]
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->transports->contains($transport)) {
            $this->transports[] = $transport;
            $transport->setOrders($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getOrders() === $this) {
                $transport->setOrders(null);
            }
        }

        return $this;
    }

    public function getEndLocation(): ?Station
    {
        return $this->end_location;
    }

    public function setEndLocation(?Station $end_location): self
    {
        $this->end_location = $end_location;

        return $this;
    }
}
