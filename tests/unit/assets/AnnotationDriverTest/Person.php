<?php
namespace Entities;

use Apitude\Entities\AbstractEntity;
use Apitude\Entities\User;
use Apitude\EntityStubs\StampEntityInterface;
use Apitude\EntityStubs\StampEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Apitude\Annotations\API;

/**
 * Class Person
 * @package Apitest\Entities
 * @ORM\Entity
 * @ORM\Table(name="persons")
 * @API\Entity\Expose(name="Someone")
 */
class Person extends AbstractEntity implements StampEntityInterface
{
    use StampEntityTrait;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @API\Property\Expose
     * @API\Property\GetterMethod
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     * @API\Property\Expose(name="first")
     * @API\Property\GetterMethod
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     * @API\Property\Expose()
     * @API\Property\GetterMethod
     */
    private $lastName;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Apitude\Entities\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Person
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
