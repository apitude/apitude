<?php
namespace Apitude\Core\EntityStubs;

use Doctrine\ORM\Mapping as ORM;
use Apitude\Core\Annotations\API;

/**
 * Class StampEntityTrait
 * @package EntityStubs
 */
trait StampEntityTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @API\Property\Expose
     * @API\Property\GetterMethod
     * @API\Property\Renderer(
     *   renderService="Apitude\Core\API\Writer\PropertyWriter",
     *   renderMethod="renderISODateTime"
     * )
     */
    private $created;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @API\Property\Expose
     * @API\Property\GetterMethod
     * @API\Property\Renderer(
     *   renderService="Apitude\Core\API\Writer\PropertyWriter",
     *   renderMethod="renderISODateTime"
     * )
     */
    private $modified;

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
