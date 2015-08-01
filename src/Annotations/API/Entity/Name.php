<?php
namespace Apitude\Annotations\API\Entity;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Name
 * @package Apitude\Annotations\API\Entity
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
class Name extends Annotation
{
    public $name;
}
