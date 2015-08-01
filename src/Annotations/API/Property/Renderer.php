<?php
namespace Apitude\Annotations\API\Property;


use Doctrine\Common\Annotations\Annotation;

class Renderer extends Annotation
{
    public $renderService;
    public $renderMethod;
}
