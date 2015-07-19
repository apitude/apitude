<?php
namespace B2k\Apitude\EntityStubs;

use B2k\Apitude\Entities\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StampEntityTrait
 * @package EntityStubs
 * @ORM\Entity
 * @method setCreated(\DateTime $dateTime)
 * @method setModified(\DateTime $dateTime)
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
     * @ORM\OneToOne(targetEntity="B2k\Apitude\Entities\User")
     * @ORM\JoinColumn(name="create_user_id", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="B2k\Apitude\Entities\User")
     * @ORM\JoinColumn(name="modify_user_id", referencedColumnName="id")
     */
    private $modifiedBy;
}
