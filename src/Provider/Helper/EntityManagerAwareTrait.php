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
    public function getEntityManager()
    {
        return $this->container['orm.em'];
    }

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    public function getMetadataFactory()
    {
        return $this->getEntityManager()->getMetadataFactory();
    }
}
