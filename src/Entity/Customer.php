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
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="customer")
 */
class Customer
{
    use IdTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $salutation = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank
     */
    private ?string $email = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="customer", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @var Collection<int, Address>
     */
    private Collection $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="customer", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @var Collection<int, Order>
     */
    private Collection $orders;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->orders = new ArrayCollection();

        $this->createdAt = new DateTime('now');
    }

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function setSalutation(?string $salutation): void
    {
        $this->salutation = $salutation;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): iterable
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): void
    {
        if (!$this->addresses->contains($address)) {
            $address->setCustomer($this);
            $this->addresses->add($address);
        }
    }

    public function removeAddress(Address $address): void
    {
        $this->addresses->removeElement($address);
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): iterable
    {
        return $this->orders;
    }

    public function addOrder(Order $order): void
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }
    }

    public function removeOrder(Order $order): void
    {
        $this->orders->removeElement($order);
    }
}
