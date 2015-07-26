<?php
namespace B2k\Apitude\Entities;


use Doctrine\ORM\Proxy\Proxy;

abstract class AbstractEntity
{
    /**
     * Get Entity class
     * @return string
     */
    public function getEntityClass()
    {
        return $this instanceof Proxy ? get_parent_class($this) : self::class;
    }
}
