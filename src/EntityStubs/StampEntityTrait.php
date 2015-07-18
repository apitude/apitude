<?php
namespace B2k\Apitude\EntityStubs;

use B2k\Apitude\Entities\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StampEntityTrait
 * @package EntityStubs
 * @ORM\Entity
 */
trait StampEntityTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $modified;

    /**
     * @var User
     * @ORM\OneToOne(mappedBy="create_user_id", targetEntity="User")
     */
    private $createdBy;

    /**
     * @var User
     * @ORM\OneToOne(mappedBy="modify_user_id", targetEntity="User")
     */
    private $modifiedBy;
}
