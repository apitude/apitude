<?php
namespace Apitude\Core\API\Helper;

use Apitude\Core\Entities\AbstractEntity;

trait APIEntityHelperTrait
{
    protected function getEntityClassFromType($entityType)
    {
        return str_replace('.', '\\', $entityType);
    }

    protected function getEntityTypeFromClass($entityClass)
    {
        return str_replace('\\', '.', $entityClass);
    }

    protected function getEntityTypeFromObject(AbstractEntity $entity)
    {
        return $this->getEntityTypeFromClass($entity->getEntityClass());
    }
}
