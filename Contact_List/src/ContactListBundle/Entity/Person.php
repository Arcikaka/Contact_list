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
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;
    /**
     * @var Phone
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\Phone", inversedBy="persons")
     * @ORM\JoinColumn(name="phone_id", referencedColumnName="id", nullable=true)
     */
    private $phone;
    /**
     * @var EmailPerson
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\EmailPerson", inversedBy="persons")
     * @ORM\JoinColumn(name="email_id", referencedColumnName="id", nullable=true)
     */
    private $email;

    /**
     * @var GroupsPerson
     * @ORM\ManyToMany(targetEntity="ContactListBundle\Entity\GroupsPerson", inversedBy="persons")
     */
    private $groups;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="ContactListBundle\Entity\User", inversedBy="persons")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

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
    public function setAddress(Address $address = null)
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
    public function setPhone(Phone $phone = null)
    {
        $this->phone = $phone;
    }

    /**
     * @return EmailPerson
     */
    public function getEmail(): ?EmailPerson
    {
        return $this->email;
    }

    /**
     * @param EmailPerson $email
     */
    public function setEmail(EmailPerson $email = null)
    {
        $this->email = $email;
    }

    public function addGroups(GroupsPerson $groups)
    {
        if (!$this->groups->contains($groups)) {
            $this->groups->add($groups);
        }
    }

    public function removeGroups(GroupsPerson $groups)
    {
        if ($this->groups->contains($groups)) {
            $this->groups->removeElement($groups);
        }
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}

