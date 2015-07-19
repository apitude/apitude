<?php
namespace B2k\Apitude\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package B2k\Apitude\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
abstract class User
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $password;

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
