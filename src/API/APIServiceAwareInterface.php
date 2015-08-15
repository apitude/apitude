<?php
namespace Apitude\Core\API;


use Apitude\Core\API\Writer\PropertyWriter;

interface APIServiceAwareInterface
{
    /**
     * @return MetadataFactory
     */
    function getMetadataFactory();

    /**
     * @return EntityWriter
     */
    function getObjectWriter();

    /**
     * @return PropertyWriter
     */
    function getPropertyWriter();
}
