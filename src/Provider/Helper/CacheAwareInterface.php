<?php
namespace Apitude\Provider\Helper;


use Doctrine\Common\Cache\Cache;

interface CacheAwareInterface
{
    /**
     * @return Cache
     */
    function getCache();
}
