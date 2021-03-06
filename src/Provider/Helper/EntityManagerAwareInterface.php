<?php
namespace Apitude\Core\Provider\Helper;


use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\ORM\EntityManagerInterface;

interface EntityManagerAwareInterface
{
    /**
     * @return EntityManagerInterface
     */
    function getEntityManager();

    /**
     * @return ClassMetadataFactory
     */
    function getMetadataFactory();
}
