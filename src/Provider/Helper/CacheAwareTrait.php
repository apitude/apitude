<?php
namespace Apitude\Core\Provider\Helper;

use Apitude\Core\Application;
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
