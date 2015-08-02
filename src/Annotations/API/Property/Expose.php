<?php
namespace Apitude\Annotations\API\Property;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
final class Expose extends Annotation
{
    public $name;
}
