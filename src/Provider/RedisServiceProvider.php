<?php
namespace Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class RedisServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['redis'] = $app->share(function ($app) {
            $config = $app['config'];
            $redis = new \Redis();
            $redis->connect($config['redis']['host'], $config['redis']['port']);
            return $redis;
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
