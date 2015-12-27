<?php
namespace Apitude\Core\API;

use Apitude\Core\API\Writer\ArrayWriter;
use Apitude\Core\API\Writer\PropertyWriter;
use Apitude\Core\Application;

/**
 * Class APIServiceAwareTrait
 * @property Application $container
 */
trait APIServiceAwareTrait
{
    /**
     * @return MetadataFactory
     */
    protected function getMetadataFactory()
    {
        return $this->container[MetadataFactory::class];
    }

    /**
     * @return ArrayWriter
     */
    protected function getArrayWriter()
    {
        return $this->container[ArrayWriter::class];
    }

    /**
     * @return PropertyWriter
     */
    protected function getPropertyWriter()
    {
        return $this->container[PropertyWriter::class];
    }
}
