<?php
namespace Apitude\Core\Entities;

use Doctrine\ORM\Mapping as ORM;
use Apitude\Core\Annotations\API;

/**
 * Class User
 * @package Apitude\Core\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @API\Entity\Expose()
 */
class User extends AbstractEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @API\Property\Expose()
     * @API\Property\GetterMethod()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     * @API\Property\Expose()
     * @API\Property\GetterMethod()
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
