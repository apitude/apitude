<?php
namespace Apitude\Core\Log;

use Psr\Log\LoggerInterface;

trait LoggerAwareTrait
{
    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->container['logger'];
    }
}
