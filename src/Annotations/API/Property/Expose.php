<?php
namespace B2k\Apitude\Annotations\API\Property;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package B2k\Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
final class Expose extends Annotation
{
    public $exposure = true;

    public function isExposed()
    {
        return $this->exposure;
    }
}
