<?php
namespace Provider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\Common\Cache\XcacheCache;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CacheServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['cache'] = $app->share(function ($app) {
            $config = $app['config'];
            if (! array_key_exists('cache.driver', $config)) {
                return new ArrayCache();
            }
            switch ($config['cache.driver']) {
                case 'array':
                    return new ArrayCache();
                case 'redis':
                    $cache = new RedisCache();
                    $cache->setRedis($app['redis']);
                    return $cache;
                case 'xcache':
                    return new XcacheCache();
                default:
                    throw new \RuntimeException('Unknown cache driver: '.$config['cache.driver']);
            }
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
