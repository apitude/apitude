<?php
namespace Apitude\Annotations\API\Property;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
class GetterMethod extends Annotation
{
    public $method;
}
