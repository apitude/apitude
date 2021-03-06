<?php
namespace Apitude\Core\Provider;

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
            if (!$redis->connect($config['redis']['host'], $config['redis']['port'])) {
                throw new \RuntimeException('Unable to connect to redis server');
            }
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
