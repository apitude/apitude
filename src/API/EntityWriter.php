<?php
namespace B2k\Apitude\API;


use B2k\Apitude\Entities\AbstractEntity;
use B2k\Apitude\Provider\ContainerAwareInterface;
use B2k\Apitude\Provider\ContainerAwareTrait;
use B2k\Apitude\Provider\Helper\EntityManagerAwareInterface;
use B2k\Apitude\Provider\Helper\EntityManagerAwareTrait;

class EntityWriter implements ContainerAwareInterface, EntityManagerAwareInterface
{
    use ContainerAwareTrait;
    use EntityManagerAwareTrait;

    /**
     * @param AbstractEntity $entity
     */
    public function getArrayForEntity($entity)
    {
        $meta = $this->getMetadataFactory()->getMetadataFor($entity->getEntityClass());

    }
}
