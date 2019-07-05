<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->person = new ArrayCollection();
        $this->phone = new ArrayCollection();
        $this->emailPerson = new ArrayCollection();
        $this->address = new ArrayCollection();
        $this->groupsPerson = new ArrayCollection();
    }

    /**
     * @var Person
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Person", mappedBy="user")
     */
    protected $person;

    /**
     * @var Address
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Address", mappedBy="user")
     */
    protected $address;
    /**
     * @var Phone
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Phone", mappedBy="user")
     */
    protected $phone;
    /**
     * @var EmailPerson
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\EmailPerson", mappedBy="user")
     */
    protected $emailPerson;

    /**
     * @var GroupsPerson
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\GroupsPerson", mappedBy="user")
     */
    protected $groupsPerson;

    public function addPerson(Person $person)
    {
        if (!$this->groupsPerson->contains($person)) {
            $this->groupsPerson->add($person);
        }
    }

    public function removePerson(Person $person)
    {
        if ($this->person->contains($person)) {
            $this->person->removeElement($person);
        }
    }

    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPhone(Phone $phone)
    {
        if (!$this->phone->contains($phone)) {
            $this->phone->add($phone);
        }
    }

    public function removePhone(Phone $phone)
    {
        if ($this->phone->contains($phone)) {
            $this->phone->removeElement($phone);
        }
    }

    public function getPhone(): Collection
    {
        return $this->phone;
    }

    public function addAddress(Address $address)
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }
    }

    public function removeAddress(Address $address)
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
        }
    }

    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addEmailPersonPerson(EmailPerson $emailPerson)
    {
        if (!$this->emailPerson->contains($emailPerson)) {
            $this->emailPerson->add($emailPerson);
        }
    }

    public function removeEmailPerson(EmailPerson $emailPerson)
    {
        if ($this->emailPerson->contains($emailPerson)) {
            $this->emailPerson->removeElement($emailPerson);
        }
    }

    public function getEmailPerson(): Collection
    {
        return $this->emailPerson;
    }

    public function addGroupsPerson(groupsPerson $groupsPerson)
    {
        if (!$this->groupsPerson->contains($groupsPerson)) {
            $this->groupsPerson->add($groupsPerson);
        }
    }

    public function removeGroupsPerson(groupsPerson $groupsPerson)
    {
        if ($this->groupsPerson->contains($groupsPerson)) {
            $this->groupsPerson->removeElement($groupsPerson);
        }
    }

    public function getGroupsPerson(): Collection
    {
        return $this->groupsPerson;
    }
}

