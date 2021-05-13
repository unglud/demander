<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StationRepository::class)
 */
#[ApiResource]
class Station
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="location_id", orphanRemoval=true)
     */
    private $equipment;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="start_location")
     */
    private $outgoing_orders;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->outgoing_orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $equipment->setLocationId($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getLocationId() === $this) {
                $equipment->setLocationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOutgoingOrders(): Collection
    {
        return $this->outgoing_orders;
    }

    public function addOutgoingOrder(Order $outgoingOrder): self
    {
        if (!$this->outgoing_orders->contains($outgoingOrder)) {
            $this->outgoing_orders[] = $outgoingOrder;
            $outgoingOrder->setStartLocation($this);
        }

        return $this;
    }

    public function removeOutgoingOrder(Order $outgoingOrder): self
    {
        if ($this->outgoing_orders->removeElement($outgoingOrder)) {
            // set the owning side to null (unless already changed)
            if ($outgoingOrder->getStartLocation() === $this) {
                $outgoingOrder->setStartLocation(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
