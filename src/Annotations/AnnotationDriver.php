<?php
namespace B2k\Apitude\Annotations;

use Metadata\Driver\DriverInterface;

class AnnotationDriver implements DriverInterface
{

    /**
     * @param \ReflectionClass $class
     *
     * @return \Metadata\ClassMetadata
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        // TODO: Implement loadMetadataForClass() method.
    }
}