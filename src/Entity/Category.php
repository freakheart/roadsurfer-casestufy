<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    use IdTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private ?string $name = null;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
