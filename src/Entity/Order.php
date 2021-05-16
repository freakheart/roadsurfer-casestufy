<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
{
    use IdTrait, TimestampableTrait;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETE = 'complete';
    public const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';

    public const STORE_TYPE_ONLINE = 'online';
    public const STORE_TYPE_STORE = 'store';
    public const STORE_TYPE_PHONE = 'phone';

    /**
     * @ORM\Column(type="integer")
     *
     * @var float|null
     */
    private ?float $grandTotal = null;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $store = self::STORE_TYPE_ONLINE;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
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
     *
     * @var Customer
     */
    private Customer $customer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $scheduledReturn = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $returnedDateTime = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="pickupOrders", cascade={"persist"})
     * @ORM\JoinColumn(name="pickup_station_id", referencedColumnName="id")
     *
     * @var Station
     */
    private Station $pickupStation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="returnOrders", cascade={"persist"})
     * @ORM\JoinColumn(name="return_station_id", referencedColumnName="id")
     *
     * @var Station
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

    /**
     * @return float|null
     */
    public function getGrandTotal(): ?float
    {
        return $this->grandTotal;
    }

    /**
     * @param float|null $grandTotal
     */
    public function setGrandTotal(?float $grandTotal): void
    {
        $this->grandTotal = $grandTotal;
    }

    /**
     * @return string
     */
    public function getStore(): string
    {
        return $this->store;
    }

    /**
     * @param string $store
     */
    public function setStore(string $store): void
    {
        $this->store = $store;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

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

    /**
     * @return DateTimeInterface|null
     */
    public function getScheduledReturn(): ?DateTimeInterface
    {
        return $this->scheduledReturn;
    }

    /**
     * @param DateTimeInterface|null $scheduledReturn
     */
    public function setScheduledReturn(?DateTimeInterface $scheduledReturn): void
    {
        $this->scheduledReturn = $scheduledReturn;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getReturnedDateTime(): ?DateTimeInterface
    {
        return $this->returnedDateTime;
    }

    /**
     * @param DateTimeInterface|null $returnedDateTime
     */
    public function setReturnedDateTime(?DateTimeInterface $returnedDateTime): void
    {
        $this->returnedDateTime = $returnedDateTime;
    }

    /**
     * @return Station
     */
    public function getPickupStation(): Station
    {
        return $this->pickupStation;
    }

    /**
     * @param Station $pickupStation
     */
    public function setPickupStation(Station $pickupStation): void
    {
        $this->pickupStation = $pickupStation;
    }

    /**
     * @return Station
     */
    public function getReturnStation(): Station
    {
        return $this->returnStation;
    }

    /**
     * @param Station $returnStation
     */
    public function setReturnStation(Station $returnStation): void
    {
        $this->returnStation = $returnStation;
    }
}
