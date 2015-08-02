<?php
namespace Apitude\API;


use Apitude\Entities\AbstractEntity;
use Apitude\Provider\ContainerAwareInterface;
use Apitude\Provider\ContainerAwareTrait;

class EntityWriter implements ContainerAwareInterface, APIServiceAwareInterface
{
    use ContainerAwareTrait;
    use APIServiceAwareTrait;

    /**
     * @param AbstractEntity $entity
     */
    public function getArrayForEntity($entity)
    {
        $meta = $this->getMetadataFactory()->getMetadataFor($entity->getEntityClass());

    }
}
