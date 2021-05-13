<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransportRepository::class)
 */
#[ApiResource]
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="transports")
     */
    private $station;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="transport", cascade={"persist", "remove"})
     */
    private $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        // set the owning side of the relation if necessary
        if ($order->getTransport() !== $this) {
            $order->setTransport($this);
        }

        $this->order = $order;

        return $this;
    }
}
