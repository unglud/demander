<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StationRepository::class)
 */
#[ApiResource(denormalizationContext: ["groups" => ["write"]], normalizationContext: ["groups" => ["read"]])]
class Station extends Location
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="start_location", orphanRemoval=true)
     */
    private $outgoing_orders;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="end_location", orphanRemoval=true)
     */
    private $incoming_orders;


    public function __construct()
    {
        $this->outgoing_orders = new ArrayCollection();
        $this->incoming_orders = new ArrayCollection();
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
        return "Station $this->name";
    }

    /**
     * @return Collection|Order[]
     */
    public function getIncomingOrders(): Collection
    {
        return $this->incoming_orders;
    }

    public function addIncomingOrder(Order $incomingOrder): self
    {
        if (!$this->incoming_orders->contains($incomingOrder)) {
            $this->incoming_orders[] = $incomingOrder;
            $incomingOrder->setEndLocation($this);
        }

        return $this;
    }

    public function removeIncomingOrder(Order $incomingOrder): self
    {
        if ($this->incoming_orders->removeElement($incomingOrder)) {
            // set the owning side to null (unless already changed)
            if ($incomingOrder->getEndLocation() === $this) {
                $incomingOrder->setEndLocation(null);
            }
        }

        return $this;
    }
}
