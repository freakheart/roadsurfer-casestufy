<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
{
    use IdTrait;
    use TimestampableTrait;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETE = 'complete';
    public const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';

    public const STORE_TYPE_ONLINE = 'online';
    public const STORE_TYPE_STORE = 'store';
    public const STORE_TYPE_PHONE = 'phone';

    /**
     * @ORM\Column(type="integer")
     */
    private ?float $grandTotal = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $store = self::STORE_TYPE_ONLINE;

    /**
     * @ORM\Column(type="string")
     */
    private string $status = self::STATUS_PENDING;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="order", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @var Collection<int, OrderItem>
     */
    private Collection $items;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders", cascade={"persist"})
     */
    private Customer $customer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $scheduledReturn = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $returnedDateTime = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="pickupOrders", cascade={"persist"})
     * @ORM\JoinColumn(name="pickup_station_id", referencedColumnName="id")
     */
    private Station $pickupStation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="returnOrders", cascade={"persist"})
     * @ORM\JoinColumn(name="return_station_id", referencedColumnName="id")
     */
    private Station $returnStation;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function getGrandTotal(): ?float
    {
        return $this->grandTotal;
    }

    public function setGrandTotal(?float $grandTotal): void
    {
        $this->grandTotal = $grandTotal;
    }

    public function getStore(): string
    {
        return $this->store;
    }

    public function setStore(string $store): void
    {
        $this->store = $store;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): iterable
    {
        return $this->items;
    }

    public function removeItem(OrderItem $item): void
    {
        $this->items->removeElement($item);
    }

    public function addItem(OrderItem $item): void
    {
        if (!$this->items->contains($item)) {
            $item->setOrder($this);
            $this->items->add($item);
        }
    }

    public function getScheduledReturn(): ?DateTimeInterface
    {
        return $this->scheduledReturn;
    }

    public function setScheduledReturn(?DateTimeInterface $scheduledReturn): void
    {
        $this->scheduledReturn = $scheduledReturn;
    }

    public function getReturnedDateTime(): ?DateTimeInterface
    {
        return $this->returnedDateTime;
    }

    public function setReturnedDateTime(?DateTimeInterface $returnedDateTime): void
    {
        $this->returnedDateTime = $returnedDateTime;
    }

    public function getPickupStation(): Station
    {
        return $this->pickupStation;
    }

    public function setPickupStation(Station $pickupStation): void
    {
        $this->pickupStation = $pickupStation;
    }

    public function getReturnStation(): Station
    {
        return $this->returnStation;
    }

    public function setReturnStation(Station $returnStation): void
    {
        $this->returnStation = $returnStation;
    }
}
