<?php
namespace B2k\Apitude\Provider;


use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DoctrineServiceProvider implements ServiceProviderInterface
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
        $app->register(new \Silex\Provider\DoctrineServiceProvider, $app['config']['db.options']);
        $app->register(new DoctrineOrmServiceProvider, $app['config']['doctrine.options']);
        $app['em'] = $app->share(function ($app) {
            return $app['orm.ems.default'];
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
        // noop
    }
}
