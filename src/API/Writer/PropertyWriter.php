<?php

namespace Apitude\Core\API\Writer;


use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

class PropertyWriter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function renderISODateTime(\DateTime $dateTime)
    {
        return $dateTime->format('c');
    }
}