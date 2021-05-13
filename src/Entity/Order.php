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
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="order", orphanRemoval=true)
     */
    private $equipment;

    /**
     * @ORM\OneToOne(targetEntity=Transport::class, inversedBy="order", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $transport;

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

    public function getEndLocation(): ?Station
    {
        return $this->end_location;
    }

    public function setEndLocation(?Station $end_location): self
    {
        $this->end_location = $end_location;

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
            $equipment->setOrder($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getOrder() === $this) {
                $equipment->setOrder(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getId();
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }
}
