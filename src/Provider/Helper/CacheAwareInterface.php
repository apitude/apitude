<?php
namespace B2k\Apitude\Provider\Helper;


use Doctrine\Common\Cache\Cache;

interface CacheAwareInterface
{
    /**
     * @return Cache
     */
    function getCache();
}
