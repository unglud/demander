<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
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

    public function __toString(): string
    {
        return $this->getId();
    }
}
