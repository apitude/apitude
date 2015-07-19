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
    public function setCreatedBy($createdBy)
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
    public function setModifiedBy($modifiedBy)
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
    public function setCreated($created)
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
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }
}
