<?php
namespace B2k\Apitude\Annotations\API;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package B2k\Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
final class EntityExposure extends Annotation
{
    public $exposure;

    public function isExposed()
    {
        return $this->exposure;
    }
}
