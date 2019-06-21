<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=30)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="houseNumber", type="integer")
     */
    private $houseNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="flat", type="integer", nullable=true)
     */
    private $flat;
    /**
     * @var string
     * @ORM\Column(name="zip_code", type="string", length=6)
     */
    private $zipCode;
    /**
     * @var Person
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Person", mappedBy="address")
     */
    private $persons;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     *
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return int
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set flat
     *
     * @param integer $flat
     *
     * @return Address
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;

        return $this;
    }

    /**
     * Get flat
     *
     * @return int
     */
    public function getFlat()
    {
        return $this->flat;
    }

    public function addPerson(Person $person)
    {
        if (!$this->persons->contains($person)) {
            $this->persons->add($person);
        }
    }

    public function removePerson(Person $person)
    {
        if ($this->persons->contains($person)) {
            $this->persons->removeElement($person);
        }
    }

    public function getPerson() : Collection
    {
        return $this->persons;
    }

    /**
     * @return string
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }
    
    public function __toString()
    {
        return $this->city . ', ' . $this->street . ', ' . $this->houseNumber . ', ' . $this->flat . ', ' . $this->zipCode;
    }
}

