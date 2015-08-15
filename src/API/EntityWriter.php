<?php
namespace Apitude\Core\API;


use Apitude\Core\Entities\AbstractEntity;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

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
