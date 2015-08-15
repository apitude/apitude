<?php
namespace Apitude\Core\Provider\Helper;


use Doctrine\Common\Cache\Cache;

interface CacheAwareInterface
{
    /**
     * @return Cache
     */
    function getCache();
}
