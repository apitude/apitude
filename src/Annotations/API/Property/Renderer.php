<?php
namespace Apitude\Core\Annotations\API\Property;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Renderer
 * @package Apitude\Core\Annotations\API\Property
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
class Renderer extends Annotation
{
    public $renderService;
    public $renderMethod;
}
