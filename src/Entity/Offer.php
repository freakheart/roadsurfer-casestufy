<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\PriceTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="offer")
 * @ORM\HasLifecycleCallbacks
 */
class Offer
{
    use IdTrait;
    use PriceTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private ?int $stock = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station", inversedBy="offers")
     */
    private Station $station;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function setStation(Station $station): void
    {
        $this->station = $station;
    }
}
