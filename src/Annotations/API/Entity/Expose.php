<?php
namespace Apitude\Core\Annotations\API\Entity;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Core\Annotations\API
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
final class Expose extends Annotation
{
    public $name;
}
