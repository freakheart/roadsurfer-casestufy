<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="station")
 */
class Station
{
    use IdTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="stations")
     *
     * @var Collection<int, Product>
     */
    private Collection $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="station")
     *
     * @var Collection<int, Offer>
     */
    private Collection $offers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="pickupStation")
     *
     * @var Collection<int, Order>
     */
    private Collection $pickupOrders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="returnStation")
     *
     * @var Collection<int, Order>
     */
    private Collection $returnOrders;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->pickupOrders = new ArrayCollection();
        $this->returnOrders = new ArrayCollection();
        $this->createdAt = new DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): iterable
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    public function removeProduct(Product $product): void
    {
        $this->products->removeElement($product);
    }

    /**
     * @param Collection<int, Product> $products
     */
    public function setProducts(iterable $products): void
    {
        $this->products->clear();
        foreach ($products as $product) {
            $this->addProduct($product);
        }
    }

    /**
     * @return Collection<int, Order>
     */
    public function getPickupOrders(): Collection
    {
        return $this->pickupOrders;
    }

    public function addPickupOrder(Order $order): void
    {
        if (!$this->pickupOrders->contains($order)) {
            $this->pickupOrders->add($order);
        }
    }

    public function removePickupOrder(Order $order): void
    {
        $this->pickupOrders->removeElement($order);
    }

    /**
     * @return Collection<int, Order>
     */
    public function getReturnOrders(): Collection
    {
        return $this->returnOrders;
    }

    public function addReturnOrder(Order $order): void
    {
        if (!$this->returnOrders->contains($order)) {
            $this->returnOrders->add($order);
        }
    }

    public function removeReturnOrder(Order $order): void
    {
        $this->returnOrders->removeElement($order);
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): void
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
        }
    }

    public function removeOffer(Offer $offer): void
    {
        $this->offers->removeElement($offer);
    }
}
