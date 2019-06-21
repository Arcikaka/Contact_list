<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="emailAddress", type="string", length=40)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;
    /**
     * @var Person
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Person", mappedBy="email")
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
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return Email
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Email
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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

    public function __toString()
    {
        return $this->emailAddress . ', ' . $this->type;
    }
}

