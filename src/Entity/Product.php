<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\PriceTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    use IdTrait, PriceTrait, TimestampableTrait;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Gedmo\Slug(fields={"name"})
     *
     * @var string|null
     */
    private ?string $slug = null;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    private ?string $shortDescription = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
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

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string|null $shortDescription
     */
    public function setShortDescription(?string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
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
