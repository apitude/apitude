<?php

namespace Apitude\API\Writer;


use Apitude\Provider\ContainerAwareInterface;
use Apitude\Provider\ContainerAwareTrait;

class PropertyWriter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function renderISODateTime(\DateTime $dateTime)
    {
        return $dateTime->format('c');
    }
}