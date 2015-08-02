<?php

namespace Apitude\API\Writer;


class PropertyWriter
{
    public function renderISODateTime(\DateTime $dateTime)
    {
        return $dateTime->format('c');
    }
}