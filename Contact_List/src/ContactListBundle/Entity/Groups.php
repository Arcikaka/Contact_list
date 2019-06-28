<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\GroupsRepository")
 */
class Groups
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
     * @ORM\Column(name="description", type="string", length=50)
     */
    private $description;

    /**
     * @var Person
     * @ORM\ManyToMany(targetEntity="ContactListBundle\Entity\Person", mappedBy="groups")
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
     * Set name
     *
     * @param string $name
     *
     * @return Groups
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
     * Set description
     *
     * @param string $description
     *
     * @return Groups
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
}

