<?php
namespace Apitude\EntityStubs;

use Apitude\Entities\User;
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
     * @ORM\OneToOne(targetEntity="Apitude\Entities\User")
     * @ORM\JoinColumn(name="create_user_id", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Apitude\Entities\User")
     * @ORM\JoinColumn(name="modify_user_id", referencedColumnName="id")
     */
    private $modifiedBy;

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return StampEntityTrait
     */
    public function setCreatedBy(User $createdBy = null)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return User
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @param User $modifiedBy
     * @return StampEntityTrait
     */
    public function setModifiedBy(User $modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return StampEntityTrait
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     * @return StampEntityTrait
     */
    public function setModified(\DateTime $modified)
    {
        $this->modified = $modified;
        return $this;
    }
}
