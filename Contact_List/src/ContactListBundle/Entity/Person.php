<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=50)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var Address
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\Address", inversedBy="persons")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id"))
     */
    private $address;
    /**
     * @var Phone
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\Phone", inversedBy="persons")
     * @ORM\JoinColumn(name="phone_id", referencedColumnName="id")
     */
    private $phone;
    /**
     * @var Email
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\Email", inversedBy="persons")
     * @ORM\JoinColumn(name="email_id", referencedColumnName="id")
     */
    private $email;

    /**
     * @var Groups
     * @ORM\ManyToMany(targetEntity="ContactListBundle\Entity\Groups", inversedBy="persons")
     */
    private $groups;
    
    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Person
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Phone
     */
    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     */
    public function setPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Email
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function addGroups(Groups $groups)
    {
        if (!$this->groups->contains($groups)) {
            $this->groups->add($groups);
        }
    }

    public function removeGroups(Groups $groups)
    {
        if ($this->groups->contains($groups)) {
            $this->groups->removeElement($groups);
        }
    }

    public function getGroups() : Collection
    {
        return $this->groups;
    }
    
}

