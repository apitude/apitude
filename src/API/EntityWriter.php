<?php
namespace B2k\Apitude\API;


use B2k\Apitude\Entities\AbstractEntity;
use B2k\Apitude\Provider\ContainerAwareInterface;
use B2k\Apitude\Provider\ContainerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Proxy\Proxy;

class EntityWriter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    protected function getMetadataFactory()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->container['orm.em'];
        return $em->getMetadataFactory();
    }

    /**
     * @param AbstractEntity $entity
     */
    public function getArrayForEntity($entity)
    {
        $meta = $this->getMetadataFactory()->getMetadataFor($entity->getEntityClass());
    }
}
