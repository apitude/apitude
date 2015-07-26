<?php
namespace B2k\Apitude\Provider\Helper;

use B2k\Apitude\Application;
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
