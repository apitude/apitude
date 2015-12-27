<?php
namespace Apitude\Core\API;


use Apitude\Core\API\Writer\ArrayWriter;
use Apitude\Core\Entities\AbstractEntity;
use Apitude\Core\Provider\ContainerAwareTrait;

class EntityWriter extends ArrayWriter
{
    use ContainerAwareTrait;
    use APIServiceAwareTrait;

    /**
     * @param AbstractEntity $object
     * @return array
     */
    public function getArrayForEntity($object)
    {
        return $this->writeObject($object);
    }
}
