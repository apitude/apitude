<?php
namespace Apitude\API;


use Apitude\Entities\AbstractEntity;
use Apitude\Provider\ContainerAwareInterface;
use Apitude\Provider\ContainerAwareTrait;
use Apitude\Provider\Helper\EntityManagerAwareInterface;
use Apitude\Provider\Helper\EntityManagerAwareTrait;

class EntityWriter implements ContainerAwareInterface, APIAw
{
    use ContainerAwareTrait;

    /**
     * @param AbstractEntity $entity
     */
    public function getArrayForEntity($entity)
    {
        $meta = $this->getMetadataFactory()->getMetadataFor($entity->getEntityClass());

    }
}
