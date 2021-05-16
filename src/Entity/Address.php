<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer_address")
 */
class Address
{
    use IdTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $company = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $salutation = null;

    /**
     * @ORM\Column(type="string")
     *
     * @var ?string
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $street = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $postcode = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $city = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $country = 'DE';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $phoneNumber = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $fax = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="addresses")
     */
    private Customer $customer;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): void
    {
        $this->company = $company;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): void
    {
        $this->fax = $fax;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }
}
