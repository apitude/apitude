<?php
namespace Apitude\Core\Annotations\API\Property;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Core\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
final class Expose extends Annotation
{
    public $name;
    public $accessRoles = [];
}
