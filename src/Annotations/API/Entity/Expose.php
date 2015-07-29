<?php
namespace Apitude\Annotations\API\Entity;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Exposure
 * @package Apitude\Annotations\API
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
final class Expose extends Annotation
{
    public $exposure = true;

    public function isExposed()
    {
        return $this->exposure;
    }
}
