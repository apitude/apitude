<?php
namespace Apitude\Core\Provider\Helper;

use Apitude\Core\Application;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityManagerAwareTrait
 * @property Application container
 */
trait EntityManagerAwareTrait
{
    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->container['orm.em'];
    }

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    protected function getMetadataFactory()
    {
        return $this->getEntityManager()->getMetadataFactory();
    }
}
