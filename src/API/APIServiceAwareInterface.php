<?php
namespace Apitude\API;


use Apitude\API\Writer\PropertyWriter;

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
