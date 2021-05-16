<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\PriceTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    use IdTrait;
    use PriceTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private ?string $slug = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $shortDescription = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     * @ORM\JoinTable(name="products_categories")
     *
     * @var Collection<int, Category>
     */
    private Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Station", inversedBy="products")
     * @ORM\JoinTable(name="products_stations")
     *
     * @var Collection<int, Station>
     */
    private Collection $stations;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->categories = new ArrayCollection();
        $this->stations = new ArrayCollection();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): iterable
    {
        return $this->categories;
    }

    /**
     * @param Collection<int, Category> $categories
     */
    public function setCategories(iterable $categories): void
    {
        $this->categories->clear();
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    public function addCategory(Category $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return Collection<int, Station>
     */
    public function getStations(): iterable
    {
        return $this->stations;
    }

    /**
     * @param Collection<int, Station> $stations
     */
    public function setStations(iterable $stations): void
    {
        $this->stations->clear();
        foreach ($stations as $station) {
            $this->addStation($station);
        }
    }

    public function addStation(Station $station): void
    {
        if (!$this->stations->contains($station)) {
            $this->stations->add($station);
        }
    }

    public function removeStation(Station $station): void
    {
        $this->stations->removeElement($station);
    }
}
