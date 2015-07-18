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
     * @ORM\GeneratedValue(strategy="AUTO")
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
}
