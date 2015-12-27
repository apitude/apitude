<?php
namespace Apitude\Core\API;


use Apitude\Core\API\Writer\ArrayWriter;
use Apitude\Core\API\Writer\PropertyWriter;

interface APIServiceAwareInterface
{
    /**
     * @return MetadataFactory
     */
    function getMetadataFactory();

    /**
     * @return ArrayWriter
     */
    function getArrayWriter();

    /**
     * @return PropertyWriter
     */
    function getPropertyWriter();
}
