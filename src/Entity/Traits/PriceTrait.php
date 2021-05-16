<?php

declare(strict_types=1);

namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait PriceTrait
{
    /**
     * @ORM\Column(type="float", options={"unsigned": true})
     *
     * @var float
     */
    private float $price = 0.0;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
