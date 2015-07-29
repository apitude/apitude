<?php
namespace Apitude\API;


use Apitude\Provider\ContainerAwareInterface;
use Apitude\Provider\ContainerAwareTrait;
use Apitude\Provider\Helper\CacheAwareInterface;
use Apitude\Provider\Helper\CacheAwareTrait;
use Apitude\Provider\Helper\EntityManagerAwareInterface;
use Apitude\Provider\Helper\EntityManagerAwareTrait;
use Metadata\ClassHierarchyMetadata;
use Metadata\MergeableClassMetadata;
use Metadata\MetadataFactoryInterface;

class MetadataFactory implements MetadataFactoryInterface, ContainerAwareInterface, CacheAwareInterface,
    EntityManagerAwareInterface
{
    use ContainerAwareTrait;
    use CacheAwareTrait;
    use EntityManagerAwareTrait;

    /**
     * Returns the gathered metadata for the given class name.
     *
     * If the drivers return instances of MergeableClassMetadata, these will be
     * merged prior to returning. Otherwise, all metadata for the inheritance
     * hierarchy will be returned as ClassHierarchyMetadata unmerged.
     *
     * If no metadata is available, null is returned.
     *
     * @param string $className
     *
     * @return ClassHierarchyMetadata|MergeableClassMetadata|null
     */
    public function getMetadataForClass($className)
    {
        $key = 'api.metadata.class.'.$className;
        if ($data = $this->getCache()->fetch($key)) {
            return $data;
        }


    }
}
