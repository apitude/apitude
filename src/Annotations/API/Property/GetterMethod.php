<?php
namespace Apitude\Core\Annotations\API\Property;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Core\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
class GetterMethod extends Annotation
{
    public $method;
}
