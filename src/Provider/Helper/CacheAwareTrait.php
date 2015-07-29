<?php
namespace Apitude\Provider\Helper;

use Apitude\Application;
use Doctrine\Common\Cache\Cache;

/**
 * Class CacheAwareTrait
 * @property Application container
 */
trait CacheAwareTrait
{
    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->container['cache'];
    }
}
