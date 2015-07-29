<?php
namespace Apitude\API;


use Apitude\Entities\AbstractEntity;
use Apitude\Provider\ContainerAwareInterface;
use Apitude\Provider\ContainerAwareTrait;
use Apitude\Provider\Helper\EntityManagerAwareInterface;
use Apitude\Provider\Helper\EntityManagerAwareTrait;

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
