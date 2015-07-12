<?php
namespace B2k\Apitude\Annotations\API;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package B2k\Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
final class PropertyExposure extends Annotation
{
    public $exposure = true;

    public function isExposed()
    {
        return $this->exposure;
    }
}
